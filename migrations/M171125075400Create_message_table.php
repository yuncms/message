<?php

namespace yuncms\message\migrations;

use yii\db\Migration;

class M171125075400Create_message_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey()->unsigned()->comment('Id'),
            'from_id' => $this->integer()->unsigned()->notNull()->comment('Form Id'),
            'user_id' => $this->integer()->unsigned()->notNull()->comment('User Id'),
            'parent' => $this->integer()->unsigned()->comment('parent'),
            'message' => $this->string(750)->notNull()->comment('Message'),
            'status' => $this->boolean()->defaultValue(false)->comment('Status'),
            'created_at' => $this->integer()->unsigned()->comment('Created At'),
            'updated_at' => $this->integer()->unsigned()->comment('Updated At'),
        ], $tableOptions);

        $this->addForeignKey('{{%message_fk_1}}', '{{%message}}', 'from_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%message_fk_2}}', '{{%message}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171125075400Create_message_table cannot be reverted.\n";

        return false;
    }
    */
}
