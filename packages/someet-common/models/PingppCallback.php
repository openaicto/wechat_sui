<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "pingpp_callback".
 *
 * @property integer $id
 * @property string $pingpp_id
 * @property integer $status
 * @property integer $created_at
 * @property string $object
 * @property integer $created
 * @property string $livemode
 * @property integer $paid
 * @property integer $refunded
 * @property string $app
 * @property string $channel
 * @property string $order_no
 * @property string $client_ip
 * @property double $amount
 * @property double $amount_settle
 * @property string $currency
 * @property string $subject
 * @property string $body
 * @property integer $time_paid
 * @property integer $time_expire
 * @property integer $time_settle
 * @property string $transaction_no
 * @property double $amount_refunded
 * @property string $failure_code
 * @property string $failure_msg
 * @property string $description
 */
class PingppCallback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pingpp_callback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'created', 'paid', 'refunded', 'time_paid', 'time_expire', 'time_settle'], 'integer'],
            [['amount', 'amount_settle', 'amount_refunded'], 'number'],
            [['pingpp_id', 'channel', 'subject', 'body', 'failure_code', 'failure_msg', 'description'], 'string', 'max' => 255],
            [['object', 'livemode', 'app', 'order_no', 'currency'], 'string', 'max' => 100],
            [['client_ip', 'transaction_no'], 'string', 'max' => 40],
            ['created_at', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pingpp_id' => 'Pingpp ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'object' => 'Object',
            'created' => 'Created',
            'livemode' => 'Livemode',
            'paid' => 'Paid',
            'refunded' => 'Refunded',
            'app' => 'App',
            'channel' => 'Channel',
            'order_no' => 'Order No',
            'client_ip' => 'Client Ip',
            'amount' => 'Amount',
            'amount_settle' => 'Amount Settle',
            'currency' => 'Currency',
            'subject' => 'Subject',
            'body' => 'Body',
            'time_paid' => 'Time Paid',
            'time_expire' => 'Time Expire',
            'time_settle' => 'Time Settle',
            'transaction_no' => 'Transaction No',
            'amount_refunded' => 'Amount Refunded',
            'failure_code' => 'Failure Code',
            'failure_msg' => 'Failure Msg',
            'description' => 'Description',
        ];
    }
}
