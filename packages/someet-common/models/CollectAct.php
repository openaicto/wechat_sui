<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "collect_act".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property string $activity_name
 * @property integer $status
 * @property string $note
 * @property integer $created_at
 * @property integer $updated_at
 */
class CollectAct extends \yii\db\ActiveRecord
{
    const COLLECT = 1;
    const UNCOLLECT = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collect_act';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['activity_name', 'note'], 'string', 'max' => 255],
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
            'activity_name' => 'Activity Name',
            'status' => 'Status',
            'note' => 'Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
