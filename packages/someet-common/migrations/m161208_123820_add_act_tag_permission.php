<?php

use yii\db\Schema;
use yii\db\Migration;

class m161208_123820_add_act_tag_permission extends Migration
{
    public function up()
    {
        $items = [
        '/mobile/member/all-act' => ['user'],
        '/mobile/member/collect' => ['user'],
        '/mobile/member/collect-data' => ['user'],
        '/mobile/member/all-founder' => ['founder'],
        '/mobile/member/all-pma' => ['pma'],
        '/mobile/category/index' => ['user'],
        '/mobile/category/tag' => ['user'],
        '/mobile/category/act-week' => ['user'],
        '/mobile/category/tag-act-data' => ['user'],
        '/mobile/category/week-act' => ['user'],
        '/mobile/category/history-act' => ['user'],
        '/mobile/category/second-category' => ['user'],
        '/mobile/category/second-category-list' => ['user'],
        '/mobile/category/second-category-list' => ['user'],
        '/mobile/category/subscribe' => ['user'],
        '/mobile/user-act-tags/add-tag' => ['user'],
      ];

        $authItemTemplate = <<<SQL
      INSERT INTO auth_item (name, type, description, rule_name, data, created_at, updated_at) VALUES ('%s', '2', '', null, null, null, null);
SQL;
        $itemChildTemplate = <<<SQL
      INSERT INTO auth_item_child (parent, child) VALUES ('%s', '%s');
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
        echo "m161208_123820_add_act_tag_permission cannot be reverted.\n";

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
