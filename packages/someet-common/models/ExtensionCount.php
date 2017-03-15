<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "count".
 *
 * @property integer $id
 * @property string $from
 * @property integer $user_id
 */
class ExtensionCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extension_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'is_new'], 'integer'],
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
            'from' => 'From',
            'user_id' => 'User ID',
        ];
    }
}
