<?php

use yii\db\Schema;
use yii\db\Migration;

class m160824_074306_add_fields_on_investination extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE `investigation`
ADD COLUMN `ext1` VARCHAR(255) NULL DEFAULT NULL AFTER `reason_first`,
ADD COLUMN `ext2` VARCHAR(255) NULL DEFAULT NULL AFTER `ext1`,
ADD COLUMN `ext3` VARCHAR(255) NULL DEFAULT NULL AFTER `ext2`,
ADD COLUMN `ext4` VARCHAR(255) NULL DEFAULT NULL AFTER `ext3`,
ADD COLUMN `ext5` VARCHAR(255) NULL DEFAULT NULL AFTER `ext4`,
ADD UNIQUE INDEX `uni_user` (`user_id` ASC);
SQL;
        $this->execute($sql);
        return true;

    }

    public function down()
    {
        $this->dropColumn('investigation', 'ext1');
        $this->dropColumn('investigation', 'ext2');
        $this->dropColumn('investigation', 'ext3');
        $this->dropColumn('investigation', 'ext4');
        $this->dropColumn('investigation', 'ext5');
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
