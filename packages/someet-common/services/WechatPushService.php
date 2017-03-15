<?php

namespace someet\common\services;

use dektrium\user\models\Account;
use someet\common\models\Activity;
use someet\common\models\PushLog;
use someet\common\models\WechatPush;
use app\components\NotificationTemplate;
use app\components\WechatTpl;
use someet\common\components\CommonFunction;
use someet\common\models\Answer;
use app\components\MobileTpl;
use someet\common\models\Refund;
use someet\common\models\User;
use someet\common\models\YellowCard;

/**
 * 微信push服务
 * 用户报名通过
 * 用户报名不通过
 * 信用变更
 * 支付即将过期
 * 活动前提醒
 * 退款通知
 * 会员到期提醒
 * 活动取消
 * 申诉成功
 * 活动签到
 * 活动结束后反馈提醒
 * 发起人
 * 用户报名
 * 活动发布提醒
 * 活动结算
 * 发起人反馈提醒.
 */
class WechatPushService extends BaseService
{
    /**
     * 给用户订阅成功后反馈
     * @return [type] [description]
     */
    public static function subscribeSuccess($user_id)
    {
        // 共有x场活动等待你的加⼊入
        // 查询本周在个人订阅里面有多少场活动是新的活动
        // 查询用户订阅了哪个标签
        // 本周发布了多少活动
        // 这些活动属于哪个标签下面的
        // 这个是添加了关闭活动显示, 为了将同一组的活动只显示一个, 加了 is_display 属性

        $activity = Activity::find()
            ->joinWith('type')
            ->with('rTagActivity')
            ->where(
                ['and',
                    ['activity_type.status' => ActivityType::STATUS_NORMAL],
                    ['>', 'activity.end_time', getLastEndTime()],
                    ['is_display' => Activity::DISPLAY_YES],
                    ['activity.status' => Activity::STATUS_RELEASE],
                ]
            )
            ->asArray()
            ->all();
            $user_act_tags = UserActTags::find()
                                ->where(['status' => UserActTags::SUB,'user_id' => $user_id])
                                ->all();

        $user_act_tags_new = [];
            foreach ($user_act_tags as $key => $value) {
                $user_act_tags_new[] = $value['tag_act_id'];
            }
        $count = 0;
        foreach ($activity as $key => $value) {
            $data = RTagActivity::find()->where(['tag_id' => $user_act_tags_new,'activity_id' => $value['id']])->exists();
            if ($data) {
                $count ++;
            }
        }
        return $count;
    }


    /**
     * 给用户反馈的提醒.
     *
     * @param int $answer_id 报名id
     *
     * @return [type] [description]
     */
    public static function feedbackNoti($answer_id)
    {
        //获取报名信息
        $answer = Answer::find()->where(['id' => $answer_id])->with(['activity'])->one();
        $user_id = $answer->user_id;
        // 获取openid
        $openid = CommonFunction::getOpenid($user_id);
        $activity = Activity::findOne($answer->activity_id);
        // 获取报名成功的push模板
        $data = WechatTpl::applyPass($answer_id);
        $pushData = [
            'type' => WechatPush::TYPE_ACT_FEADBACK,
            'answer_id' => $answer_id,
            'from_id' => $activity->id,
            'from_type' => 'activity',
            'note' => '用户报名通过提醒',
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        if (!$result) {
            $error_log = '用户报名通过存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 用户报名通过.
     *
     * @param [type] $answer_id [description]
     *
     * @return [type] [description]
     */
    public static function applyPass($answer_id)
    {
        //获取报名信息
        $answer = Answer::find()->where(['id' => $answer_id])->with(['activity'])->one();
        $user_id = $answer->user_id;
        $user = User::findOne($user_id);
        // 获取openid
        $openid = CommonFunction::getOpenid($user_id);
        $activity = Activity::findOne($answer->activity_id);
        // 获取报名成功的push模板
        $data = WechatTpl::applyPass($openid, $user_id, $answer->activity_id, $answer_id);
        $pushData = [
            'type' => WechatPush::TYPE_APPLY_PASS,
            'answer_id' => $answer_id,
            'from_id' => $activity->id,
            'from_type' => 'activity',
            'note' => '用户报名通过提醒',
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        // 添加到微信push数据
        $result = self::addWechatPush($pushData);

        // 获取短信内容
        $mcontent = MobileTpl::ApplySuccess($activity->title, $activity->start_time);
        $mdata = [
            'type' => WechatPush::TYPE_APPLY_PASS,
            'answer_id' => $answer_id,
            'content' => $mcontent,
            'user_id' => $user_id,
            'note' => '用户报名通过提醒',
        ];
        // 添加到短信push数据
        MobilePushService::createMobilePush($mdata);
        if (!$result) {
            $error_log = '用户报名通过存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 用户报名不通过.
     *
     * @param $answer_id  报名ID
     *
     * @return bool
     */
    public function applyFailed($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user_id = $answer->user_id;
        $openid = CommonFunction::getOpenid($user_id);
        $activity_id = $answer->activity_id;
        $activity = Activity::findOne($activity_id);
        $data = WechatTpl::applyFailed($answer_id);
        $pushData = [
            'type' => WechatPush::TYPE_APPLY_REJECT,
            'answer_id' => $answer_id,
            'from_id' => $activity_id,
            'from_type' => 'activity',
            'note' => '用户未通过提醒',
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        // 获取短信内容
        $mcontent = MobileTpl::ApplyFail($activity->title, $activity->start_time, $answer->reject_reason);
        $mdata = [
            'type' => WechatPush::TYPE_APPLY_REJECT,
            'answer_id' => $answer_id,
            'content' => $mcontent,
            'user_id' => $user_id,
            'note' => '用户未通过提醒',
        ];
        // 添加到短信push数据
        MobilePushService::createMobilePush($mdata);

        if (!$result) {
            $error_log = '用户未通过提醒通知存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 活动信用变更.
     *
     * @param [type] $yellowcard_id [description]
     */
    public function updateCredit($yellowcard, $type)
    {
        // $yellowcard = YellowCard::findOne($yellowcard_id);
        $activity = Activity::find()->where(['id' => $yellowcard->activity_id])->asArray()->one();
        $user_id = $yellowcard->user_id;
        $answer = Answer::find()->where(['user_id' => $user_id, 'activity_id' => $activity['id']])->select('id')->one();
        $openid = CommonFunction::getOpenid($user_id);
        $data = WechatTpl::updateCredit($openid, $activity, $yellowcard);
        $from_type = 'yellowcard';
        $note = WechatPush::$arrType[$type];
        $pushData = [
            'type' => $type,
            'answer_id' => $answer_id,
            'from_id' => $yellowcard->id,
            'from_type' => 'yellowcard',
            'note' => $note,
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        if (!$result) {
            $error_log = '活动信用变更提醒通知存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 活动退款通知 前台 后台.
     *
     * @param [type] $refund_id   [退款ID]
     * @param [type] $activity_id [退款活动ID]
     */
    public static function ActivityRefund($refund_id)
    {
        $refund = Refund::findOne($refund_id);
        $user_id = $refund->user_id;
        $openid = $refund->openid;
        $activity_id = Answer::findOne($refund->answer_id)->activity_id;
        $activity = Activity::findOne($activity_id);
        $data = WechatTpl::ActivityRefund($openid, $activity, $refund);
        $from_type = 'refund';
        $pushData = [
            'type' => WechatPush::TYPE_REFUND,
            'answer_id' => $refund->answer_id,
            'from_id' => $refund->id,
            'from_type' => 'refund',
            'note' => '活动退款提醒',
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        if (!$result) {
            $error_log = '活动退款提醒通知存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 申诉结果通知 调用方式 WechatPushService::AppealResult($yellowcard_id);.
     *
     * @param [type] $yellowcard_id [黄牌ID]
     */
    public static function AppealResult($yellowcard_id)
    {
        $yellowcard = YellowCard::findOne($yellowcard_id);
        $user_id = $yellowcard->user_id;
        $openid = CommonFunction::getOpenid($user_id);
        $data = WechatTpl::AppealResult($openid, $yellowcard);
        $pushData = [
            'type' => WechatPush::TYPE_APPEAL_SUCCESS,
            'answer_id' => $answer_id,
            'from_id' => $yellowcard->id,
            'from_type' => 'yellowcard',
            'note' => '申诉结果提醒',
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        if (!$result) {
            $error_log = '申诉结果提醒通知存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 用户报名通知.
     *
     * @param [type] $openid   [description]
     * @param [type] $activity [description]
     */
    public static function UserApply($activity_id)
    {
        $activity = Activity::find()
                ->where(['id' => $activity_id])
                ->asArray()
                ->one();
        $user_id = $activity['created_by'];
        $account = Account::find()
                ->where(['user_id' => $user_id])
                ->one();
        $openid = $account->client_id;
        $data = NotificationTemplate::fetchUserApplyWechatTemplateData($openid, $activity);
        $from_type = 'userapply';
        $note = '用户报名提醒';
        $is_add = self::addWechatPush($from_type, $note, $data, $openid, $user_id, $activity_id);
        if ($is_add) {
            return true;
        } else {
            $error_log = '用户报名提醒通知存储失败';
            self::addPushLog($from_type, $note, $data, $openid, $user_id, $user_id, $error_log);

            return false;
        }
    }

    /**
     * 签到.
     *
     * @param [type] $answer_id [description]
     */
    public function CheckIn($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user_id = $answer->user_id;
        $userinfo = User::findone($user_id);
        $activity_id = $answer->activity_id;
        // 获取openid
        $openid = CommonFunction::getOpenid($user_id);
        $activity = Activity::find()->where(['id' => $activity_id])->asArray()->one();
        // 获取活动签到模板
        $data = WechatTpl::checkIn($openid, $userinfo->username, $activity);
        $from_id = $answer_id;
        $from_type = 'checkin';
        $note = '用户签到提醒';
        $pushData = [
            'type' => WechatPush::TYPE_CHECK_IN,
            'answer_id' => $answer_id,
            'from_id' => $activity_id,
            'from_type' => $from_type,
            'note' => $note,
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        if (!$result) {
            $error_log = '用户签到提醒通知存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 用户取消报名信用变更.
     *
     * @param [type] $answer_id [description]
     */
    public static function UserCancelApply($answer_id)
    {
        $answer = Answer::findOne($answer_id);
        $user_id = $answer->user_id;
        // 获取openid
        $openid = CommonFunction::getOpenid($user_id);
        $data = WechatTpl::CancelApply($openid, $answer);
        $pushData = [
            'type' => WechatPush::TYPE_USER_CANCEL_APPLY,
            'answer_id' => $answer_id,
            'from_id' => $answer->activity_id,
            'from_type' => 'activity',
            'note' => '用户取消报名',
            'data' => $data,
            'openid' => $openid,
            'user_id' => $user_id,
        ];
        $result = self::addWechatPush($pushData);
        if (!$result) {
            $error_log = '用户取消报名通知存储失败';
            self::addPushLog($pushData, $error_log);

            return false;
        }

        return true;
    }

    /**
     * 添加微信推送记录.
     *
     * @param [type] $from_type [description]
     * @param [type] $note      [推送的通知名称]
     * @param [type] $data      [通知内容的数据]
     * @param [type] $openid    [description]
     * @param [type] $user_id   [description]
     * @param [type] $activity  [description]
     */
    public static function addWechatPush($pushData)
    {
        $answer_id = $pushData['answer_id'];
        $type = $pushData['type'];
        $from_type = $pushData['from_type'];
        $note = $pushData['note'];
        $data = $pushData['data'];
        $openid = $pushData['openid'];
        $user_id = $pushData['user_id'];
        $from_id = $pushData['from_id'];

        $noti = new WechatPush();
        $noti->status = WechatPush::STATUS_DEFAULT;
        $noti->answer_id = $answer_id;
        $noti->type = $type;
        $noti->from_type = $from_type;
        $noti->from_id = $from_id;
        $noti->user_id = $user_id;
        $noti->data = json_encode($data);
        $noti->join_queue_at = 0;
        $noti->note = $note;
        $noti->openid = $openid;
        $noti->url = $data['url'];
        $noti->template_id = $data['template_id'];
        $noti->created_at = time();
        if ($noti->save()) {
            return true;
        }

        return false;
    }

    /**
     * 推送加入数据库错误记录.
     *
     * @param [type] $from_type [description]
     * @param [type] $note      [description]
     * @param [type] $data      [description]
     * @param [type] $openid    [description]
     * @param [type] $user_id   [description]
     * @param [type] $activity  [description]
     * @param [type] $error_log [错误原因]
     */
    public function addPushLog($pushData, $error_log)
    {
        $answer_id = $pushData['answer_id'];
        $type = $pushData['type'];
        $from_type = $pushData['from_type'];
        $note = $pushData['note'];
        $data = $pushData['data'];
        $openid = $pushData['openid'];
        $user_id = $pushData['user_id'];
        $from_id = $pushData['from_id'];

        $push = new PushLog();
        $push->openid = $openid;
        $push->note = $note;
        $push->from_id = $from_id;
        $push->from_type = 'pay';
        $push->user_id = $user_id;
        $push->error_log = $error_log;
        $push->create_time = time();
        $push->template_id = isset($data['template_id']) ? $data['template_id'] : '';
        $push->save();
    }
}
