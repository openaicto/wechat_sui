<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "vip_info".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $price
 * @property integer $status
 * @property integer $create_at
 * @property string $note
 */
class VipInfo extends \yii\db\ActiveRecord
{
    //49元套餐
    const QUARTER_A = 10;
    //79元套餐
    const QUARTER_B = 20;
    //89元套餐
    const HALF_YEAR_A = 30;
    //249元套餐
    const HALF_YEAR_B = 40;
    //999元套餐
    const ONE_YEAR = 50;
    //66天体验会员
    const EXPIRE_VIP = 60;
    const EXPIRE_VIP_15 = 15;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vip_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'price', 'status', 'create_at'], 'integer'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'price' => 'Price',
            'status' => 'Status',
            'create_at' => 'Create At',
            'note' => 'Note',
        ];
    }
}
