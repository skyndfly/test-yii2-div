<?php

namespace app\models;

use yii\db\ActiveRecord;

//TODO переписать с использование геттеров
/**
 * @property int $id
 * @property string $token
 * @property int $user_id
 * @property int $created_at
 */
class AuthToken extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'auth_tokens';
    }
}