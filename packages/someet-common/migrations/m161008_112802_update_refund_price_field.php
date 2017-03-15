<?php

use yii\db\Schema;
use yii\db\Migration;

class m161008_112802_update_refund_price_field extends Migration
{
    public function up()
    {
        $sql = <<<SQL
ALTER TABLE `refund`
CHANGE COLUMN `price` `price` float DEFAULT 0 COMMENT '退款金额';
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161008_112802_update_refund_price_field cannot be reverted.\n";

        return false;
    }
}
