<?php

namespace app\repositories;

use app\repositories\contracts\AuthTokenRepositoryContract;

class AuthTokenRepository extends BaseRepository implements AuthTokenRepositoryContract
{
    public const string TABLE = 'auth_tokens';
    public function saveToken(string $token, int $userId): void
    {
        $this->getCommand()
            ->insert(
                self::TABLE,
                [
                    'token' => $token,
                    'user_id' => $userId,
                ]
            )->execute();
    }
}