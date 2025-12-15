<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m251211_223001_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%project}}', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(255)->notNull(),
            'tech_stack'    => $this->text()->notNull(),
            'description'   => $this->text()->notNull(),
            'start_date'    => $this->date()->notNull(),
            'end_date'      => $this->date()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%project}}');
    }
}
