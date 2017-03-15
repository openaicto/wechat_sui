<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "founder_feedback".
 *
 * @property integer $id
 * @property integer $area
 * @property string $pma_work
 * @property string $feedback
 * @property string $bad_reason
 * @property integer $good_user
 * @property integer $bad_user
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property integer $activity_id
 * @property string $other_reason
 * @property integer $finish
 */
class FounderFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'founder_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area', 'good_user', 'bad_user', 'created_at', 'updated_at', 'user_id', 'activity_id', 'finish'], 'integer'],
            [['feedback'], 'string'],
            [['user_id', 'activity_id'], 'required'],
            [['pma_work', 'bad_reason', 'other_reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Area',
            'pma_work' => 'Pma Work',
            'feedback' => 'Feedback',
            'bad_reason' => 'Bad Reason',
            'good_user' => 'Good User',
            'bad_user' => 'Bad User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'activity_id' => 'Activity ID',
            'other_reason' => 'Other Reason',
            'finish' => 'Finish',
        ];
    }
}
