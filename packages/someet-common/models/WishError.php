<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "wish_error".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $wish_id
 * @property integer $created_at
 * @property string $mobile
 * @property string $wechat_id
 */
class WishError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wish_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wish_id', 'created_at'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['wechat_id'], 'string', 'max' => 30],
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
            'wish_id' => 'Wish ID',
            'created_at' => 'Created At',
            'mobile' => 'Mobile',
            'wechat_id' => 'Wechat ID',
        ];
    }
}
