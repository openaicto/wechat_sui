<?php

use yii\db\Schema;
use yii\db\Migration;

class m161017_044838_add_inset_vip_info extends Migration
{
    public function up()
    {
        $sql = <<<SQL
        INSERT INTO vip_info (level,price,status,note) values('60','66','1','体验会员');
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161017_044838_add_inset_vip_info cannot be reverted.\n";

        return false;
    }
}
