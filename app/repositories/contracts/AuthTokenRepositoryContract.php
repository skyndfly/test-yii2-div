<?php

namespace app\repositories\contracts;

interface AuthTokenRepositoryContract
{
    public function saveToken(string $token, int $userId): void;
}