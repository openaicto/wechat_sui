<?php

use yii\db\Schema;
use yii\db\Migration;

class m160918_115556_add_filed_user_vip extends Migration
{
    public function up()
    {
        $sql = <<<SQL
        ALTER TABLE `user` ADD COLUMN `vip` int(11) DEFAULT 0 COMMENT 'vip 等级' AFTER `username`;
SQL;
        $this->execute($sql);
        return true;

    }

    public function down()
    {
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
