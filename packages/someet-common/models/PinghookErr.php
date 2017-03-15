<?php

namespace someet\common\models;

/**
 * This is the model class for table "pinghook_err".
 *
 * @property int $id
 * @property string $pingpp_id
 * @property int $type
 * @property string $callback
 * @property float $amount
 * @property int $user_id
 * @property int $from_id
 * @property string $note
 * @property int $created_at
 * @property int $hook_created
 * @property string $object
 * @property string $order_no
 * @property string $failure_msg
 * @property string $failure_code
 * @property int $status
 */
class PinghookErr extends \yii\db\ActiveRecord
{
    /** *  vip */
    const TYPE_VIP = 10;

    /** * 活动订单 */
    const TYPE_ORDER = 20;

    /** 退款订单 */
    const TYPE_REFUND = 30;

    /** 无法识别 */
    const TYPE_UNABLE_TO_IDENTIFY = 40;

    /** 测试 */
    const TYPE_TEST = 50;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pinghook_err';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'from_id', 'created_at', 'hook_created', 'status'], 'integer'],
            [['callback', 'note', 'failure_msg', 'failure_code'], 'string'],
            [['amount'], 'number'],
            [['pingpp_id', 'order_no'], 'string', 'max' => 200],
            [['object'], 'string', 'max' => 255],
            ['created_at', 'default', 'value' => time()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pingpp_id' => 'Pingpp ID',
            'type' => 'Type',
            'callback' => 'Callback',
            'amount' => 'Amount',
            'user_id' => 'User ID',
            'from_id' => 'From ID',
            'note' => 'Note',
            'created_at' => 'Created At',
            'hook_created' => 'Hook Created',
            'object' => 'Object',
            'order_no' => 'Order No',
            'failure_msg' => 'Failure Msg',
            'failure_code' => 'Failure Code',
            'status' => 'Status',
        ];
    }
}
