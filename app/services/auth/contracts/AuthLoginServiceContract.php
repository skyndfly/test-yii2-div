<?php

namespace app\services\auth\contracts;

interface AuthLoginServiceContract
{
    public function execute(string $username, string $password): string;
}