<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "push_log".
 *
 * @property integer $id
 * @property string $note
 * @property string $openid
 * @property integer $user_id
 * @property integer $from_id
 * @property string $from_type
 * @property string $template_id
 * @property integer $create_time
 * @property string $error_log
 */
class PushLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'push_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note', 'openid', 'user_id', 'template_id'], 'required','message'=>'note,openid,user_id,template_id  不能为空'],
            [['user_id', 'from_id', 'create_time'], 'integer'],
            [['note'], 'string', 'max' => 100],
            [['openid'], 'string', 'max' => 40],
            [['from_type'], 'string', 'max' => 30],
            [['template_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note' => 'Note',
            'openid' => 'Openid',
            'user_id' => 'User ID',
            'from_id' => 'From ID',
            'from_type' => 'From Type',
            'template_id' => 'Template ID',
            'create_time' => 'Create Time',
            'error_log' => 'Error Log',
        ];
    }
}
