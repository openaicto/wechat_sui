<?php
namespace someet\common\services;

use someet\common\models\YellowCard;
use someet\common\models\Answer;
use someet\common\models\ActivityOrder;
use someet\common\models\AppPush;
use someet\common\models\Refund;
use someet\common\models\Activity;
use someet\common\models\User;
use dektrium\user\models\Account;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use idarex\pingppyii2\Channel;
use idarex\pingppyii2\ChargeForm;
use idarex\pingppyii2\PingppComponent;
use yii\web\ServerErrorHttpException;
use yii\web\Response;
use Yii;

/**
 * @Author: wshudong
 * @Date:   2016-07-01 15:58:30
@Last modified by:   stark
@Last modified time: 2016-11-02T15:17:20+08:00
 */

/**
 *  处理退款服务
 */
class RefundService extends BaseService
{
    /**
   * 请假后自动退款
   * @param   $answer answer表数据
   * @return 返回是否退款成功
   */
    public static function askForLeave($answer)
    {
        if (empty($answer)) {
            return ['status' => 0,'data' => '报名信息不存在'];
        }

        if ($answer->price < 1) {
            return ['status' => 0,'data' => '不需要退款'];
        }

        $activity = Activity::findOne($answer->activity_id);

        // 退款金额：百分之五十
        $amount = ($answer->price / 2);

        // 查询有没有退款
        $is_refund = Refund::find()
                    ->where(['order_no' => $answer->order_no])
                    ->exists();
        if ($is_refund) {
            return ['status' => 0,'data' => '该订单存在退款'];
        }

        // 判断时间 小于24小时不用退款，大于24小时退款减半
        $is_in24hours = $answer->activity->start_time - time() < 86400;

        $pingpp_id = $answer->pingpp_id;

        if ($pingpp_id === 0 || empty($pingpp_id)) {
            $ActivityOrder = ActivityOrder::find()
                        ->where(['status' => ActivityOrder::PAY_SUCCESS, 'answer_id' => $answer->id])
                        ->one();
            $pingpp_id = $ActivityOrder->pingpp_id;
        }

        if (empty($pingpp_id)) {
            return ['status' => 0,'data' => 'ping++ id 不存在'];
        }

        $description = $activity->title.'活动请假退款';

        if (!$is_in24hours) {
            return self::Refund($pingpp_id, $amount, $description, $answer);
        }
        return ['status' => 0,'data' => '时间小于24小时，不需要退款'];
    }

  /**
   * 单条退款
   * @return 退款成功 和 失败的信息
   */
  public static function Refund($pingpp_id, $amount, $description, $answer)
  {
      $pingppRefund = \Yii::$app->pingpp;

      $user_id = Yii::$app->user->id;
      $user = User::findOne($user_id);
      // 获取用户的openid
      $account = Account::find()
          ->where(['user_id' => $user_id ])
          ->one();
      $openid = $account->client_id;

      $amount = $amount * 100;
      $pingppResult = json_decode($pingppRefund->refunds($pingpp_id, $amount, $description));
      $refund = new Refund();
      $refund->refund_order_no = $pingppResult->order_no;
      $refund->order_no = $pingppResult->charge_order_no;
      $refund->user_id = $user_id;
      $refund->username = $user->username;
      $refund->openid = $openid;
      $refund->mobile = $user->mobile;
      $refund->answer_id = $answer->id;
      $refund->pingpp_id = $pingpp_id;
      $refund->price = $amount / 100;
      $refund->transaction_no = $pingppResult->transaction_no;
      $refund->handle_person = 0;
      $refund->description = $description;
      $refund->created_at = time();
      $newAnswer = Answer::findOne($answer->id);
      $newAnswer->refunded = Answer::REFUNDED_YES;
      $newAnswer->save();
      if ($refund->save()) {
          // 发送退款push
          WechatPushService::ActivityRefund($refund->id);
          return ['status' => 1,'data' => $refund];
      }
      return ['status' => 2,'data' => $refund];
  }

  /**
   * 获取pingpp_id
   * @param  [type] $order_no [description]
   * @return [type]           [description]
   */
  public function fetchPingppId($order_no)
  {
      $sub_order_no = substr($order_no, 0, 3);
      if ($sub_order_no == 'act') {
          $actOrder = ActivityOrder::find()
                      ->where(['order_no' => $order_no])
                      ->one();
          if (empty($actOrder)) {
              return '订单不存在';
          }
          return $actOrder->pingpp_id;
      } elseif ($sub_order_no == 'vip') {
          $vip = Vip::find()
                ->where(['order_no' => $order_no])
                ->one();
          if (empty($vip)) {
              return '订单不存在';
          }
          return $vip->pingpp_id;
      }
  }
}
