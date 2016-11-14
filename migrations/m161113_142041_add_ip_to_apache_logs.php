<?php

use yii\db\Migration;

class m161113_142041_add_ip_to_apache_logs extends Migration
{
    public function up()
    {
        $this->addColumn('{{apache_logs}}', 'ip', 'varchar(255) NOT NULL');
    }

    public function down()
    {
        echo "m161113_142041_add_ip_to_apache_logs cannot be reverted.\n";

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
