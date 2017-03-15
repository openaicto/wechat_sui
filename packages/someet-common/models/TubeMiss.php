<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "tube_miss".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $test_tube_id
 * @property integer $created_at
 */
class TubeMiss extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tube_miss';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'test_tube_id', 'created_at'], 'integer'],
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
            'test_tube_id' => 'Test Tube ID',
            'created_at' => 'Created At',
        ];
    }
}
