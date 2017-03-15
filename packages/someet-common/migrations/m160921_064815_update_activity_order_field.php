<?php

use yii\db\Schema;
use yii\db\Migration;

class m160921_064815_update_activity_order_field extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE activity_order CHANGE COLUMN pingpp_id pingpp_id varchar(255) DEFAULT NULL COMMENT 'ping++的订单id';
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m160921_064815_update_activity_order_field cannot be reverted.\n";

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
