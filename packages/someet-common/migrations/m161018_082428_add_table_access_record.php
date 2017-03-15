<?php

use yii\db\Schema;
use yii\db\Migration;

class m161018_082428_add_table_access_record extends Migration
{
    public function up()
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `access_records` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `action_name` VARCHAR(180) NOT NULL COMMENT '访问名称',
        `user_id` INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
        `status` TINYINT(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '待用',
        `created_at` INT(11) UNSIGNED NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8mb4
        COMMENT = '首次访问记录';
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        $this->dropTable('{{%r_user_activity}}');
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
