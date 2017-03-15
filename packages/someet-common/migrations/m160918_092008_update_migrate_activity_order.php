<?php

use yii\db\Schema;
use yii\db\Migration;

class m160918_092008_update_migrate_activity_order extends Migration
{
    public function up()
    {
        $sql = <<<SQL
        DROP TABLE IF EXISTS `activity_order`;
        CREATE TABLE `activity_order` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `order_no` varchar(255) DEFAULT '' COMMENT 'act前缀 + 年月日时分秒 + 4位随机数字',
          `user_id` int(11) unsigned DEFAULT '0' COMMENT '用户id',
          `openid` varchar(255) DEFAULT NULL COMMENT '微信openid 可以用来发push消息使用',
          `username` varchar(255) DEFAULT NULL COMMENT '用户昵称',
          `mobile` varchar(45) DEFAULT '0' COMMENT '手机号',
          `status` tinyint(3) DEFAULT '10' COMMENT '默认未支付 : 10; 支付成功 : 20; 支付失败 Ping++ or 网络造成的支付失败 : 23; 因支付超时导致支付失败 : 25; 资金到账 : 30; 申请退款 : 40; 退款驳回 : 42; 退款中 : 43; 退款成功 : 45; 退款失败 : 47; 发起人申请结算 : 50; 发起人申请结算中 : 52; 发起人计算成功: 55;',
          `created_at` int(11) DEFAULT NULL COMMENT '订单创建时间',
          `updated_at` int(11) DEFAULT NULL COMMENT '订单更新时间',
          `activity_id` int(11) unsigned DEFAULT '0' COMMENT '活动id',
          `answer_id` int(11) DEFAULT NULL COMMENT '报名id',
          `activity_title` varchar(255) DEFAULT NULL COMMENT '活动标题',
          `activity_image` varchar(255) DEFAULT '' COMMENT '活动题图',
          `subject` varchar(255) DEFAULT NULL COMMENT '商品标题 ping++使用',
          `body` varchar(255) DEFAULT NULL COMMENT '商品描述 ping++使用',
          `price` int(11) DEFAULT '0' COMMENT '活动价格',
          `discount` int(10) unsigned DEFAULT '100' COMMENT '折扣 默认为100',
          `pay_price` int(11) DEFAULT '0' COMMENT '支付价格 实际支付价格  有可能会打折',
          `reject_desc` varchar(255) DEFAULT NULL COMMENT '驳回原因',
          `pingpp_id` int(11) DEFAULT NULL COMMENT 'ping++的订单id',
          `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
          `paid_time` int(11) DEFAULT NULL COMMENT '订单支付完成时的 Unix 时间戳。（银联支付成功时间为接收异步通知的时间）',
          `expire_time` int(11) DEFAULT NULL COMMENT '订单失效时的 Unix 时间戳。时间范围在订单创建后的 1 分钟到 15 天，默认为 1 天，创建时间以 Ping++ 服务器时间为准。 微信对该参数的有效值限制为 2小时内；银联对该参数的有效值限制为 1 小时内。',
          `refund_status` int(3) unsigned DEFAULT NULL COMMENT '是否存在退款信息，无论退款是否成功。 存在:1; 不存在:0;',
          `currency` varchar(255) DEFAULT NULL COMMENT '3 位 ISO 货币代码，人民币为  cny 。',
          `failure_msg` varchar(255) DEFAULT NULL COMMENT '失败信息',
          `failure_code` int(11) DEFAULT NULL COMMENT '失败标识码',
          `detail` varchar(255) DEFAULT NULL COMMENT '订单说明',
          PRIMARY KEY (`id`)
        );
        CREATE TABLE `vip` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号：vip +等级 +年月日时分秒 + 2位随机数字',
          `openid` varchar(255) NOT NULL DEFAULT '0' COMMENT '微信id',
          `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
          `username` varchar(255) DEFAULT NULL COMMENT '用户名字',
          `mobile` varchar(43) NOT NULL DEFAULT '' COMMENT '手机号',
          `level` int(11) NOT NULL DEFAULT '0' COMMENT 'vip类型级别',
          `price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单价格',
          `discount` int(11) DEFAULT '0' COMMENT '折扣',
          `pay_price` int(11) DEFAULT '0' COMMENT '实际支付金额',
          `subject` varchar(255) DEFAULT NULL COMMENT '商品标题',
          `body` varchar(255) DEFAULT NULL COMMENT '商品描述',
          `status` tinyint(4) DEFAULT '10' COMMENT '订单状态 默认未支付 : 10; 支付成功 : 20; 支付失败 : 23; 因支付超时导致支付失败 : 25; 资金到账 : 30; 申请退款 : 40; 退款驳回 : 42; 退款中 : 43; 退款成功 : 45; 退款失败 : 47;',
          `created_at` int(11) DEFAULT '0' COMMENT '订单创建时间',
          `updated_at` int(11) DEFAULT '0' COMMENT '订单更新时间',
          `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',
          `paid_time` int(11) DEFAULT '0' COMMENT '订单支付完成时的 Unix 时间戳。（银联支付成功时间为接收异步通知的时间）',
          `expire_time` int(11) DEFAULT '0' COMMENT '订单失效时的 Unix 时间戳。时间范围在订单创建后的 1 分钟到 15 天，默认为 1 天，创建时间以 Ping++ 服务器时间为准。 微信对该参数的有效值限制为 2小时内；银联对该参数的有效值限制为 1 小时内。',
          `refund_status` tinyint(3) DEFAULT '0' COMMENT '是否存在退款信息，无论退款是否成功。 存在:1; 不存在:0;',
          `failure_msg` varchar(255) DEFAULT NULL COMMENT '失败信息',
          `failure_code` varchar(255) DEFAULT NULL COMMENT '失败标识码',
          `pingpp_id` varchar(255) DEFAULT '0' COMMENT 'ping++id',
          `client_ip` varchar(255) DEFAULT NULL COMMENT '用户ip',
          `currency` varchar(255) DEFAULT NULL COMMENT '3 位 ISO 货币代码，人民币为  cny 。',
          `detail` varchar(255) DEFAULT NULL COMMENT '订单说明',
          PRIMARY KEY (`id`)
        );


        DROP TABLE IF EXISTS `vip_info`;
        CREATE TABLE `vip_info` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `level` int(11) DEFAULT NULL,
          `price` int(11) DEFAULT NULL,
          `status` int(11) DEFAULT NULL,
          `create_at` int(11) DEFAULT NULL,
          `note` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;


        BEGIN;
        INSERT INTO `vip_info` VALUES ('1', '10', '49', '1', null, 'vip1'), ('2', '20', '79', '1', null, 'vip2'), ('3', '30', '89', '1', null, 'vip3'), ('4', '40', '249', '1', null, 'vip4'), ('5', '50', '999', '1', null, 'vip5');
        COMMIT;
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m160918_092008_update_migrate_activity_order cannot be reverted.\n";

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
