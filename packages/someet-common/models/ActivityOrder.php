<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "activity_order".
 *
 * @property integer $id
 * @property string $order_no
 * @property integer $user_id
 * @property string $openid
 * @property string $username
 * @property string $mobile
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $activity_id
 * @property integer $answer_id
 * @property string $activity_title
 * @property string $activity_image
 * @property string $subject
 * @property string $body
 * @property integer $price
 * @property integer $discount
 * @property integer $pay_price
 * @property string $reject_desc
 * @property string $pingpp_id
 * @property integer $pay_time
 * @property integer $paid_time
 * @property integer $expire_time
 * @property integer $refund_status
 * @property string $currency
 * @property string $failure_msg
 * @property integer $failure_code
 * @property string $detail
 */
class ActivityOrder extends \yii\db\ActiveRecord
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
        return 'activity_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'updated_at', 'activity_id', 'answer_id', 'price', 'discount', 'pay_price', 'pay_time', 'paid_time', 'expire_time', 'refund_status', 'failure_code'], 'integer'],
            [['order_no', 'openid', 'username', 'activity_title', 'activity_image', 'subject', 'body', 'reject_desc', 'pingpp_id', 'currency', 'failure_msg', 'detail'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 45]
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
            'user_id' => 'User ID',
            'openid' => 'Openid',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'activity_id' => 'Activity ID',
            'answer_id' => 'Answer ID',
            'activity_title' => 'Activity Title',
            'activity_image' => 'Activity Image',
            'subject' => 'Subject',
            'body' => 'Body',
            'price' => 'Price',
            'discount' => 'Discount',
            'pay_price' => 'Pay Price',
            'reject_desc' => 'Reject Desc',
            'pingpp_id' => 'Pingpp ID',
            'pay_time' => 'Pay Time',
            'paid_time' => 'Paid Time',
            'expire_time' => 'Expire Time',
            'refund_status' => 'Refund Status',
            'currency' => 'Currency',
            'failure_msg' => 'Failure Msg',
            'failure_code' => 'Failure Code',
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

    /**
     * 报名信息
     * @return
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }

    /**
     * 活动信息
     * @return
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }
}
