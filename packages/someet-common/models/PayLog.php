<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "pay_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $order_no
 * @property string $url
 * @property integer $created_at
 * @property integer $pay_status
 * @property integer $price
 */
class PayLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'pay_status', 'price'], 'integer'],
            [['order_no', 'url'], 'string', 'max' => 255],
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
            'order_no' => 'Order No',
            'url' => 'Url',
            'created_at' => 'Created At',
            'pay_status' => 'Pay Status',
            'price' => 'Price',
        ];
    }
}
