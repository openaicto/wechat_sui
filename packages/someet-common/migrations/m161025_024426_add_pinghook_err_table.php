<?php

use yii\db\Schema;
use yii\db\Migration;

class m161025_024426_add_pinghook_err_table extends Migration
{
    public function up()
    {
        $sql = <<<SQL
CREATE TABLE `pinghook_err` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(255) DEFAULT NULL,
  `pingpp_id` varchar(200) DEFAULT NULL COMMENT 'ping++ id',
  `type` int(11) DEFAULT NULL COMMENT '类型 vip ：10 ；活动款：20 ；  退款：30 无法识别：40 ； 测试：50；',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `hook_created` int(11) DEFAULT NULL COMMENT 'hook创建时间',
  `note` text COMMENT '备注',
  `order_no` varchar(200) DEFAULT NULL,
  `amount` float DEFAULT NULL COMMENT '总价格',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `from_id` int(11) DEFAULT NULL COMMENT '来源id',
  `failure_msg` text,
  `failure_code` text,
  `status` tinyint(3) DEFAULT NULL COMMENT '备注',
  `callback` text COMMENT '回调数据',
  PRIMARY KEY (`id`)
);
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161025_024426_add_pinghook_err_table cannot be reverted.\n";

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
