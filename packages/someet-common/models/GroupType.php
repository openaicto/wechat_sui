<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "group_type".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property integer $pid
 * @property integer $created_at
 * @property integer $note
 * @property string $content
 * @property string $type_img_red
 * @property string $type_img_white
 */
class GroupType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'pid', 'created_at', 'note'], 'integer'],
            [['title', 'content', 'type_img_red', 'type_img_white'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'pid' => 'Pid',
            'created_at' => 'Created At',
            'note' => 'Note',
            'content' => 'Content',
            'type_img_red' => 'Type Img Red',
            'type_img_white' => 'Type Img White',
        ];
    }
}
