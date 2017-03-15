<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "exchange_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $openid
 * @property string $moblie
 * @property integer $exchange_id
 * @property integer $created_at
 * @property string $cdkey
 * @property integer $status
 * @property integer $level
 */
class ExchangeUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'exchange_id', 'created_at', 'status', 'level'], 'integer'],
            [['username', 'openid'], 'string', 'max' => 255],
            [['moblie'], 'string', 'max' => 45],
            [['cdkey'], 'string', 'max' => 100],
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
            'openid' => 'Openid',
            'moblie' => 'Moblie',
            'exchange_id' => 'Exchange ID',
            'created_at' => 'Created At',
            'cdkey' => 'Cdkey',
            'status' => 'Status',
            'level' => 'Level',
        ];
    }
}
