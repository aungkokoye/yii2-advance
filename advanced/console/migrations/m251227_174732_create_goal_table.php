<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goal}}`.
 */
class m251227_174732_create_goal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%goal}}', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(255)->notNull(),
            'created_by'    => $this->integer()->notNull(),
            'created_at'    => $this->dateTime()->notNull(),
            'updated_at'    => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-goal-created_by}}',
            '{{%goal}}',
            'created_by'
        );

        $this->addForeignKey(
            '{{%fk-goal-created_by}}',
            '{{%goal}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(
            '{{%fk-goal-created_by}}',
            '{{%goal}}'
        );

        $this->dropIndex(
            '{{%idx-goal-created_by}}',
            '{{%goal}}'
        );

        $this->dropTable('{{%goal}}');
    }
}
