<?php

use yii\db\Schema;
use yii\db\Migration;

class m160907_092838_vip_permission extends Migration
{
     public function up()
    {
    $items = [
            '/mobile/vip/index' => ['user'],
            '/mobile/vip/activity-order-json' => ['user'],
            '/mobile/vip/create-vip' => ['user'],
            '/mobile/vip/update-vip-level' => ['user'],
            '/mobile/vip/create-charge' => ['user'],
            '/mobile/pay/index' => ['user'],
            '/mobile/pay/activity-order-json' => ['user'],
            '/mobile/pay/finish' => ['user'],
            '/mobile/pay/failed' => ['user'],
            '/mobile/pay/create-charge' => ['user'],
            '/mobile/pay/vip-rule' => ['user'],
            '/mobile/pay/filled-answer' => ['user'],
            '/mobile/pay/inve-finish' => ['user'],
        ];

    $authItemTemplate = <<<SQL
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('%s', '2', '', null, null, null, null);
SQL;
    $itemChildTemplate = <<<SQL
    INSERT INTO `auth_item_child` (`parent`, `child`) VALUES ('%s', '%s');
SQL;
    $sql = '';
    foreach ($items as $item => $roles) {
        $sql .= sprintf($authItemTemplate, $item);
        foreach ($roles as $role) {
            $sql .= sprintf($itemChildTemplate, $role, $item);
        }
    }
    $this->execute($sql);
    return true;

    }

    public function down()
    {
        echo "m160907_092838_vip_permission cannot be reverted.\n";

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
