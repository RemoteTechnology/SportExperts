<?php

namespace App\Services;

use App\Domain\Interfaces\Services\Auth\AuthenticationServiceInterface;
use App\Domain\Interfaces\Services\Auth\AuthenticationSocialServiceInterface;
use App\Domain\Interfaces\Services\Auth\AuthorizationServiceInterface;
use App\Domain\Interfaces\Services\Auth\LogoutServiceInterface;
use App\Exceptions\Auth\AuthenticationException;
use App\Models\User;
use App\Repository\Filter\Entities\Users\FindByEmailRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

class AuthService implements
    AuthenticationServiceInterface,
    AuthorizationServiceInterface,
    AuthenticationSocialServiceInterface,
    LogoutServiceInterface
{
    private FindByEmailRepository $filter;
    private UserRepository $operation;

    public function __construct(
        FindByEmailRepository $filter,
        UserRepository $operation
    )
    {
        $this->filter = $filter;
        $this->operation = $operation;
    }

    /**
     * @param string $sourceNumber
     * @return string
     */
    private static function phoneMask(string $sourceNumber): string
    {
        $cleanNumber = preg_replace('/\D/', '', $sourceNumber);

        $countryCode = '';
        if (strlen($cleanNumber) > 10) {
            $countryCode = substr($cleanNumber, 0, -10);
            $cleanNumber = substr($cleanNumber, -10);
        }

        $maskedNumber = preg_replace('/(\d{3})(\d{3})(\d{2})(\d{2})/', '($1) $2-$3-$4', $cleanNumber);

        if ($countryCode) {
            $maskedNumber = '+' . $countryCode . ' ' . $maskedNumber;
        }

        return $maskedNumber;
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    public function identificationByEmail(array $attributes): Model|null
    {
        $user = $this->filter->query([FIELD_EMAIL => $attributes[FIELD_LOGIN]]) ?? $this->filter->query([FIELD_PHONE => self::phoneMask($attributes[FIELD_LOGIN])]);
        if (isset($attributes[FIELD_GOOGLE_ID]) || Hash::check($attributes[FIELD_PASSWORD], $user->password))
        {
            return $user;
        }
        return null;
    }

    /**
     * @param User $user
     * @return string
     */
    public function generateBearerToken(User $user): string
    {
        $user->tokens()->delete();
        return $user->createToken('user_token')->plainTextToken;
    }

    /**
     * @param array $attributes
     * @return array|AuthenticationException
     */
    public function authorization(array $attributes): array|AuthenticationException
    {
        $user = $this->identificationByEmail($attributes);
        return !is_null($user) ? ['user' => $user, 'token' => $this->generateBearerToken($user)] : new AuthenticationException();
    }

    //TODO: Реализовать интерфейс AuthenticationSocialServiceInterface

    /**
     * @param User $user
     * @return void
     */
    public static function deleteBearerToken(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * @param mixed $userContext
     * @return Model
     */
    public function logout(mixed $userContext): Model
    {
        $user = $this->operation->findById($userContext[FIELD_ID]);
        self::deleteBearerToken($user);
        return $user;
    }

    /**
     * @param array $attributes
     * @return array|AuthenticationException
     */
    public function createOrAuthSocial(array $attributes): array|AuthenticationException
    {
        if (isset($attributes[FIELD_GOOGLE_ID])) {
            // Вход по гуглу
            if (!empty($this->operation->findByGoogleId($attributes[FIELD_GOOGLE_ID]))) {
                $attributes[FIELD_LOGIN] = $attributes[FIELD_EMAIL];
                return $this->authorization($attributes);
            } else {
                $this->operation->store($attributes);
                return $this->createOrAuthSocial($attributes);
            }
        } else {
            // Вход по вк
            return [];
        }
    }
}
