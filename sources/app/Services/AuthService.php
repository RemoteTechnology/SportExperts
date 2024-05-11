<?php

namespace App\Services;

use App\Domain\Interfaces\Repositories\Filters\Users\FindByEmailRepositoryInterface;
use App\Domain\Interfaces\Services\Auth\AuthenticationServiceInterface;
use App\Domain\Interfaces\Services\Auth\AuthenticationSocialServiceInterface;
use App\Domain\Interfaces\Services\Auth\AuthorizationServiceInterface;
use App\Domain\Interfaces\Services\Auth\LogoutServiceInterface;
use App\Exceptions\Auth\AuthenticationException;
use App\Models\User;
use App\Services\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

class AuthService implements
    AuthenticationServiceInterface,
    AuthorizationServiceInterface,
    AuthenticationSocialServiceInterface,
    LogoutServiceInterface
{
    use ValidationTrait;
    /**
     * @var FindByEmailRepositoryInterface
     */
    private FindByEmailRepositoryInterface $byEmailRepository;

    /**
     * @param FindByEmailRepositoryInterface $byEmailRepository;
     */
    public function __construct(FindByEmailRepositoryInterface $byEmailRepository)
    {
        $this->byEmailRepository = $byEmailRepository;
    }


    public function identificationByEmail(array $attributes): Model|null
    {
//        $user = $this->byEmailRepository->findByEmailQuery($attributes[FIELD_EMAIL]);
//        if (self::doubleToOldString($attributes[FIELD_PASSWORD], $user->password))
//        {
//        }
        return $this->byEmailRepository->findByEmailQuery($attributes[FIELD_EMAIL]);
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
    public function authorization(array $attributes): array
    {
        $user = $this->identificationByEmail($attributes);
        Auth::login($user);
        return ['user' => $user, 'token' => $this->generateBearerToken($user)];
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
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
