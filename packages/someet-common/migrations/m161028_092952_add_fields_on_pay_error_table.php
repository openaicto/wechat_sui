<?php

use yii\db\Schema;
use yii\db\Migration;

class m161028_092952_add_fields_on_pay_error_table extends Migration
{
    public function up()
    {
    $sql = <<<SQL
ALTER TABLE `pay_error`
ADD COLUMN `origin_url` VARCHAR(255) NULL  COMMENT '来源url',
ADD COLUMN `mobile_type` VARCHAR(255) NULL  COMMENT '手机型号'
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161028_092952_add_fields_on_pay_error_table cannot be reverted.\n";

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
