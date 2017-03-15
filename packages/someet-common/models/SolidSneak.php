<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "solid_sneak".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $username
 * @property string $mobile
 * @property string $wechat
 * @property integer $test_tube_id
 * @property integer $type
 * @property integer $city
 * @property string $address
 * @property string $from
 * @property double $longitude
 * @property double $latitude
 * @property string $distant_view
 * @property string $close_shot
 * @property integer $status
 * @property string $note
 * @property integer $created_at
 * @property integer $bring_at
 * @property integer $updated_at
 */
class SolidSneak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solid_sneak';
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
            [['user_id', 'test_tube_id', 'type', 'city', 'status', 'created_at', 'bring_at', 'updated_at'], 'integer'],
            [['longitude', 'latitude'], 'number'],
            [['distant_view', 'close_shot'], 'string'],
            [['username', 'wechat', 'address', 'from', 'note'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 44],
            [['created_at'], 'default', 'value' => time()],
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
            'wechat' => 'Wechat',
            'test_tube_id' => 'Test Tube ID',
            'type' => 'Type',
            'city' => 'City',
            'address' => 'Address',
            'from' => 'From',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'distant_view' => 'Distant View',
            'close_shot' => 'Close Shot',
            'status' => 'Status',
            'note' => 'Note',
            'created_at' => 'Created At',
            'bring_at' => 'Bring At',
            'updated_at' => 'Updated At',
        ];
    }
    /**
     * 用户
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(profile::className(), ['user_id' => 'user_id']);
    }
}
