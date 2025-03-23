<?php

namespace app\repositories\contracts;

use app\models\User;

interface UserRepositoryContract
{
    public function findOneByName(string $username): ?User;
}