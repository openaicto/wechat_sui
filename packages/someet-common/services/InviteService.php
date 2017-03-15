<?php
namespace someet\common\services;

use dektrium\user\models\Account;
use someet\common\models\Activity;
use someet\common\models\Noti;
use someet\common\models\NotificationTemplate;
use someet\common\models\QuestionItem;
use someet\common\models\InviteRcords;
use someet\common\models\AnswerItem;
use someet\common\models\Answer;
use someet\common\models\User;
use someet\common\models\VipInfo;
use someet\common\models\Vip;
use someet\common\models\ActivityType;
use someet\common\models\YellowCard;
use someet\common\models\InviteRecords;
use someet\common\services\BackendEventService;
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;

class InviteService extends BaseService
{
    /**
   * 增加邀请记录
   * @param [type] $invite_user [description]
   */
    public function addRecords($invite_user)
    {
        $invite = new InviteRecords();
        foreach ($invite_user as $key => $value) {
            $invite ->$key = $value;
        }
        if ($invite->save()) {
            return true;
        }
        return false;
    }
    /**
     * 增加邀请记录，并增加邀请者的福利
     * @param [type] $uid   [description]
     * @param [type] $user  [description]
     * @param [type] $level [description]
     */
    public function addExpire($uid, $user, $level)
    {
        if ($uid) {
            $uinfo = User::findOne($uid);
            if ($uinfo->vip==0) {
                return false;
            }
            $invite = new InviteRecords();
            //邀请人的ID
            $invite_user_id=$uid;
            //记录邀请记录
            $invite->user_id = $invite_user_id;
            
            $invite->invite_user_id = $user->id;
            $invite->invite_action = 'vip';
            $invite->created_time = time();
            $invite->invite_vip =$level;
            $invite->save();
            //增加邀请者的福利；，同意增加30天
            $userinfo=User::findOne($invite_user_id);

            $userinfo->expire_time=$userinfo->expire_time+30*3600*24;

            $userinfo->save();
            return true;
        }
    }
}
