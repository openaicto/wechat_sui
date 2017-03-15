<?php

use yii\db\Schema;
use yii\db\Migration;

class m161107_122909_update_admin_log_field extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE admin_log CHANGE admin_agent admin_agent TEXT null COMMENT '操作人浏览器代理商';
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161107_122909_update_admin_log_field cannot be reverted.\n";

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
