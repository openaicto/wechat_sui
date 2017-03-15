<?php

namespace someet\common\models;

use someet\common\models\SpaceSpot;
use Yii;

/**
 * This is the model class for table "wish".
 *
 * @property integer $id
 * @property integer $user
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $take_user
 * @property integer $take_at
 * @property integer $handle_user
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $type
 * @property string $note
 * @property integer $spot_id
 */
class Wish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wish';
    }

    public function getSpaceSpot()
    {
        return $this->hasOne(SpaceSpot::className(), ['id'=>'spot_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'status', 'answer_id', 'take_user', 'take_at', 'handle_user', 'created_at', 'updated_at', 'type'], 'integer'],
            [['content'], 'string'],
            [['title', 'note', 'user_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'take_user' => 'Take User',
            'take_at' => 'Take At',
            'handle_user' => 'Handle User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'note' => 'Note',
            'spot_id' => 'Spot Id',
            'answer_id' => 'Answer Id',
            'user_desc' => 'User Desc'
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
