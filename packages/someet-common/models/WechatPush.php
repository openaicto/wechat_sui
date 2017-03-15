<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "wechat_push".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $answer_id
 * @property integer $type
 * @property integer $from_id
 * @property string $from_type
 * @property integer $user_id
 * @property string $data
 * @property integer $join_queue_at
 * @property integer $sended_at
 * @property string $note
 * @property string $openid
 * @property string $url
 * @property string $template_id
 * @property integer $timing
 * @property integer $created_at
 * @property integer $callback_id
 * @property string $callback_msg
 * @property integer $callback_status
 */
class WechatPush extends \yii\db\ActiveRecord
{
    // 状态
    /* 没有加入队列 默认 */
    const STATUS_DEFAULT = 10;
    /* 加入队列成功 */
    const STATUS_JOIN_QUEUE = 20;
    /* 加入队列失败 */
    const STATUS_JOIN_QUEUE_FAIL = 25;
    /* 发送成功 */
    const STATUS_SEND_SUCCESS = 30;
    /* 发送失败 */
    const STATUS_SEND_FAIL = 35;

    // 回调状态
    /* 通知发送状态成功 */
    const CALLBACK_STATUS_SUCCESS = 10;
    /* 通知发送状态失败 */
    const CALLBACK_STATUS_FAILURE = 20;

    // 类型
    const TYPE_DEFAULT = 0;
    /* 用户报名通过 */
    const TYPE_APPLY_PASS = 10;
    /* 用户报名不通过 */
    const TYPE_APPLY_REJECT = 11;
    /* 支付即将过期 */
    const TYPE_PAY_EXPIRE = 12;
    /* 会员到期提醒 */
    const TYPE_VIP_EXPIRE = 13;
    /* 活动前提醒 */
    const TYPE_ACT_BEFORE = 14;
    /* 活动结束后反馈提醒 */
    const TYPE_ACT_FEADBACK = 15;
    /* 退款通知 */
    const TYPE_REFUND = 16;
    /* 申诉成功 */
    const TYPE_APPEAL_SUCCESS = 17;
    /* 活动签到 */
    const TYPE_CHECK_IN = 18;

    // 信用变更
    const TYPE_CREDIT_CHANGE = 20;
    /* 请假黄牌 */
    const TYPE_USER_LEAVE = 21;
    /* 迟到黄牌 */
    const TYPE_USER_LATE =  22;
    /* 爽约黄牌 */
    const TYPE_USER_ABSENT = 23;
    /* 用户取消报名 */
    const TYPE_USER_CANCEL_APPLY = 24;


    /* 活动取消 */
    const TYPE_ACT_CANCEL = 30;

    // 发起人
    /* 用户报名 */
    const TYPE_USER_APPLY = 40;
    /* 活动发布提醒 */
    const TYPE_ACT_RELEASE = 41;
    /* 活动结算 */
    const TYPE_ACT_BALANCE = 42;
    /* 发起人反馈提醒 */
    const TYPE_FOUNDER_FEADBACK = 43;

    public static $arrType = [
        self::TYPE_CREDIT_CHANGE => '用户信用变更消息提醒',
        self::TYPE_USER_LEAVE => '请假消息提醒',
        self::TYPE_USER_LATE => '迟到消息提醒',
        self::TYPE_USER_ABSENT => '爽约消息提醒',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'answer_id', 'type', 'from_id', 'user_id', 'join_queue_at', 'sended_at', 'timing', 'created_at', 'callback_id', 'callback_status'], 'integer'],
            [['data'], 'required'],
            [['data'], 'string'],
            [['from_type', 'note', 'url', 'template_id'], 'string', 'max' => 100],
            [['openid'], 'string', 'max' => 40],
            [['callback_msg'], 'string', 'max' => 255],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => 10],
            ['type', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'answer_id' => 'Answer ID',
            'type' => 'Type',
            'from_id' => 'From ID',
            'from_type' => 'From Type',
            'user_id' => 'User ID',
            'data' => 'Data',
            'join_queue_at' => 'Join Queue At',
            'sended_at' => 'Sended At',
            'note' => 'Note',
            'openid' => 'Openid',
            'url' => 'Url',
            'template_id' => 'Template ID',
            'timing' => 'Timing',
            'created_at' => 'Created At',
            'callback_id' => 'Callback ID',
            'callback_msg' => 'Callback Msg',
            'callback_status' => 'Callback Status',
        ];
    }
}
