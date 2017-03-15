<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "guestbook".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $user_id
 * @property string $content
 * @property integer $reply_id
 * @property integer $created_time
 * @property integer $is_first
 * @property integer $status
 */
class Guestbook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guestbook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'user_id'], 'required'],
            [['gid', 'user_id', 'reply_id', 'created_time', 'is_first', 'status'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'user_id' => 'User ID',
            'content' => 'Content',
            'reply_id' => 'Reply ID',
            'created_time' => 'Created Time',
            'is_first' => 'Is First',
            'status' => 'Status',
        ];
    }
    // 发起人
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
