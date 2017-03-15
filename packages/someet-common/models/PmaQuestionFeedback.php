<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "pma_question_feedback".
 *
 * @property integer $id
 * @property string $pma_question
 * @property integer $status
 * @property integer $created_at
 * @property integer $type
 */
class PmaQuestionFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pma_question_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'type'], 'integer'],
            [['pma_question'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pma_question' => 'Pma Question',
            'status' => 'Status',
            'created_at' => 'Created At',
            'type' => 'Type',
        ];
    }
}
