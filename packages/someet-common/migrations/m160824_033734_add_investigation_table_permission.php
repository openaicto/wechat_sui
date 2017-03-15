<?php

use yii\db\Schema;
use yii\db\Migration;

class m160824_033734_add_investigation_table_permission extends Migration
{
    public function up()
    {
        $sql = <<<SQL

CREATE TABLE `investigation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_type` tinyint(2) DEFAULT NULL COMMENT '0 关注后从未报名的用户 1 成功报名并参加活动，缺未再报名的用户  2 成功报名并参加活动，有再次报名行为',
  `status` tinyint(2) DEFAULT NULL COMMENT '0 学生 1 上班族',
  `job` varchar(255) DEFAULT NULL COMMENT '你现在做什么',
  `income` tinyint(2) DEFAULT NULL COMMENT '0 三千以下 1 3000-5000 2 5000-8000 3 8000-10000 4 10000-15000 5 15000-20000 6 20000以上',
  `reason_none` varchar(255) DEFAULT NULL COMMENT '0 没有时间线下参与 1 不知道如何报名参加 2 没有感兴趣的活动 3 很多活动不知道是做什么的 4 我在外地',
  `vip` tinyint(2) DEFAULT NULL COMMENT '0 普通会员：59/3个月无限次报名 1 高级会员 99/半年无限次报名 2 超级会员 239／半年无限次报名＋超级周边大礼包 3 钻石会员 999元／全年无限次报名＋专属钻石会员活动＋新活动首先体验 4 以上我都不想选择',
  `like` varchar(255) DEFAULT NULL COMMENT '0 有同类兴趣或经历的轻聊天式活动 1 奇葩小众的活动 2 有大牛带着我get新技能，可以成长补给自己的活动 3 一起探索城市独立小店的活动 4 自己动手打造品质生活的活动 5 让人打开心扉深度畅聊的活动 6 一起培养艺术细菌',
  `say` varchar(2000) DEFAULT NULL COMMENT '还有什么想告诉我们的',
  `reason_first` varchar(255) DEFAULT NULL COMMENT '0 没有时间线下参与了 1 没有感兴趣的活动 2 我在外地 3 第一次参加活动后，感觉体验不好',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SQL;
        $this->execute($sql);
        return true;

    }

    public function down()
    {
        $this->dropTable('investigation');
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
