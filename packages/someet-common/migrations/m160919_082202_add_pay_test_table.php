<?php

use yii\db\Schema;
use yii\db\Migration;

class m160919_082202_add_pay_test_table extends Migration
{
    public function up()
    {
         $sql = <<<SQL

CREATE TABLE `pay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `pay_status` int(3) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        $this->dropTable('pay_log');
        return true;
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