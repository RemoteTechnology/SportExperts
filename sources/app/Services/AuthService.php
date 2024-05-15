<?php

namespace App\Services;

use App\Domain\Interfaces\Repositories\Filters\Users\FindByEmailRepositoryInterface;
use App\Domain\Interfaces\Repositories\LCRUD_OperationInterface;
use App\Domain\Interfaces\Services\Auth\AuthenticationServiceInterface;
use App\Domain\Interfaces\Services\Auth\AuthenticationSocialServiceInterface;
use App\Domain\Interfaces\Services\Auth\AuthorizationServiceInterface;
use App\Domain\Interfaces\Services\Auth\LogoutServiceInterface;
use App\Exceptions\Auth\AuthenticationException;
use App\Models\User;
use App\Services\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

class AuthService implements
    AuthenticationServiceInterface,
    AuthorizationServiceInterface,
    AuthenticationSocialServiceInterface,
    LogoutServiceInterface
{
    use ValidationTrait;

    private FindByEmailRepositoryInterface $byEmailRepository;
    private LCRUD_OperationInterface $operation;

    public function __construct(
        FindByEmailRepositoryInterface $byEmailRepository,
        LCRUD_OperationInterface $operation
    )
    {
        $this->byEmailRepository = $byEmailRepository;
        $this->operation = $operation;
    }


    public function identificationByEmail(array $attributes): Model|null
    {
        $user = $this->byEmailRepository->findByEmailQuery($attributes[FIELD_EMAIL]);
        if (Hash::check($attributes['password'], $user->password))
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
     * @return array
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
        $user = $this->operation->findById($userContext['id']);
        self::deleteBearerToken($user);
        return $user;
    }
}
