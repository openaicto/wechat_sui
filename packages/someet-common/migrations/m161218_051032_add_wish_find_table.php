<?php

use yii\db\Schema;
use yii\db\Migration;

class m161218_051032_add_wish_find_table extends Migration
{
    public function up()
    {
$sql = <<<SQL
CREATE TABLE `wish_find` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161218_051032_add_wish_find_table cannot be reverted.\n";

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
