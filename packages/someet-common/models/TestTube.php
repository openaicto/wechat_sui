<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "test_tube".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bring_user_id
 * @property integer $hand_user_id
 * @property integer $type
 * @property integer $city
 * @property string $address_desc
 * @property string $username
 * @property string $mobile
 * @property string $wechat
 * @property string $introduction
 * @property string $question1
 * @property string $question2
 * @property string $address
 * @property double $longitude
 * @property double $latitude
 * @property string $distant_view
 * @property string $close_shot
 * @property integer $status
 * @property string $note
 * @property integer $created_at
 * @property integer $bring_at
 * @property integer $updated_at
 * @property string $wish_content
 * @property string $wish_jetton
 * @property integer $sex
 * @property integer $from
 */
class TestTube extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const NOT_PUT_IN = 20;//待投放
    const WAIT_EXAMINE = 10;//带筛选
    const HAD_PUT_IN = 30;//已投放
    const HAD_TAKE_AWAY = 40;//已经领走
    const HAD_REMOVE = 50;//已经下架
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_tube';
    }
    public static function getStatus($status)
    {
        $status_array = array(
            self::NOT_PUT_IN=>'待投放',
            self::WAIT_EXAMINE=>'待筛选',
            self::HAD_PUT_IN=>'已投放',
            self::HAD_TAKE_AWAY=>'已经领走',
            self::HAD_REMOVE=>'已经下架'
            );
        if($status == null){
            return '未投放';
        }
        return $status_array[$status];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'bring_user_id', 'hand_user_id', 'type', 'city', 'status', 'created_at', 'bring_at', 'updated_at', 'sex', 'miss_count'], 'integer'],
            [['introduction', 'wish_content', 'wish_jetton'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['address_desc', 'username', 'wechat', 'question1', 'question2', 'address', 'distant_view', 'close_shot', 'note'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 44],
            [['from'], 'string', 'max' => 100],
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
            'bring_user_id' => 'Bring User ID',
            'hand_user_id' => 'Hand User ID',
            'type' => 'Type',
            'city' => 'City',
            'address_desc' => 'Address Desc',
            'username' => 'Username',
            'mobile' => 'Mobile',
            'wechat' => 'Wechat',
            'introduction' => 'Introduction',
            'question1' => 'Question1',
            'question2' => 'Question2',
            'address' => 'Address',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'distant_view' => 'Distant View',
            'close_shot' => 'Close Shot',
            'status' => 'Status',
            'note' => 'Note',
            'created_at' => 'Created At',
            'bring_at' => 'Bring At',
            'updated_at' => 'Updated At',
            'wish_content' => 'Wish Content',
            'wish_jetton' => 'Wish Jetton',
            'sex' => 'Sex',
            'from' => 'From',
            'miss_count' => 'Miss Count',
        ];
    }
}
