<?php

use yii\db\Schema;
use yii\db\Migration;

class m161217_171437_add_wish_error_table extends Migration
{
    public function up()
    {
$sql = <<<SQL
CREATE TABLE `wish_error` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `wish_id` int(11) DEFAULT NULL,
  `created_at` int(20) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `wechat_id` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161217_171437_add_wish_error_table cannot be reverted.\n";

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
