<?php

use yii\db\Schema;
use yii\db\Migration;

class m161008_094309_add_fields_on_refund_table extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE `refund`
ADD COLUMN `user_id` INT(11) NULL DEFAULT 0,
ADD COLUMN `username` varchar(255) NULL DEFAULT NULL COMMENT '用户名',
ADD COLUMN `openid` varchar(255) NULL DEFAULT NULL COMMENT '微信id',
ADD COLUMN `mobile` varchar(45) NULL DEFAULT NULL COMMENT '手机号',
ADD COLUMN `answer_id` INT(11) NULL DEFAULT NULL;
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        $this->dropColumn('refund', 'user_id');
        $this->dropColumn('refund', 'username');
        $this->dropColumn('refund', 'openid');
        $this->dropColumn('refund', 'mobile');
        $this->dropColumn('refund', 'answer_id');
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
