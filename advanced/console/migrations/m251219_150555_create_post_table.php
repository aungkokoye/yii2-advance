<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m251219_150555_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%post}}', [
            'id'            => $this->primaryKey(),
            'title'         => $this->string(255)->notNull(),
            'body'          => $this->text()->notNull(),
            'is_published'  => $this->boolean(),
            'slug'          => $this->string(255)->notNull()->unique(),
            'created_at'    => $this->dateTime()->notNull(),
            'updated_at'    => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%post}}');
    }
}
