<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "access_records".
 *
 * @property integer $id
 * @property string $action_name
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 */
class AccessRecords extends \yii\db\ActiveRecord
{
    const STATUS = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_name'], 'required'],
            [['user_id', 'status', 'created_at'], 'integer'],
            [['action_name'], 'string', 'max' => 180],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action_name' => 'Action Name',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
