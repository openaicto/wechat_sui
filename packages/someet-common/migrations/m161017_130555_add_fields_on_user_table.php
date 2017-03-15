<?php

use yii\db\Schema;
use yii\db\Migration;

class m161017_130555_add_fields_on_user_table extends Migration
{
    public function up()
    {
$sql = <<<SQL
ALTER TABLE `user`
ADD COLUMN `expire_time` INT(11) NULL DEFAULT 0 COMMENT '过期时间'
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161017_130555_add_fields_on_user_table cannot be reverted.\n";

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
