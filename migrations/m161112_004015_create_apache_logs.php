<?php

use yii\db\Migration;

class m161112_004015_create_apache_logs extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{apache_logs}}', [
            'id' => $this->primaryKey(),
            'time' => 'INT(12) NOT NULL',
            'body' => 'TEXT NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );


    }

    public function down()
    {
        echo "m161112_004015_create_apache_logs cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
