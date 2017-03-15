<?php

use yii\db\Schema;
use yii\db\Migration;

class m161114_120000_add_update_founder_permission extends Migration
{
    public function up()
    {
        $items = [
            '/mobile/member/info-founder' => ['user'],
            '/mobile/member/founder-apply' => ['founder'],
            '/mobile/member/founder-rule' => ['user'],
            '/mobile/member/founder-review' => ['user'],
            '/mobile/member/founder-success' => ['user'],
            '/mobile/activity/update-status' => ['user'],
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
        echo "m161114_120000_add_update_founder_permission cannot be reverted.\n";

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
