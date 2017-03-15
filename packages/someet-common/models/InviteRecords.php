<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "invite_records".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $openid
 * @property integer $invite_user_id
 * @property string $invite_openid
 * @property integer $create_time
 * @property string $invite_action
 * @property integer $invite_vip
 */
class InviteRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invite_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'invite_user_id', 'created_time', 'invite_vip'], 'integer'],
            [['invite_user_id'], 'required'],
            [['openid', 'invite_openid'], 'string', 'max' => 100],
            [['invite_action'], 'string', 'max' => 200],
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
            'openid' => 'Openid',
            'invite_user_id' => 'Invite User ID',
            'invite_openid' => 'Invite Openid',
            'created_time' => 'Created Time',
            'invite_action' => 'Invite Action',
            'invite_vip' => 'Invite Vip',
        ];
    }
}
