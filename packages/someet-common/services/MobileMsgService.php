<?php
namespace someet\common\services;

use dektrium\user\models\Account;
use someet\common\models\Activity;
use someet\common\models\Noti;
use someet\common\models\PushLog;
use someet\common\models\WechatPush;
use app\components\NotificationTemplate;
use app\components\NotiMobileMsg;
use someet\common\models\QuestionItem;
use someet\common\models\AnswerItem;
use someet\common\models\Answer;
use someet\common\models\Refund;
use someet\common\models\User;
use someet\common\models\YellowCard;
use someet\common\models\ActivityOrder;
use someet\common\services\ActivityService;
use someet\common\services\AnswerService;
use someet\common\services\WechatPushService;
use someet\common\services\RefundService;
use someet\common\models\ActivityType;
use someet\common\services\ActivityOrderService;
use yii\web\Response;
use yii\db\ActiveQuery;
use Yii;

class MobileMsgService extends BaseService
{
    /**
     * 支付过期短信提醒
     * @param  [type] $user    [description]
     * @param  [type] $answer  [description]
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public static function payLate($user, $answer, $account)
    {
        $answer_id = $answer ->id;
        $user_id = $answer ->user_id;
        $activity_id = $answer->activity_id;
        $option='fetchPayLateSmsData';
        $type='20';
        $openid  =$account ->client_id;
        $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type);

        if ($res=='fail') {
            $note = '活动支付过期短信提醒';
            $data='';
            $error_log='活动支付过期短信加入数据库失败';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } elseif ($res=='exists') {
            $note = '活动支付过期短信提醒';
            $data='';
            $error_log='活动支付过期短信数据库已存在';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } else {
            return true;
        }
    }

    /**
     * 会员过期提醒
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public static function vipExpire($user_id)
    {
        $user = User::findOne($user_id);
        $activity_id = 0;
        $type='20';
        $option = 'fetchVipExpireSmsData';
        $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type);
        if ($res=='fail') {
            $note = '会员过期短信提醒';
            $data='';
            $error_log='会员过期短信加入数据库失败';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } elseif ($res=='exists') {
            $note = '会员过期短信提醒';
            $data='';
            $error_log='会员过期短信数据库已存在';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } else {
            return true;
        }
    }

    /**
     * 活动取消提醒
     * @param  [type] $answer   [description]
     * @param  [type] $activity [description]
     * @return [type]           [description]
     */
    public static function cancelActivity($answer, $activity)
    {
        $u= User::find();
        $activity_id = $activity['id'];
        $type='20';
        $option = 'fetchCancelActivitySmsData';
        foreach ($answer as $row) {
            $user = $u ->where(['id'=>$row['user_id']])->one();
            $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type);
            if ($res=='fail') {
                $note = '活动取消短信提醒';
                $data='';
                $error_log='活动短信加入数据库失败';
                WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
            } elseif ($res=='exists') {
                $note = '活动取消短信提醒';
                $data='';
                $error_log='活动取消短信数据库已存在';
                WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
            } else {
                return true;
            }
        }
    }

    /**
     * 用户报名成功
     * @param [type] $answer_id [description]
     */
    public static function Success($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user = User::findOne($answer->user_id);
        $activity_id = $answer->activity_id;
        $option = 'fetchSuccessSmsData';
        $type = Answer::STATUS_REVIEW_PASS;
        $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type);
        if ($res=='fail') {
            $note = '报名通过短信提醒';
            $data='';
            $error_log='报名通过短信加入数据库失败';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } elseif ($res=='exists') {
            $note = '报名通过短信提醒';
            $data='';
            $error_log='报名通过短信数据库已存在';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } else {
            return true;
        }
    }

    /**
     * 用户报名失败
     * @param [type] $answer_id [description]
     */
    public static function Failed($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user = User::findOne($answer->user_id);
        $activity_id = $answer->activity_id;
        $option = 'fetchFailSmsData';
        $reson = $answer ->reject_reason;
        $type = Answer::STATUS_REVIEW_REJECT;
        $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type, $reson);
        if ($res=='fail') {
            $note = '报名未通过短信提醒';
            $data='';
            $error_log='报名未通过短信加入数据库失败';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } elseif ($res=='exists') {
            $note = '报名未通过短信提醒';
            $data='';
            $error_log='报名未通过短信数据库已存在';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } else {
            return true;
        }
    }
    /**
     * 通知参加活动
     * @param [type] $answer_id [description]
     * @param [type] $weather   [description]
     */
    public static function Noti($answer_id, $weather)
    {
        $answer = Answer::findOne($answer_id);
        $user = User::findOne($answer->user_id);
        $activity_id = $answer->activity_id;
        $option = 'fetchNotiSmsData';
        $reson = $answer ->reject_reason;
        $type = Answer::STATUS_REVIEW_PASS;
        $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type, $reson, $weather);
        if ($res=='fail') {
            $note = '通知参加活动短信提醒';
            $data='';
            $error_log='通知参加活动短信加入数据库失败';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } elseif ($res=='exists') {
            $note = '通知参加活动短信提醒';
            $data='';
            $error_log='通知参加活动短信数据库已存在';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } else {
            return true;
        }
    }

    /**
     * 通知反馈
     * @param [type] $answer_id [description]
     */
    public static function NeedFeedback($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user = User::findOne($answer->user_id);
        $activity_id = $answer->activity_id;
        $option = 'fetchNeedFeedbackSmsData';
        $type = Answer::STATUS_REVIEW_PASS;
        $res = NotiMobileMsg::addMobilemsg($user, $activity_id, $option, $type);
        if ($res=='fail') {
            $note = '通知反馈活动短信提醒';
            $data='';
            $error_log='通知反馈活动短信加入数据库失败';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } elseif ($res=='exists') {
            $note = '通知反馈活动短信提醒';
            $data='';
            $error_log='通知反馈活动短信数据库已存在';
            WechatPushService::addPushLog($type, $note, $data, $openid, $user_id, $activity_id, $error_log);
        } else {
            return true;
        }
    }
}
