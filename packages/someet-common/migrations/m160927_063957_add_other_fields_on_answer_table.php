<?php

use yii\db\Schema;
use yii\db\Migration;

class m160927_063957_add_other_fields_on_answer_table extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE `answer`
ADD COLUMN `pay_time` INT(11) NULL DEFAULT 0 COMMENT '支付时间',
ADD COLUMN `pass_time` INT(11) NULL DEFAULT 0 COMMENT '通过报名的时间';
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
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
