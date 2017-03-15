<?php

namespace someet\common\models;


use Yii;

/**
 * This is the model class for table "group_answer".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $status
 * @property string $content
 * @property integer $created_at
 * @property string $reject_reason
 * @property integer $pay_status
 * @property integer $peoples
 */
class GroupAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'user_id', 'status', 'created_at', 'pay_status', 'peoples'], 'integer'],
            [['group_id', 'user_id'], 'required'],
            [['content', 'reject_reason'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'content' => 'Content',
            'created_at' => 'Created At',
            'reject_reason' => 'Reject Reason',
            'pay_status' => 'Pay Status',
            'peoples' => 'Peoples',
        ];
    }

    public function getGroupUser(){
        return $this->hasOne(GroupUser::className(), ['user_id' => 'user_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
