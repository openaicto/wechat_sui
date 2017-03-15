<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "user_act_tags".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tag_act_id
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $note
 * @property integer $tag_parent_id
 */
class UserActTags extends \yii\db\ActiveRecord
{
    const SUB = 10;
    const UNSUB = 20;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_act_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tag_act_id', 'type', 'status', 'created_at', 'updated_at', 'tag_parent_id'], 'integer'],
            [['status', 'tag_parent_id'], 'required'],
            [['note'], 'string', 'max' => 255],
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
            'tag_act_id' => 'Tag Act ID',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'note' => 'Note',
            'tag_parent_id' => 'Tag Parent ID',
        ];
    }
}
