<?php

namespace app\repositories;

use app\models\User;
use app\repositories\contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    /** @return array */
    public function findOneByName(string $username): ?User
    {
        return User::find()
            ->where(['username' => $username])
            ->one();
    }
}