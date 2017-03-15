<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_031755_update_founder_apply_permission extends Migration
{
    public function up()
    {
        $sql = <<<SQL
UPDATE  auth_item_child set parent='user' where child ='/mobile/member/founder-apply';
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161116_031755_update_founder_permission cannot be reverted.\n";

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
