<?php

use yii\db\Schema;
use yii\db\Migration;

class m161109_070438_add_table_invite_records extends Migration
{
    public function up()
    {
        $sql=<<<SQL
      CREATE TABLE `invite_records` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '邀请人的ID',
        `openid` varchar(100) DEFAULT NULL COMMENT '邀请人的openid',
        `invite_user_id` int(11) NOT NULL,
        `invite_openid` varchar(100) DEFAULT NULL,
        `created_time` int(11) DEFAULT 0,
        `invite_action` varchar(200) DEFAULT NULL COMMENT '邀请路径',
        `invite_vip` int(11) DEFAULT '0' COMMENT '被邀请人的会员等级',
        PRIMARY KEY (`id`)
      )
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161109_070438_add_table_invite_records cannot be reverted.\n";

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
