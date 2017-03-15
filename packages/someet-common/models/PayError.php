<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "pay_error".
 *
 * @property integer $id
 * @property string $pay_result
 * @property integer $user_id
 * @property integer $from_id
 * @property integer $created_at
 * @property string $err_msg
 * @property string $err_extra
 * @property string $client_charge
 * @property string $service_charge
 * @property string $desc
 * @property integer $status
 */
class PayError extends \yii\db\ActiveRecord
{
    /* 未处理 默认值 */
    const STATUS_DEFAULT = 10;

    /* 未处理 已处理 */
    const STATUS_SUCCESS = 20;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_result', 'err_msg', 'err_extra', 'client_charge', 'service_charge', 'desc'], 'string'],
            [['user_id', 'from_id', 'created_at', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_result' => 'Pay Result',
            'user_id' => 'User ID',
            'from_id' => 'From ID',
            'created_at' => 'Created At',
            'err_msg' => 'Err Msg',
            'err_extra' => 'Err Extra',
            'client_charge' => 'Client Charge',
            'service_charge' => 'Service Charge',
            'desc' => 'Desc',
            'status' => 'Status',
        ];
    }
}
