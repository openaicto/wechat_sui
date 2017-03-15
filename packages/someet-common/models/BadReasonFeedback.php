<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "bad_reason_feedback".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property integer $created_at
 * @property integer $pid
 * @property string $tag
 */
class BadReasonFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bad_reason_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['type', 'created_at', 'pid'], 'integer'],
            [['title', 'tag'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'created_at' => 'Created At',
            'pid' => 'Pid',
            'tag' => 'Tag',
        ];
    }
}
