<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "share_wish".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $wish_id
 * @property integer $created_at
 */
class ShareWish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'share_wish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wish_id'], 'required'],
            [['user_id', 'wish_id', 'created_at'], 'integer'],
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
        ];
    }
}
