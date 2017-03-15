<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "r_user_bad_reason".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property integer $bad_reason
 * @property string $bad_reason_detail
 * @property integer $created_at
 * @property integer $fid
 * @property string $other_reasons
 */
class RUserBadReason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_user_bad_reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id', 'bad_reason', 'fid'], 'required'],
            [['user_id', 'activity_id', 'bad_reason', 'created_at', 'fid'], 'integer'],
            [['other_reasons'], 'string'],
            [['bad_reason_detail'], 'string', 'max' => 255],
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
            'activity_id' => 'Activity ID',
            'bad_reason' => 'Bad Reason',
            'bad_reason_detail' => 'Bad Reason Detail',
            'created_at' => 'Created At',
            'fid' => 'Fid',
            'other_reasons' => 'Other Reasons',
        ];
    }
}
