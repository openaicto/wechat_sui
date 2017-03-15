<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "group_up".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property integer $type
 * @property integer $start_time
 * @property integer $end_time
 * @property string $address
 * @property string $peoples
 * @property string $cost
 * @property string $content
 * @property string $image
 * @property string $question
 * @property string $introduce
 * @property integer $created_at
 * @property integer $status
 * @property integer $check
 * @property integer $check_time
 * @property string $reject_reason
 * @property integer $is_end
 * @property double $latitude
 * @property double $longitude
 * @property integer $updated_at
 */
class GroupUp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_up';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'start_time', 'end_time', 'created_at', 'status', 'check', 'check_time', 'is_end', 'updated_at'], 'integer'],
            [['title', 'address', 'content'], 'required'],
            [['content', 'image', 'question', 'introduce', 'reject_reason'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['city_id'],'int'],
            [['title', 'address', 'peoples', 'cost'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'type' => 'Type',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'address' => 'Address',
            'peoples' => 'Peoples',
            'cost' => 'Cost',
            'content' => 'Content',
            'image' => 'Image',
            'question' => 'Question',
            'introduce' => 'Introduce',
            'created_at' => 'Created At',
            'status' => 'Status',
            'check' => 'Check',
            'check_time' => 'Check Time',
            'reject_reason' => 'Reject Reason',
            'is_end' => 'Is End',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'updated_at' => 'Updated At',
            'city_id'  => 'City_id'
        ];
    }

    public function getGroup_user(){
        return $this->hasOne(GroupUser::className(), ['user_id' => 'user_id']);
    }

    public function getGroup_answer(){
        return $this->hasMany(GroupAnswer::className(), ['group_id' => 'id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getProfile(){
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }
    public function getGroupType(){
        return $this->hasOne(GroupType::className(), ['id' => 'type']);
    }
}
