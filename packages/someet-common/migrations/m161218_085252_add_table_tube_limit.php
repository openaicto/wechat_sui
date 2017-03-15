<?php

use yii\db\Schema;
use yii\db\Migration;

class m161218_085252_add_table_tube_limit extends Migration
{
    public function up()
    {
$sql = <<<SQL
CREATE TABLE `tube_limit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161218_085252_add_table_tube_limit cannot be reverted.\n";

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
