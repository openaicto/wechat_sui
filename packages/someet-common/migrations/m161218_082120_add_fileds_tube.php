<?php

use yii\db\Schema;
use yii\db\Migration;

class m161218_082120_add_fileds_tube extends Migration
{
    public function up()
    {
// ALTER TABLE `test_tube` ADD COLUMN `test` varchar(255) NULL AFTER `from`;
$sql = <<<SQL
ALTER TABLE `test_tube`
ADD COLUMN `from` varchar(255)  NULL COMMENT '来源' AFTER `sex`;
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161218_082120_add_fileds_tube cannot be reverted.\n";

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
