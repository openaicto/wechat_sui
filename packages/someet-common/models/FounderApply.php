<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "founder_apply".
 *
 * @property integer $id
 * @property integer $want_city
 * @property string $other_city
 * @property string $activity_review
 * @property integer $have_activity
 * @property string $activity_title
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $ext1
 * @property string $ext2
 */
class FounderApply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'founder_apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['want_city', 'have_activity', 'created_at', 'updated_at', 'user_id' ,'activity_type'], 'integer'],
            [['other_city', 'activity_review', 'activity_title'], 'string', 'max' => 255],
            ['status', 'default', 'value' => '0'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'user_id',
            'want_city' => 'Want City',
            'other_city' => 'Other City',
            'activity_type' => 'Activity Type',
            'activity_review' => 'Activity Review',
            'have_activity' => 'Have Activity',
            'activity_title' => 'Activity Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
