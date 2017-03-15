<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "group_user".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $head_image
 * @property integer $count_success
 * @property integer $count_fail
 * @property string $introduce
 * @property string $mobile
 * @property string $wechat_id
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $name
 */
class GroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'count_success', 'count_fail', 'created_at', 'updated_at', 'status'], 'integer'],
            [['head_image', 'introduce', 'content'], 'string'],
            [['mobile', 'wechat_id'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 100],
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
            'head_image' => 'Head Image',
            'count_success' => 'Count Success',
            'count_fail' => 'Count Fail',
            'introduce' => 'Introduce',
            'mobile' => 'Mobile',
            'wechat_id' => 'Wechat ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'name' => 'Name',
        ];
    }
}
