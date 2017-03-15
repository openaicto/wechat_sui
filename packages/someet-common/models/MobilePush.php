<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "mobile_push".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property integer $mobile
 * @property string $content
 * @property integer $answer_id
 * @property integer $type
 * @property integer $status
 * @property integer $sended_at
 * @property integer $join_queue_at
 * @property integer $created_at
 * @property string $note
 */
class MobilePush extends \yii\db\ActiveRecord
{
    // 状态
    /* 没有加入队列 默认 */
    const STATUS_DEFAULT = 10;
    /* 加入队列成功 */
    const STATUS_JOIN_QUEUE = 20;
    /* 加入队列失败 */
    const STATUS_JOIN_QUEUE_FAIL =25;
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
    /* 活动签到 */
    const TYPE_CHECK_IN = 17;

    // 信用变更
    /* 请假黄牌 */
    const TYPE_USER_LEAVE = 20;
    /* 迟到黄牌 */
    const TYPE_USER_LATE =  21;
    /* 爽约黄牌 */
    const TYPE_USER_ABSENT = 22;
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
    /* 申诉成功 */
    const TYPE_APPEAL_SUCCESS = 44;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'answer_id', 'type', 'status', 'sended_at', 'join_queue_at', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['username', 'note'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'content' => 'Content',
            'answer_id' => 'Answer ID',
            'type' => 'Type',
            'status' => 'Status',
            'sended_at' => 'Sended At',
            'join_queue_at' => 'Join Queue At',
            'created_at' => 'Created At',
            'note' => 'Note',
        ];
    }
}
