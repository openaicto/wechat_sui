<?php

use yii\db\Schema;
use yii\db\Migration;

class m161020_052951_add_pingpp_callback_table extends Migration
{
    public function up()
    {
        $sql = <<<SQL
CREATE TABLE pingpp_callback (
  id int(11) NOT NULL AUTO_INCREMENT,
  pingpp_id varchar(255) NOT NULL DEFAULT '0' COMMENT '由 Ping++ 生成的支付对象 ID， 27 位字符串。',
  status tinyint(3) DEFAULT NULL,
  created_at int(11) DEFAULT NULL,
  object varchar(100) DEFAULT NULL COMMENT '值为 "charge"。',
  created int(11) DEFAULT NULL COMMENT '支付创建时的 Unix 时间戳。',
  livemode varchar(100) DEFAULT NULL COMMENT '是否处于  live 模式。',
  paid int(11) DEFAULT NULL COMMENT '是否已付款。',
  refunded int(11) DEFAULT NULL COMMENT '是否存在退款信息，无论退款是否成功。',
  app varchar(100) DEFAULT NULL COMMENT '支付使用的  app 对象的  id ，expandable 可展开，查看 如何获取App ID 。',
  channel varchar(255) DEFAULT NULL COMMENT '支付使用的第三方支付渠道，详情参考 支付渠道属性值 。',
  order_no varchar(100) DEFAULT NULL COMMENT '商户订单号，适配每个渠道对此参数的要求，必须在商户系统内唯一。( alipay : 1-64 位，  wx : 2-32 位， bfb : 1-20 位， upacp : 8-40 位， yeepay_wap :1-50 位， jdpay_wap :1-30 位， cnp_u :8-20 位， cnp_f :8-20 位， cmb_wallet :10 位纯数字字符串。注：除 cmb_wallet 外的其他渠道推荐使用 8-20 位，要求数字或字母，不允许特殊字符)。',
  client_ip varchar(40) DEFAULT NULL COMMENT '发起支付请求客户端的 IP 地址，格式为 IPv4 整型，如 127.0.0.1。',
  amount float DEFAULT NULL COMMENT '订单总金额（必须大于0），单位为对应币种的最小货币单位，人民币为分。如订单总金额为 1 元， amount 为 100，么么贷商户请查看申请的借贷金额范围。',
  amount_settle float DEFAULT NULL COMMENT '清算金额，单位为对应币种的最小货币单位，人民币为分。',
  currency varchar(100) DEFAULT NULL COMMENT '3 位 ISO 货币代码，人民币为  cny 。',
  subject varchar(255) DEFAULT NULL COMMENT '商品标题，该参数最长为 32 个 Unicode 字符，银联全渠道（ upacp / upacp_wap ）限制在 32 个字节。',
  body varchar(255) DEFAULT NULL COMMENT '商品描述信息，该参数最长为 128 个 Unicode 字符， yeepay_wap 对于该参数长度限制为 100 个 Unicode 字符。',
  time_paid int(11) DEFAULT NULL COMMENT '订单支付完成时的 Unix 时间戳。（银联支付成功时间为接收异步通知的时间）',
  time_expire int(11) DEFAULT NULL COMMENT '订单失效时的 Unix 时间戳。时间范围在订单创建后的 1 分钟到 15 天，默认为 1 天，创建时间以 Ping++ 服务器时间为准。 微信对该参数的有效值限制为 2 小时内；银联对该参数的有效值限制为 1 小时内。',
  time_settle int(11) DEFAULT NULL COMMENT '订单清算时间，用 Unix',
  transaction_no varchar(40) DEFAULT NULL COMMENT '支付渠道返回的交易流水号。',
  amount_refunded float DEFAULT NULL COMMENT '已退款总金额，单位为对应币种的最小货币单位，例如：人民币为分。',
  failure_code varchar(255) DEFAULT NULL COMMENT '订单的错误码，详见 错误 中的错误码描述。',
  failure_msg varchar(255) DEFAULT NULL COMMENT '订单的错误消息的描述。',
  description varchar(255) DEFAULT NULL COMMENT '订单附加说明，最多 255 个 Unicode 字符。\n订单附加说明，最多 255 个 Unicode 字符。订单附加说明，最多 255 个 Unicode 字符。\n订单附加说明，最多 255 个 Unicode 字符。订单附加说明，最多 255 个 Unicode 字符。',
  PRIMARY KEY (id)
);
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m161020_052951_add_pingpp_callback_table cannot be reverted.\n";

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
