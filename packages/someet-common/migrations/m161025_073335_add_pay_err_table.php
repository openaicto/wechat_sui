<?php

use yii\db\Schema;
use yii\db\Migration;

class m161025_073335_add_pay_err_table extends Migration
{
    public function up()
    {
        $sql = <<<SQL
CREATE TABLE `pay_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_result` text COMMENT 'pay 支付 结果',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `from_id` int(11) DEFAULT '0' COMMENT '来源id',
  `created_at` int(11) DEFAULT '0',
  `err_msg` text COMMENT '错误信息',
  `err_extra` text COMMENT '错误信息',
  `client_charge` text COMMENT '客户端的charge代码',
  `service_charge` text COMMENT '服务端的service charge代码',
  `desc` text COMMENT '备注',
  `status` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161025_073335_add_pay_err_table cannot be reverted.\n";

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
