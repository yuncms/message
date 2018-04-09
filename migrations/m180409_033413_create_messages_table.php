<?php

use yuncms\db\Migration;

/**
 * Handles the creation of table `messages`.
 */
class m180409_033413_create_messages_table extends Migration
{
    /**
     * @var string The table name.
     */
    public $tableName = '{{%messages}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->unsigned()->comment('Id'),
            'from_id' => $this->unsignedInteger()->notNull()->comment('Form Id'),
            'user_id' => $this->unsignedInteger()->notNull()->comment('User Id'),
            'parent' => $this->unsignedInteger()->comment('parent'),
            'message' => $this->string(750)->notNull()->comment('Message'),
            'status' => $this->boolean()->defaultValue(false)->comment('Status'),
            'created_at' => $this->unixTimestamp()->comment('Created At'),
            'updated_at' => $this->unixTimestamp()->comment('Updated At'),
        ], $tableOptions);

        $this->addForeignKey('messages_fk_1', $this->tableName, 'from_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('messages_fk_2', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
