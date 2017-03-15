<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "permanent_material".
 *
 * @property integer $id
 * @property string $name
 * @property string $media_id
 * @property string $url
 * @property integer $status
 * @property integer $created_at
 */
class PermanentMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permanent_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_id', 'url'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'media_id' => 'Media ID',
            'url' => 'Url',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
