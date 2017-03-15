<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "wish_find".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $mobile
 * @property string $from
 */
class WishFind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wish_find';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['from'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'mobile' => 'Mobile',
            'from' => 'From',
        ];
    }
}
