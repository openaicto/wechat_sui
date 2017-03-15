<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "refund".
 *
 * @property integer $id
 * @property string $refund_order_no
 * @property string $order_no
 * @property string $pingpp_id
 * @property integer $handle_person
 * @property double $price
 * @property integer $status
 * @property integer $succeed
 * @property string $description
 * @property integer $created_at
 * @property integer $time_succeed
 * @property string $transaction_no
 * @property string $failure_msg
 * @property string $failure_code
 * @property integer $user_id
 * @property string $username
 * @property string $openid
 * @property string $mobile
 * @property integer $answer_id
 */
class Refund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'refund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['handle_person', 'status', 'succeed', 'created_at', 'time_succeed', 'user_id', 'answer_id'], 'integer'],
            [['price'], 'number'],
            [['refund_order_no', 'order_no', 'pingpp_id', 'description', 'transaction_no', 'failure_msg', 'failure_code', 'username', 'openid'], 'string', 'max' => 255],
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
            'refund_order_no' => 'Refund Order No',
            'order_no' => 'Order No',
            'pingpp_id' => 'Pingpp ID',
            'handle_person' => 'Handle Person',
            'price' => 'Price',
            'status' => 'Status',
            'succeed' => 'Succeed',
            'description' => 'Description',
            'created_at' => 'Created At',
            'time_succeed' => 'Time Succeed',
            'transaction_no' => 'Transaction No',
            'failure_msg' => 'Failure Msg',
            'failure_code' => 'Failure Code',
            'user_id' => 'User ID',
            'username' => 'Username',
            'openid' => 'Openid',
            'mobile' => 'Mobile',
            'answer_id' => 'Answer ID',
        ];
    }
}
