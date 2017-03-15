<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "exchange".
 *
 * @property integer $id
 * @property integer $status
 * @property string $cdkey
 * @property integer $level
 * @property integer $type
 * @property integer $count
 * @property integer $expire_time
 * @property integer $created_at
 * @property integer $exchange_limit
 * @property integer $discount
 * @property string $channel
 * @property integer $updated_at
 * @property integer $handle_person
 * @property integer $batch
 */
class Exchange extends \yii\db\ActiveRecord
{
    const NO_LIMIT = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'level', 'type', 'count', 'expire_time', 'created_at', 'exchange_limit', 'discount', 'updated_at', 'handle_person', 'batch'], 'integer'],
            [['cdkey', 'level'], 'required'],
            [['cdkey'], 'string', 'max' => 100],
            [['channel'], 'string', 'max' => 255],
            [['cdkey'], 'unique'],
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
            'cdkey' => 'Cdkey',
            'level' => 'Level',
            'type' => 'Type',
            'count' => 'Count',
            'expire_time' => 'Expire Time',
            'created_at' => 'Created At',
            'exchange_limit' => 'Exchange Limit',
            'discount' => 'Discount',
            'channel' => 'Channel',
            'updated_at' => 'Updated At',
            'handle_person' => 'Handle Person',
            'batch' => 'Batch',
        ];
    }
}
