<?php

use yii\db\Schema;
use yii\db\Migration;

class m160923_064928_add_fields_on_answer_table extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE `answer`
ADD COLUMN `pay_status` TINYINT(3) NULL DEFAULT 10 COMMENT '默认未支付 : 10; 因支付超时导致支付失败 : 15; 支付失败 Ping++ or 网络造成的支付失败 : 18; 支付成功 : 20; 资金到账 : 30; 申请退款 : 40; 退款驳回 : 42; 退款中 : 43; 退款成功 : 45; 退款失败 : 47; 发起人申请结算 : 50; 发起人申请结算中 : 52; 发起人计算成功: 55;',
ADD COLUMN `price` int(11) DEFAULT 0 COMMENT '支付价格' AFTER `pay_status`;
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        $this->dropColumn('answer', 'pay_status');
        $this->dropColumn('answer', 'pay_time');
        $this->dropColumn('answer', 'pass_time');
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
