<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "tube_limit".
 *
 * @property integer $id
 * @property integer $city_id
 * @property integer $type_id
 * @property integer $limit
 */
class TubeLimit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tube_limit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'type_id', 'limit'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'type_id' => 'Type ID',
            'limit' => 'Limit',
        ];
    }
}
