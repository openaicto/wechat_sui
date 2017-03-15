<?php

use yii\db\Schema;
use yii\db\Migration;

class m160923_030144_add_refund_table extends Migration
{
    public function up()
    {
         $sql = <<<SQL

CREATE TABLE refund (
  id int(11) NOT NULL AUTO_INCREMENT,
  refund_order_no varchar(255) DEFAULT '0' COMMENT '退款订单号',
  order_no varchar(255) DEFAULT '0' COMMENT '订单号',
  pingpp_id varchar(255) DEFAULT '0' COMMENT 'ping++ id',
  handle_person int(11) DEFAULT '0' COMMENT '操作退款的人',
  price int(11) DEFAULT '0' COMMENT '退款金额',
  status tinyint(3) DEFAULT '10' COMMENT '退款状态（目前支持三种状态: pending: 处理中 10 默认; succeeded: 成功 20; failed: 失败 30）。',
  succeed tinyint(3) DEFAULT NULL COMMENT '退款是否成功 失败:0; 成功:1;',
  description varchar(255) DEFAULT '0' COMMENT '退款描述',
  created_at int(11) DEFAULT NULL COMMENT '退款创建的时间，用 Unix 时间戳表示。',
  time_succeed int(11) DEFAULT NULL COMMENT '退款成功的时间，用 Unix 时间戳表示。',
  transaction_no varchar(255) DEFAULT '0' COMMENT '支付渠道返回的交易流水号，部分渠道返回该字段为空。',
  failure_msg varchar(255) DEFAULT NULL COMMENT '支付渠道返回的交易流水号，部分渠道返回该字段为空。',
  failure_code varchar(255) DEFAULT NULL COMMENT '退款的错误码，详见 错误 中的错误码。',
  PRIMARY KEY (id)
)
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        $this->dropTable('refund');
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