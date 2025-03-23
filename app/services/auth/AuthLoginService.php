<?php

namespace app\services\auth;

use app\repositories\contracts\AuthTokenRepositoryContract;
use app\repositories\contracts\UserRepositoryContract;
use app\services\auth\contracts\AuthLoginServiceContract;
use DomainException;
use Yii;

class AuthLoginService implements AuthLoginServiceContract
{
    private UserRepositoryContract $userRepository;
    private AuthTokenRepositoryContract $authTokenRepository;

    public function __construct(
        UserRepositoryContract $userRepository,
        AuthTokenRepositoryContract $authTokenRepository
    ) {
        $this->userRepository = $userRepository;
        $this->authTokenRepository = $authTokenRepository;
    }


    public function execute(string $username, string $password): string
    {

        $user = $this->userRepository->findOneByName($username);

        if (!$user || !Yii::$app->security->validatePassword($password, $user->password_hash)) {
            throw new DomainException('Invalid credentials', 401);
        }
        $token = Yii::$app->security->generateRandomString();
        $this->authTokenRepository->saveToken($token, $user->getId());
        return $token;
    }
}