<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "tag_act".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 * @property integer $subscribe_num
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $note
 * @property integer $order
 * @property string $image
 * @property string $english_name
 */
class TagAct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_act';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'subscribe_num', 'type', 'status', 'created_at', 'updated_at', 'order'], 'integer'],
            [['name', 'note', 'image', 'english_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'name' => 'Name',
            'subscribe_num' => 'Subscribe Num',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'note' => 'Note',
            'order' => 'Order',
            'image' => 'Image',
            'english_name' => 'English Name',
        ];
    }
}
