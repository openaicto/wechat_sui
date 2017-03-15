<?php

namespace someet\common\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property integer $city_id
 * @property string $city
 * @property integer $type_id
 * @property string $title
 * @property string $desc
 * @property string $poster
 * @property integer $week
 * @property integer $start_time
 * @property integer $end_time
 * @property string $area
 * @property string $address
 * @property string $address_assign
 * @property string $details
 * @property string $group_code
 * @property double $longitude
 * @property double $latitude
 * @property integer $cost
 * @property string $cost_list
 * @property integer $peoples
 * @property integer $ideal_number
 * @property integer $ideal_number_limit
 * @property integer $is_volume
 * @property integer $is_digest
 * @property integer $is_top
 * @property integer $principal
 * @property integer $pma_type
 * @property string $review
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $status
 * @property integer $edit_status
 * @property integer $display_order
 * @property string $content
 * @property integer $apply_rate
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property string $field4
 * @property string $field5
 * @property string $field6
 * @property string $field7
 * @property string $field8
 * @property integer $co_founder1
 * @property integer $co_founder2
 * @property integer $co_founder3
 * @property integer $co_founder4
 * @property integer $is_full
 * @property integer $join_people_count
 * @property integer $space_spot_id
 * @property integer $sequence_id
 * @property integer $version_number
 * @property integer $group_id
 * @property integer $is_display
 * @property integer $allow_vip
 * @property integer $want_allow_vip
 * @property integer $is_rfounder
 * @property string $reject_reason
 */
class Activity extends \yii\db\ActiveRecord
{
    /* 删除 */
    const STATUS_DELETE   = 0;
    /* 不通过的发起人创建的活动 */
    const STATUS_REFUSE = 3;
    /* 通过的发起人创建的活动 */
    const STATUS_PASS = 12;
    /* 发起人创建的活动的草稿 */
    const STATUS_FOUNDER_DRAFT = 5;
    /* 草稿 */
    const STATUS_DRAFT    = 10;
    /* 预发布 */
    const STATUS_PREVENT  = 15;
    /* 发布 */
    const STATUS_RELEASE  = 20;
    /* 关闭 */
    const STATUS_SHUT  = 30;
    /* 取消 */
    const STATUS_CANCEL = 40;
    /* 待审核 */
    const STATUS_CHECK = 8;
    /* 好评 */
    const GOOD_SCORE = 1;
    /* 中评 */
    const MIDDLE_SCORE = 2;
    /* 差评 */
    const BAD_SCORE = 3;

    /* 报名已满 */
    const IS_FULL_YES = 1;
    /* 报名未满 */
    const IS_FULL_NO = 0;

    /* 显示 */
    const DISPLAY_YES =  1;
    /* 不显示 */
    const DISPLAY_NO =  0;
    //收藏数
    public $collect;
    public $new_collect;
    // 标签名, 用于标签行为使用此属性
    public $tagNames;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['city_id', 'type_id', 'week', 'start_time', 'end_time', 'cost', 'peoples', 'is_volume', 'is_digest', 'is_top', 'principal', 'pma_type','created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'edit_status', 'display_order', 'co_founder1', 'co_founder2', 'co_founder3', 'co_founder4', 'is_full', 'join_people_count','space_spot_id','ideal_number','ideal_number_limit' ,'is_rfounder' ,'want_allow_vip'], 'integer'],
            [['details', 'review', 'content', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8' ,'reject_reason'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['city'], 'string', 'max' => 60],
            [['title'], 'string', 'max' => 80],
            [['desc', 'poster', 'address', 'address_assign', 'group_code', 'reject_reason'], 'string', 'max' => 255],
            [['area'], 'string', 'max' => 10],
            [['cost_list'], 'string', 'max' => 190],
        ];
    }
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['edit_status'], $fields['is_top'], $fields['is_digest'], $fields['is_volume'], $fields['week']);

        return $fields;
    }

    public function extraFields()
    {
        return ['type', 'user','pma', 'spot', 'founders', 'user.profile' => function () {
            return $this->user ? $this->user->profile : null;
        }];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'city' => 'City',
            'type_id' => 'Type ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'poster' => 'Poster',
            'week' => 'Week',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'area' => 'Area',
            'address' => 'Address',
            'address_assign' => 'Address Assign',
            'details' => 'Details',
            'group_code' => 'Group Code',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'cost' => 'Cost',
            'cost_list' => 'Cost List',
            'peoples' => 'Peoples',
            'ideal_number' => 'Ideal Number',
            'ideal_number_limit' => 'Ideal Number Limit',
            'is_volume' => 'Is Volume',
            'is_digest' => 'Is Digest',
            'is_top' => 'Is Top',
            'principal' => 'Principal',
            'pma_type' => 'Pma Type',
            'review' => 'Review',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'edit_status' => 'Edit Status',
            'display_order' => 'Display Order',
            'content' => 'Content',
            'apply_rate' => 'Apply Rate',
            'field1' => 'Field1',
            'field2' => 'Field2',
            'field3' => 'Field3',
            'field4' => 'Field4',
            'field5' => 'Field5',
            'field6' => 'Field6',
            'field7' => 'Field7',
            'field8' => 'Field8',
            'co_founder1' => 'Co Founder1',
            'co_founder2' => 'Co Founder2',
            'co_founder3' => 'Co Founder3',
            'co_founder4' => 'Co Founder4',
            'is_full' => 'Is Full',
            'join_people_count' => 'Join People Count',
            'space_spot_id' => 'Space Spot ID',
            'sequence_id' => 'Sequence ID',
            'version_number' => 'Version Number',
            'group_id' => 'Group ID',
            'is_display' => 'Is Display',
            'allow_vip' => 'Allow Vip',
            'want_allow_vip' => 'Want Allow Vip',
            'is_rfounder' => 'Is Rfounder',
            'reject_reason' => 'Reject Reason',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => behaviors\TimestampBehavior::className(),
            ],
        ];
    }

    // public function beforeSave($insert)
    // {
    //     var_dump($insert);die;
    //     if (parent::beforeSave($insert)) {
    //         if ($insert) {
    //             $this->updated_by = Yii::$app->user->id;
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // 活动标签
    public function getTags()
    {
        return $this->hasMany(ActivityTag::className(), ['id' => 'tag_id'])->viaTable('r_tag_activity', ['activity_id' => 'id']);
    }

    // PMA
    public function getPma()
    {
        return $this->hasOne(User::className(), ['id' => 'principal']);
    }

    // DTS
    public function getDts()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    // 发起人
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }


    // 联合发起人1
    public function getCofounder1()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder1']);
    }

    // 联合发起人2
    public function getCofounder2()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder2']);
    }
    // 联合发起人3
    public function getCofounder3()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder3']);
    }
    // 联合发起人4
    public function getCofounder4()
    {
        return $this->hasOne(User::className(), ['id' => 'co_founder4']);
    }

    /**
     * 类型
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ActivityType::className(), ['id' => 'type_id']);
    }

    // 活动的场地
    public function getSpace()
    {
        return $this->hasOne(SpaceSpot::className(), ['id' => 'space_spot_id']);
    }

    /**
     * 活动问题
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['activity_id' => 'id']);
    }

    /**
     * 报名列表
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerList()
    {
        return $this->hasMany(Answer::className(), ['activity_id' => 'id']);
    }

    /**
     * 反馈列表
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackList()
    {
        return $this->hasMany(ActivityFeedback::className(), ['activity_id' => 'id']);
    }

    /**
     * 黄牌列表
     * @return \yii\db\ActiveQuery
     */
    public function getYellowCardList()
    {
        return $this->hasMany(YellowCard::className(), ['activity_id' => 'id']);
    }

    /**
     * 签到列表
     * @return \yii\db\ActiveQuery
     */
    public function getCheckInList()
    {
        return $this->hasMany(ActivityCheckIn::className(), ['activity_id' => 'id']);
    }

    /**
     * 联合发起人列表
     * @return \yii\db\ActiveQuery
     */
    public function getRActivityFounder()
    {
        return $this->hasMany(RActivityFounder::className(), ['activity_id' => 'id']);
    }

    /**
     * 场地
     * @return \yii\db\ActiveQuery
     */
    public function getSpot()
    {
        return $this->hasOne(SpaceSpot::className(), ['id' => 'space_spot_id']);
    }

    public function getFounders()
    {
        return $this->hasMany(User::className(), ['id' => 'founder_id'])->viaTable('r_activity_founder', ['activity_id' => 'id']);
    }

    /**
     * 活动对应的日志列表
     * @return $this
     */
    public function getLogs()
    {
        return $this->hasMany(AdminLog::className(), ['handle_id' => 'id'])->where(['controller' => 'activity'])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * 标签和活动对应列表
     * @return \yii\db\ActiveQuery
     */
    public function getRTagActivity()
    {
        return $this->hasOne(RTagActivity::className(), ['activity_id' => 'id']);
    }
}
