<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $activity_id
 * @property integer $user_id
 * @property integer $is_finish
 * @property integer $is_send
 * @property integer $is_feedback
 * @property integer $send_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $wechat_template_push_at
 * @property integer $wechat_template_is_send
 * @property integer $wechat_template_msg_id
 * @property integer $join_noti_is_send
 * @property integer $join_noti_send_at
 * @property integer $join_noti_wechat_template_push_at
 * @property integer $join_noti_wechat_template_is_send
 * @property integer $join_noti_wechat_template_msg_id
 * @property integer $arrive_status
 * @property integer $leave_status
 * @property string $leave_msg
 * @property integer $apply_status
 * @property integer $cancel_apply_time
 * @property integer $leave_time
 * @property string $reject_reason
 * @property integer $pay_status
 * @property integer $price
 * @property integer $pay_time
 * @property integer $pass_time
 * @property integer $refunded
 * @property integer $paid
 * @property string $order_no
 * @property string $pingpp_id
 */
class Answer extends \yii\db\ActiveRecord
{   
    public $leave_str; //请假提醒
    public $view_status; //显示状态
    const PAY_YET = 10; //未支付
    const PAY_TIMEOUT = 15; //因支付超时导致支付失败
    const PAY_FAIL = 18; //支付失败
    const PAY_SUCCESS = 20; //支付成功
    const PAY_SUCCESS_OTHER = 25; //其他渠道支付
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
        self::PAY_TIMEOUT => '因支付超时导致支付失败',
        self::PAY_FAIL => '支付失败',
        self::PAY_SUCCESS => '支付成功',
        self::PAY_SUCCESS_OTHER => '其他渠道支付',
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
    /* 已退款 */
    const REFUNDED_YES = 1;
    /* 未退款 */
    const REFUNDED_NO = 0;
    /* 已支付 */
    const PAID_YES = 1;
    /* 未支付 */
    const PAID_NO = 0;
    /* 不可以报名 */
    const APPLY_NO = 1;
    /* 可以报名 */
    const APPLY_YES = 0;
    /* 未审核 */
    const STATUS_REVIEW_YET     = 10;
    /* 审核通过 */
    const STATUS_REVIEW_PASS    = 20;
    /* 审核拒绝 */
    const STATUS_REVIEW_REJECT  = 30;

    /* 短信未发送 */
    const STATUS_SMS_YET = 0;
    /* 短信发送成功 */
    const STATUS_SMS_SUCC = 1;
    /* 短信发送失败 */
    const STATUS_SMS_Fail = 2;
     /*好评*/
    const GOOD_SCORE = 1;
     /*中评*/
    const MIDDLE_SCORE = 2;
    /*差评*/
    const BAD_SCORE = 3;
    /*默认分数*/
    const DEFAULT_SCORE = 0;
    /* 微信模板消息未发送 */
    const STATUS_WECHAT_TEMPLATE_YET = 0;
    /* 微信模板消息发送成功 */
    const STATUS_WECHAT_TEMPLATE_SUCC = 1;
    /* 微信模板消息发送失败 */
    const STATUS_WECHAT_TEMPLATE_Fail = 2;

    /* 参加活动的短信未发送 */
    const JOIN_NOTI_IS_SEND_YET = 0;
    /* 参加活动的短信发送成功 */
    const JOIN_NOTI_IS_SEND_SUCC = 1;
    /* 参加活动的短信发送失败 */
    const JOIN_NOTI_IS_SEND_FAIL = 2;

    /* 未设置 */
    const STATUS_ARRIVE_NOT_SET = 10;
    /* 爽约 */
    const STATUS_ARRIVE_YET     = 0;
    /* 迟到 */
    const STATUS_ARRIVE_LATE    = 1;
    /* 准时 */
    const STATUS_ARRIVE_ON_TIME  = 2;

    /* 未请假 */
    const STATUS_LEAVE_YET    = 0;
    /* 已请假 */
    const STATUS_LEAVE_YES  = 1;

    /*  已反馈*/
    const FEEDBACK_IS    = 1;
    /* 未反馈 */
    const FEEDBACK_NO  = 0;

    /* 正常使用 */
    const APPLY_STATUS_YES = 0;
    /* 取消报名 */
    const APPLY_STATUS_YET = 1;
    const REFUNDED = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => behaviors\TimestampBehavior::className(),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id'], 'required'],
            [[
              'question_id', 'activity_id', 'user_id', 'is_finish', 'is_send',
              'is_feedback', 'send_at', 'created_at', 'updated_at', 'status',
              'wechat_template_push_at', 'wechat_template_is_send', 'wechat_template_msg_id',
              'join_noti_is_send', 'join_noti_send_at', 'join_noti_wechat_template_push_at',
              'join_noti_wechat_template_is_send', 'join_noti_wechat_template_msg_id', 'arrive_status',
              'leave_status', 'apply_status', 'cancel_apply_time', 'leave_time', 'price', 'pay_time',
              'pass_time', 'pay_status','refunded','paid',
            ], 'integer'],
            [['leave_msg'], 'string', 'max' => 180],
            [['reject_reason','order_no','pingpp_id'], 'string', 'max' => 255],
            [['status' ,'pay_status'], 'default', 'value' => 10],
            [['pay_time' ,'pass_time'], 'default', 'value' => 0],
            [['question_id', 'user_id'], 'unique', 'targetAttribute' => ['question_id', 'user_id'], 'message' => 'The combination of Question ID and User ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'activity_id' => 'Activity ID',
            'user_id' => 'User ID',
            'is_finish' => 'Is Finish',
            'is_send' => 'Is Send',
            'is_feedback' => 'Is Feedback',
            'send_at' => 'Send At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'wechat_template_push_at' => 'Wechat Template Push At',
            'wechat_template_is_send' => 'Wechat Template Is Send',
            'wechat_template_msg_id' => 'Wechat Template Msg ID',
            'join_noti_is_send' => 'Join Noti Is Send',
            'join_noti_send_at' => 'Join Noti Send At',
            'join_noti_wechat_template_push_at' => 'Join Noti Wechat Template Push At',
            'join_noti_wechat_template_is_send' => 'Join Noti Wechat Template Is Send',
            'join_noti_wechat_template_msg_id' => 'Join Noti Wechat Template Msg ID',
            'arrive_status' => 'Arrive Status',
            'leave_status' => 'Leave Status',
            'leave_msg' => 'Leave Msg',
            'apply_status' => 'Apply Status',
            'cancel_apply_time' => 'Cancel Apply Time',
            'leave_time' => 'Leave Time',
            'reject_reason' => 'Reject Reason',
            'pay_status' => 'Pay Status',
            'price' => 'Price',
            'pay_time' => 'Pay Time',
            'pass_time' => 'Pass Time',
            'refunded' => 'Refunded',
            'paid' => 'Paid',
            'order_no' => 'Order No',
            'pingpp_id' => 'Pingpp ID',
            'leave_str' => 'leave_str',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->user_id = Yii::$app->user && Yii::$app->user->id > 0 ? Yii::$app->user->id : 0;
            }
            return true;
        } else {
            return false;
        }
    }

    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['wechat_template_push_at'],
            $fields['wechat_template_is_send'],
            $fields['wechat_template_msg_id'],
            $fields['join_noti_is_send'],
            $fields['join_noti_send_at'],
            $fields['join_noti_wechat_template_push_at'],
            $fields['join_noti_wechat_template_is_send'],
            $fields['join_noti_wechat_template_msg_id']
        );

        return $fields;
    }

    public function extraFields()
    {
        return ['user', 'activity', 'answerItemList',  'user.profile'  => function () {
            return $this->user ? $this->user->profile: null;
        }];
    }
    /**
     * 回答项列表
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerItemList()
    {
        return $this->hasMany(AnswerItem::className(), ['question_id' => 'question_id', 'user_id' => 'user_id']);
    }

    /**
     * 活动
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * 活动
     * @return \yii\db\ActiveQuery
     */
    public function getActivityOrder()
    {
        return $this->hasOne(ActivityOrder::className(), ['answer_id' => 'id']);
    }

    /**
     * 用户
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
