<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "user_feedback".
 *
 * @property integer $id
 * @property integer $activity_id
 * @property integer $user_id
 * @property string $content
 * @property string $image
 * @property integer $activity_records
 * @property integer $created_records
 * @property string $other_reasons
 * @property string $good_user
 * @property string $bad_user
 * @property integer $created_at
 * @property string $bad_reason
 * @property string $bad_reason_detail
 * @property integer $finish
 */
class UserFeedback extends \yii\db\ActiveRecord
{

    const GOOD_SCORE = 10;
    const MIDDLE_SCORE = 8;
    const BAD_SCORE = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_feedback';
    }

    public function extraFields()
    {
        return ['user', 'activity', 'answer', 'user.profile' => function() {
            return $this->user ? $this->user->profile: null;
        }];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'user_id', 'activity_records', 'created_records', 'created_at', 'finish'], 'integer'],
            [['content', 'other_reasons'], 'string'],
            [['image', 'good_user', 'bad_user', 'bad_reason', 'bad_reason_detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'image' => 'Image',
            'activity_records' => 'Activity Records',
            'created_records' => 'Created Records',
            'other_reasons' => 'Other Reasons',
            'good_user' => 'Good User',
            'bad_user' => 'Bad User',
            'created_at' => 'Created At',
            'bad_reason' => 'Bad Reason',
            'bad_reason_detail' => 'Bad Reason Detail',
            'finish' => 'Finish',
        ];
    }
    /**
     * 用户
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * 活动
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * 活动报名
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['user_id' => 'user_id', 'activity_id' => 'activity_id']);
    }
}
