<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "vip".
 *
 * @property integer $id
 * @property string $order_no
 * @property string $openid
 * @property integer $user_id
 * @property string $username
 * @property string $mobile
 * @property integer $level
 * @property integer $price
 * @property integer $discount
 * @property integer $pay_price
 * @property string $subject
 * @property string $body
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $pay_time
 * @property integer $paid_time
 * @property integer $expire_time
 * @property integer $refund_status
 * @property string $failure_msg
 * @property string $failure_code
 * @property string $pingpp_id
 * @property string $client_ip
 * @property string $currency
 * @property string $detail
 */
class Vip extends \yii\db\ActiveRecord
{
    const PAY_YET = 10; //未支付
    const PAY_SUCCESS = 20; //支付成功
    const PAY_FAIL = 23; //支付失败
    const PAY_TIMEOUT = 25; //因支付超时导致支付失败
    const FUNDS_ACCOUNT = 30; //资金到账
    const REFUND_APPLY = 40; //申请退款
    const REFUND_REJECT = 42; //退款驳回
    const REFUND_PROGRESS = 43; //退款中
    const REFUND_SUCCESS = 45; //退款成功
    const REFUND_FAIL = 47; //退款失败
    const FOUNDER_APPLY_BALANCE = 50; //发起人申请结算
    const FOUNDER_BALANCE_PROGRESS = 52; //发起人申请结算中
    const ROUNDER_BALANCE_SUCCESS = 55; //发起人计算成功
    const EXPIRE_VIP = 60;
    /**
     * @inheritdoc
     */
    public static $arrStatus = array(
        self::PAY_YET => '未支付',
        self::PAY_SUCCESS => '支付成功',
        self::PAY_FAIL => '支付失败',
        self::PAY_TIMEOUT => '因支付超时导致支付失败',
        self::FUNDS_ACCOUNT => '资金到账',
        self::REFUND_APPLY => '申请退款',
        self::REFUND_REJECT => '退款驳回',
        self::REFUND_PROGRESS => '退款中',
        self::REFUND_SUCCESS => '退款成功',
        self::REFUND_FAIL => '退款失败',
        self::FOUNDER_APPLY_BALANCE => '发起人申请结算',
        self::FOUNDER_BALANCE_PROGRESS => '发起人申请结算中',
        self::ROUNDER_BALANCE_SUCCESS => '发起人计算成功',
    );
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'level', 'price', 'discount', 'pay_price', 'status', 'created_at', 'updated_at', 'pay_time', 'paid_time', 'expire_time', 'refund_status'], 'integer'],
            [['order_no', 'openid', 'username', 'subject', 'body', 'failure_msg', 'failure_code', 'pingpp_id', 'client_ip', 'currency', 'detail'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 43],
            ['created_at', 'default', 'value' => time()],
            ['mobile', 'default', 'value' => '0'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'openid' => 'Openid',
            'user_id' => 'User ID',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'level' => 'Level',
            'price' => 'Price',
            'discount' => 'Discount',
            'pay_price' => 'Pay Price',
            'subject' => 'Subject',
            'body' => 'Body',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'pay_time' => 'Pay Time',
            'paid_time' => 'Paid Time',
            'expire_time' => 'Expire Time',
            'refund_status' => 'Refund Status',
            'failure_msg' => 'Failure Msg',
            'failure_code' => 'Failure Code',
            'pingpp_id' => 'Pingpp ID',
            'client_ip' => 'Client Ip',
            'currency' => 'Currency',
            'detail' => 'Detail',
        ];
    }

    /**
     * 用户信息
     * @return
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
