<?php
namespace someet\common\services;

use dektrium\user\models\Account;
use someet\common\models\Activity;
use someet\common\models\Noti;
use someet\common\models\NotificationTemplate;
use someet\common\models\QuestionItem;
use someet\common\models\AnswerItem;
use someet\common\models\Refund;
use someet\common\models\WechatPush;
use someet\common\models\Answer;
use someet\common\models\User;
use someet\common\models\YellowCard;
use someet\common\models\ActivityOrder;
use someet\common\services\ActivityService;
use someet\common\services\AnswerService;
use someet\common\services\RefundService;
use someet\common\services\WechatPushService;
use someet\common\services\MobileMsgService;
use someet\common\models\ActivityType;
use someet\common\services\ActivityOrderService;
use someet\common\services\InviteService;
use yii\web\Response;
use yii\db\ActiveQuery;
use Yii;

/**
* 触发事件
* 开发必读
* 添加的每个事件前，请在这里添加上和函数名字一直的事件，方便查找，避免重复，命名请规范，
* 如果是报名请用 apply+事件名字，切勿直接使用success
* @author  stark
* 前台：报名以后执行的事件
* 前台：支付成功后的事件
* 前台：报名以前执行的事件
* 前台：取消报名
* 前台：请假事件
* 前台：发起人通过活动报名申请  用户报名通过
* 前台：发起人拒绝活动报名申请
* 后台：报名名额改动
* 后台：理想人数改动
* 活动费用支付过期前提醒,短信提醒
* 活动开始前提醒
* 活动退款通知
* 会员过期提醒
* 活动取消通知
* 用户申诉结果通知
* 用户报名通知发起人
* 报名失败通知
* 报名成功通知
* 活动签到通知
* 活动信用变更
* 用户取消活动，信用变更通知
 */
class EventService extends BaseService
{
    /**
     * 用户是缺席事件 包括迟到和爽约
     * @param [type] $yellowCard [description]
     */
    // public static function userAbsent($yellowCard)
    // {
    //     // 迟到和爽约后发送信用变更的微信push
    //     WechatPushService::updateCredit($yellowCard);
    // }

    /**
     * 前台：报名以后执行的事件
     * @param  init $activity_id 活动id
     * @return 是否执行成功
     */
    public static function applyAfter($activity_id)
    {
        // 更新活动是否报满
        AnswerService::updateIsfull($activity_id);

        // 更新活动的报名率
        ActivityService::updateRepalyRate($activity_id);

        //发送短信

        //发送微信push

        //极光push
    }

    /**
     * 前台：支付成功后的事件
     * @param  init $activity_id 活动id
     * @return 是否执行成功
     */
    public static function actPaySucceeded($activity_id)
    {
        // 发送微信push
        // 发送短信
        // 存储支付的日志
    }

    /**
     * 前台：报名以前执行的事件
     * @param  init $activity_id 活动id
     * @return 是否执行成功
     */
    public static function applyBefore($activity_id)
    {
        /*
        报名前执行的事件 检测
        是否和自己报名过的活动冲突，
        活动报满后不可以报名，
        活动只要是非发布状态都不可以报名
        */
        return AnswerService::checkApply($activity_id);
    }

    /**
     * 前台：用户取消报名
     * @param  init $activity_id 活动id
     * @return 是否执行成功
     */
    public static function cancelApply($answer)
    {
        // 更新活动是否报满
        AnswerService::updateIsfull($answer->activity_id);
        // 更新活动的报名率
        ActivityService::updateRepalyRate($answer->activity_id);
        // 用户取消报名发送push
        WechatPushService::UserCancelApply($answer->id);
    }

    /**
     * 前台：请假事件
     * @param  init $activity_id 活动id
     * @return 是否执行成功
     */
    public static function askForLeave($answer, $yellowCard)
    {
        // 更新活动是否报满
        AnswerService::updateIsfull($answer->activity_id);

        // 更新活动的报名率
        ActivityService::updateRepalyRate($answer->activity_id);
        $push_type =  WechatPush::TYPE_USER_LEAVE;
        // 请假后发送信用变更的微信push
        WechatPushService::updateCredit($yellowCard, $push_type);

        // 提前24小时请假后退款  如果活动存在付费则自动退款
        if ($answer->price > 0 && $answer->pay_status == ActivityOrder::PAY_SUCCESS && $answer->activity->start_time - time() > 86400) {
            $askForLeave = RefundService::askForLeave($answer);
            $refund = refund::find()
                        ->where(['user_id'=>$answer->user_id, 'answer_id'=>$answer->id])
                        ->one();

            if (!$refund->id) {
                self::activityRefund($refund_id);
            }

            return $askForLeave;
        }
    }

    /**
     * 前台：发起人通过活动报名申请 用户报名通过
     * @return 是否执行成功
     */
    public static function filterPass($answer_id, $activity_id)
    {
        // 通过后创建用户支付订单
        // ActivityOrderService::create($answer_id);

        // 更新活动是否报满
        AnswerService::updateIsfull($activity_id);
        // 发送用户报名通过微信push
        WechatPushService::applyPass($answer_id);
        // WechatPushService::Success($answer_id);
        // MobileMsgService::Success($answer_id);
        // 更新活动的报名率
        ActivityService::updateRepalyRate($activity_id);
    }

    /**
     * 前台：发起人拒绝活动报名申请
     * @return 是否执行成功
     */
    public static function filterReject($answer_id, $activity_id)
    {
        // 更新活动是否报满
        AnswerService::updateIsfull($activity_id);
        // 更新活动的报名率
        ActivityService::updateRepalyRate($activity_id);
        // 发送用户报名不通过微信push
        WechatPushService::applyFailed($answer_id);
    }

    /**
     * 后台：报名名额改动
     * @return 是否执行成功
     */
    public static function applyLimit($activity_id)
    {
        // 更新活动是否报满
        AnswerService::updateIsfull($activity_id);

        // 更新活动的报名率
        ActivityService::updateRepalyRate($activity_id);
    }

    /**
     * 后台：理想人数改动
     * @return 是否执行成功
     */
    public static function idealLimit($activity_id)
    {
        // 更新活动是否报满字段
        AnswerService::updateIsfull($activity_id);
    }

    /**
     * 增加邀请人的记录，在vipcontroller中addRecords方法调用，扫码支付不调用
     * @param [type] $invite_user [description]
     */
    public function InviteUser($invite_user)
    {
        return InviteService::addRecords($invite_user);
    }
    /**
     * 活动费用支付过期前提醒,短信提醒
     * @param  [type] $answer_id [description]
     * @return [type]            [description]
     */
    public static function payLate($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user = User::findOne($answer ->user_id);
        $activity_id = $answer ->activity_id;
        $account = Account::find()
                ->where(['user_id' => $answer->user_id])
                ->one();
        WechatPushService::PayLate($answer, $account);
        MobileMsgService::payLate($user, $answer, $account);
    }


    /**
     * 活动开始前提醒
     * @return [type] [description]
     */
    public static function beforeActivity($answer_id)
    {
        WechatPushService::BeforeActivity($answer_id);
    }

    /**
     * 活动退款通知
     * @param [type] $refund_id   [退款ID]
     * @param [type] $activity_id [description]
     */
    public static function activityRefund($refund_id)
    {
        WechatPushService::ActivityRefund($refund_id);
    }

    /**
     * 会员过期提醒
     * @param  [type] $user_id [会员用户ID]
     * @return [type]          [description]
     */
    public static function vipExpire($user_id)
    {
        WechatPushService::VipExpire($user_id);
        MobileMsgService::vipExpire($user_id);
    }

    /**
     * 活动取消通知
     * @param  [type] $activity_id [取消活动的ID]
     * @return [type]              [description]
     */
    public static function cancelActivity($activity_id)
    {
        $answer = Answer::find()
                ->where([
                    'activity_id'=>$activity_id,
                    'paid'=>Answer::PAID_YES,
                    'pay_status'=>Answer::PAY_SUCCESS,
                    'apply_status' =>Answer::APPLY_STATUS_YES,
                    'status'=>Answer::STATUS_REVIEW_PASS,
                ])
                ->asArray()
                ->all();
        $activity = Activity::find()
                ->where(['id'=>$activity_id])
                ->asArray()
                ->one();
        WechatPushService::CancelActivity($answer, $activity);
        MobileMsgService::cancelActivity($answer, $activity);
    }

    /**
     * 用户申诉结果通知
     * @param  [type] $yellowcard_id [申诉的黄牌ID]
     * @return [type]                [description]
     */
    public static function appealResult($yellowcard_id)
    {
        WechatPushService::AppealResult($yellowcard_id);
    }

    /**
     * 用户报名通知发起人
     * @param  [type] $activity_id [要通知的活动id]
     * @return [type]              [description]
     */
    public static function userApply($activity_id)
    {
        WechatPushService::UserApply($activity_id);
    }

    /**
     * 报名失败通知
     * @param  [type] $answer_id [description]
     * @return [type]            [description]
     */
    public static function faild($answer_id)
    {
        WechatPushService::Failed($answer_id);
        MobileMsgService::Failed($answer_id);
    }


    /**
     * 活动签到通知
     * @param  [type] $answer_id [报名ID]
     * @return [type]            [description]
     */
    public static function checkIn($answer_id)
    {
        WechatPushService::CheckIn($answer_id);
    }

    /**
     * 用户信用变更
     * @param  [type] $yellowcard_id [黄牌ID]
     * @return [type]                [description]
     */
    public static function updateCredit($yellowcard_id)
    {
        $push_type =  WechatPush::TYPE_CREDIT_CHANGE;
        // 请假后发送信用变更的微信push
        WechatPushService::UpdateCredit($yellowcard_id, $push_type);
    }



    public static function systemCancel($activity_id)
    {
        system(\DockerEnv::APP_DIR."/yii update/cancel-activity {$activity_id}", $return_val);
    }
}
