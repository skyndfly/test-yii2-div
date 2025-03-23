<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_tokens}}`.
 */
class m250323_070325_create_auth_tokens_table extends Migration
{
    public const TABLE_NAME = 'auth_tokens';

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'token' => $this->string()->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
