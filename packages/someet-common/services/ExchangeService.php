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
use yii\web\Response;
use Yii;
use yii\db\ActiveQuery;

class ExchangeService extends BaseService
{
    /**
   * 单一打折卡处理   待用.
   *
   * @param  $codeinfo 兑换码信息 $user_id 用户id $open_id 微信Id
   *
   * @return json 错误信息
   */
  public function oneVip($codeinfo, $user, $user_id, $openid)
  {
      if (!$codeinfo) {
          return ['status' => -1, 'data' => '兑换码信息错误'];
      }
      //查询对应的会员级别的信息
      $vipinfo = VipInfo::find()
          ->where(['level' =>$codeinfo->level])
          ->one();
      if (!$vipinfo) {
          return ['status' => -1, 'data' => '兑换码信息错误'];
      }

      //非会员
      if ($user->vip <= 0) {
          $user->vip = $vipinfo ->level;
          $user->expire_time = time() + $codeinfo->level * 3600 * 24;
          // $value->cdkey=$codeinfo->cdkey;
          if ($user->save()) {
              self::addexchangeuser($codeinfo, $user, $user_id, $openid);

              return ['status' => 1, 'data' => '兑换成功'];
          } else {
              return ['status' => 0, 'data' => '兑换失败'];
          }
      } else {

//          return ['status' => 1, 'data' => '您已经是会员了,无法兑换'];
          //判断兑换码对应的会员信息
          //是会员
          $user->expire_time = $user->expire_time + $codeinfo->level * 3600 * 24;
          if ($user->save()) {
              self::addexchangeuser($codeinfo, $user, $user_id, $openid);

              return ['status' => 1, 'data' => '兑换成功'];
          } else {
              return ['status' => 0, 'data' => '兑换失败'];
          }
      }
  }
  /**
   * 检测兑换码状态
   *
   * @param
   *
   * @return json 错误信息
   */
  public function checkExchange($codeinfo, $user_id,$ex_level = null)
  {
      $user = User::findOne($user_id);
      if ($user->vip==50) {
          return ['status' => 0, 'data' => '自由基会员请联系Someet客服!'];
      }
          // Yii::$app->response->format = Response::FORMAT_JSON;
         //分析该用户是否已经兑换
         $exchanguser = ExchangeUser::find()
                     ->where(['user_id' => $user_id, 'cdkey' => $codeinfo->cdkey])
                     ->one();
      if ($exchanguser) {
          if($user->vip == 15){
              return ['status' => 0, 'data' => "抱歉，您已经使用过该兑换码啦!<br> 把它分享给你的朋友，邀请TA一起加入Someet吧!"];
          }
          return ['status' => 0, 'data' => '抱歉，您已经使用过该兑换码了'];
      }
      if(!$ex_level){
          $ex_level = VipInfo::EXPIRE_VIP;
      }

             //分析用户有没有使用过兑换码

         $cnums = ExchangeUser::find()
                 ->where(['and', [
                   'user_id' => $user_id
                 ],
                 ['=', 'level', $ex_level],
               ])
                 ->count();
      if ($cnums >= 1 && $codeinfo ->level == $ex_level) {
          return ['status' => 0, 'data' => '抱歉，您已兑换过体验卡'];
      }
         //分析盖兑换码是否超过使用次数
     if ($codeinfo->count >= $codeinfo->exchange_limit) {
         return ['status' => 0, 'data' => '抱歉，您的兑换码已超出使用次数如有疑问请在Someet活动平台留言（微信号：Someetinc）'];
     }

         //分析兑换码的使用期限
         $now = time();
      if ($codeinfo->expire_time < $now && $codeinfo ->type != Exchange::NO_LIMIT) {
          return ['status' => 0, 'data' => '抱歉，您的兑换码已过期如有疑问请在Someet活动平台留言（微信号：Someetinc）'];
      }

         //判断兑换码是否被禁用
         switch ($codeinfo->status) {
             case '20':
                 return ['status' => 0, 'data' => '抱歉，您的兑换码已失效如有疑问请在Someet活动平台留言（微信号：Someetinc）'];
                 //die;
                 break;

             case '30':
                 return ['status' => 0, 'data' => '抱歉，您的兑换码已失效如有疑问请在Someet活动平台留言（微信号：Someetinc）'];
                 //die;
                 // code...
                 break;
         }

      return ['status' => 1, 'data' => '系统正常'];
  }

  /**
   * 体验会员兑换写入.
   *
   * @param  $codeinfo 兑换码信息 $user_id 用户id $open_id 微信Id
   *
   * @return json 错误信息   object  兑换码信息
   */
  public function experienceVip($codeinfo, $user, $user_id, $openid)
  {
      if (!$codeinfo) {
          return ['status' => -1, 'data' => '兑换码信息错误'];
      }
      //查询对应的会员级别的信息
        $vipinfo = VipInfo::find()
                  ->where(['level' =>$codeinfo->level])
                  ->one();
      if (!$vipinfo) {
          return ['status' => -1, 'data' => '兑换码信息错误'];
      }

      //非会员
      if ($user->vip <= 0) {
          $user->vip = $vipinfo ->level;
          $user->expire_time = time() + 66 * 3600 * 24;
          // $value->cdkey=$codeinfo->cdkey;
          if ($user->save()) {
              self::addexchangeuser($codeinfo, $user, $user_id, $openid);

              return ['status' => 1, 'data' => '兑换成功'];
          } else {
              return ['status' => 0, 'data' => '兑换失败'];
          }
      } else {
          //判断兑换码对应的会员信息
          //是会员
          $user->expire_time = $user->expire_time + 66 * 3600 * 24;
          if ($user->save()) {
              self::addexchangeuser($codeinfo, $user, $user_id, $openid);

              return ['status' => 1, 'data' => '兑换成功'];
          } else {
              return ['status' => 0, 'data' => '兑换失败'];
          }
      }
  }

  /**
   * 兑换用户写入数据表.
   *
   * @param  $codeinfo 兑换码信息 $user_id 用户id $open_id 微信Id
   *
   * @return json 错误信息
   */
  public function addexchangeuser($codeinfo, $user, $user_id, $openid)
  {
      $exuser = new ExchangeUser();
      $exuser->user_id = $user_id;
      $exuser->username = $user->username;
      $exuser->openid = $openid;
      $exuser->moblie = $user->mobile;
      $exuser->exchange_id = $codeinfo->id;
      $exuser->created_at = time();
      $exuser->cdkey = $codeinfo->cdkey;
      $exuser->level = $codeinfo->level;
      $exuser->status = $codeinfo->status;
      // $exuser->save();
      if ($exuser->save()) {
          $exchange = Exchange::findOne($codeinfo->id);
          $exchange->count = $codeinfo->count + 1;
          $exchange->save();

          return 1;
      } else {
          return 0;
      }
  }

  /**
   * 获取兑换码信息.
   *
   * @param string $cdkey 兑换码id
   *
   * @return object 兑换码信息
   */
  public function getExchangeInfo($cdkey= '')
  {
      $msg = [];

      if (!$cdkey) {
          $msg = ['status' => 0, 'data' => '兑换码信息错误'];
      }
      $cinfo = Exchange::find()
              ->where(['cdkey' => $cdkey])
              ->one();
      if (!$cinfo) {
          $msg = ['status' => 0, 'data' => '未查询到兑换码信息'];
      }
      if (!empty($msg)) {
          return $msg;
      }

      return $cinfo;
  }
  /**
   * 普通打折卡处理   待用.
   *
   * @param  $codeinfo 兑换码信息 $user_id 用户id $open_id 微信Id
   *
   * @return json 错误信息
   */
  public function allVip($codeinfo, $discount)
  {
      $user_id = Yii::$app->user->id;
      //用户信息
      $user = User::findOne($user_id);
      //账号信息
      $account = Account::find()
                  ->where(['user_id' => $user_id])
                  ->one();
      $openid = $account->client_id;
      //会员信息
         $vipinfo = Vip::find()
                 ->where(['user_id' => $user_id])
                 ->one();
         //判断用户是否为会员
         if (!$vipinfo) {
             //非会员
             echo '跳转购买页';
         } else {
             //增加再次购买打折属性
             echo '下次购买打折';
         }
  }
}
