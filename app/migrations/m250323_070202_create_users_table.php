<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m250323_070202_create_users_table extends Migration
{
    public const TABLE_NAME = 'users';
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Добавляем индекс для поля username (опционально, но рекомендуется для ускорения поиска)
        $this->createIndex('idx-users-username', 'users', 'username', true);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
