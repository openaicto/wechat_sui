<?php
namespace someet\common\services;

use dektrium\user\models\Account;
use someet\common\models\Activity;
use someet\common\models\Noti;
use someet\common\models\NotificationTemplate;
use someet\common\models\QuestionItem;
use someet\common\models\AnswerItem;
use someet\common\models\Answer;
use someet\common\models\User;
use someet\common\models\Vip;
use someet\common\models\VipInfo;
use someet\common\models\Exchange;
use someet\common\models\ExchangeUser;
use someet\common\models\ActivityType;
use someet\common\models\YellowCard;
use someet\common\services\BackendEventService;
use someet\common\models\UserActTags;
use someet\common\models\TagAct;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;

class UserActTagsService extends BaseService
{
    /**
     * 增加用户订阅
     * @param [type] $tag_id [description]
     */
    public static function addUserActTags($tag_id)
    {
        $parent_tag = TagAct::findOne($tag_id);
        $user_id = Yii::$app->user->id;
        $is_exist = UserActTags::find()
                    ->where(['user_id'=>$user_id, 'tag_act_id'=>$tag_id])
                    ->one();
        if ($is_exist && $is_exist->status == UserActTags::SUB) {
            return ['status'=>'1','data'=>'该标签已经订阅'];
        } else {
            if ($is_exist && $is_exist->status == UserActTags::UNSUB) {
                $is_exist->status = UserActTags::SUB;
                $is_exist->updated_at = time();
                if ($is_exist->save()) {
                    self::updateSubscribe_num($tag_id, 'up');
                    return ['status'=>'1','data'=>'订阅成功','id'=>$is_exist->id];
                } else {
                    return ['status'=>'0','data'=>'订阅失败'];
                }
            } else {
                $usertags = new UserActTags();
                $usertags->tag_parent_id = $parent_tag->pid;
                $usertags->tag_act_id = $tag_id;
                $usertags->user_id = $user_id;
                $usertags->status = UserActTags::SUB;
                $usertags->created_at = time();
                if ($usertags->save()) {
                    self::updateSubscribe_num($tag_id, 'up');
                    return ['status'=>'1','data'=>'订阅成功','id'=>$usertags->id];
                } else {
                    return ['status'=>'0','data'=>'订阅失败'];
                }
            }
        }
    }


    /**
     * 增加用户多订阅
     * @param [type] $tag_id [description]
     */
    public static function addUserActMoreTags($tag_id)
    {
        $parent_tag = TagAct::findOne($tag_id);
        $user_id = Yii::$app->user->id;
        $is_exist = UserActTags::find()
                    ->where(['user_id'=>$user_id, 'tag_act_id'=>$tag_id])
                    ->one();
        if ($is_exist && $is_exist->status == UserActTags::SUB) {
            $msg = ['status'=>1,'data'=>'已经订阅'];
        } else {
            if ($is_exist && $is_exist->status == UserActTags::UNSUB) {
                $is_exist->status = UserActTags::SUB;
                $is_exist->updated_at = time();
                if ($is_exist->save()) {
                    self::updateSubscribe_num($tag_id, 'up');
                    return ['status'=>'1','data'=>'订阅成功','id'=>$is_exist->id];
                } else {
                    return ['status'=>'0','data'=>'订阅失败'];
                }
            } else {
                $usertags = new UserActTags();
                $usertags->tag_parent_id = $parent_tag->pid;
                $usertags->tag_act_id = $tag_id;
                $usertags->user_id = $user_id;
                $usertags->status = UserActTags::SUB;
                $usertags->created_at = time();
                if ($usertags->save()) {
                    self::updateSubscribe_num($tag_id, 'up');
                    return ['status'=>'1','data'=>'订阅成功','id'=>$usertags->id];
                } else {
                    return ['status'=>'0','data'=>'订阅失败'];
                }
            }
        }
    }
    /**
     * 更新订阅数量
     * @param  [type] $id   [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public static function updateSubscribe_num($id, $type)
    {
        $tag_act = TagAct::findOne($id);
        if ($type == 'down') {
            $tag_act-> subscribe_num -=1;
        } else {
            $tag_act-> subscribe_num +=1;
        }

        $tag_act->save();
    }

    /**
     * 删除用户订阅
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function delUserActTags($id)
    {
        $user_id = Yii::$app->user->id;
        $usertags = UserActTags::find()
                    ->where(['user_id'=>$user_id, 'tag_act_id'=>$id])
                    ->one();
        $tag_id = $usertags->tag_act_id;
        // $usertags->delete();
        $usertags->status = UserActTags::UNSUB;
        $usertags->updated_at = time();
        if ($usertags->save()) {
            self::updateSubscribe_num($usertags->tag_act_id, 'down');
            return ['status'=>'1','data'=>'取消成功','id'=>$tag_id];
        } else {
            return ['status'=>'0','data'=>'取消订阅失败','id'=>$tag_id];
        }
    }
}
