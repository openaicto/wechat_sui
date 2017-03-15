<?php
/**
 * Created by PhpStorm.
 * User: maxwelldu
 * Date: 23/8/2016
 * Time: 1:06 PM.
 */
namespace someet\common\components;

use idarex\pingppyii2\Hooks;
use idarex\pingppyii2\HooksInterface;
use someet\common\models\User;
use someet\common\models\Vip;
use someet\common\models\PayLog;
use someet\common\models\Answer;
use someet\common\models\PinghookErr;
use someet\common\models\Refund;
use someet\common\services\PingppHooksService;
use someet\common\services\InviteService;
use someet\common\models\ActivityOrder;
use Yii;

class PingppHooks extends Hooks implements HooksInterface
{
    /**
     * {@inheritdoc}
     */
    public function onAvailableDailySummary()
    {
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onAvailableWeeklySummary()
    {
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onAvailableMonthlySummary()
    {
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onSucceededCharge()
    {
        $paid_charge = $this->event->data->object;
        $order_no = $paid_charge->order_no;
        $pingpp_id = $paid_charge->id;
        // 判断订单号 是vip 还是活动订单
        $sub_order_no = substr($order_no, 0, 3);

        $pinghookData = [
            'pingpp_id' => $pingpp_id,
            'callback' => $paid_charge,
            'hook_created' => $paid_charge->created,
            'failure_code' => $paid_charge->failure_code,
            'failure_msg' => $paid_charge->failure_msg,
            'object' => $paid_charge->object,
            'amount' => $paid_charge->amount,
            'order_no' => $paid_charge->order_no,
        ];

        $pinghookFlag = 0;

        // 判断支付成功后是活动订单号还是vip订单号
        if ($sub_order_no == 'act') {
            $actOrder = ActivityOrder::find()
            ->where(['order_no' => $order_no])
            ->one();

            $answer = Answer::findOne($actOrder->answer_id);

            if (empty($actOrder)) {
                return '订单不存在';
            }

            $charges = ($actOrder->price * $actOrder->discount / 100);

            // 支付成功后 更新订单表：支付时间 支付成功时间
            $actOrder->paid_time = $paid_charge->time_paid;
            $actOrder->pay_price = $charges;
            $actOrder->pay_time = time();
            $actOrder->status = Answer::PAY_SUCCESS;
            $actOrder->save();

            $answer->pingpp_id = $pingpp_id;
            $answer->order_no = $paid_charge->order_no;
            $answer->paid = $paid_charge->paid ? 1 : 0;
            // 支付成功后 更新answer报名表：支付时间 支付成功时间
            $answer->pay_status = Answer::PAY_SUCCESS;
            $answer->pay_time = $paid_charge->time_paid;
            $answer->save();
        } elseif ($sub_order_no == 'vip') {
            $vip = Vip::find()
                    ->where(['order_no' => $order_no])
                    ->one();
            if ($vip) {
                // 用户需要更新的vip等级
                $vipLevel = $vip->level;

                // 更新用户的vip级别
                $user = User::findOne($vip->user_id);

                // if (!empty($vipLevel)) {
                //     $user->vip = $vipLevel;
                //     if (!$user->validate('vip')) {
                //         throw new DataValidationFailedException($user->getFirstError('vip'));
                //     }
                // }
                //获取额外字段，good_tag用于判断是否为邀请购买会员
                $extra = $paid_charge->extra;
                $goods_tag = 0;
                if ($extra->goods_tag) {
                    $goods_tag=$extra->goods_tag;
                }
                if (!$goods_tag) {
                    $new_paid_charge = \Yii::$app->pingpp->retrieve($pingpp_id);
                    $new_extra = $new_paid_charge->extra;
                    $goods_tag = $new_extra['goods_tag'];
                }

                //更新会员的到期时间，如果存在$goods_tag,且不为0，则说明是邀请成为会员，则双方增加相应的时长，本段代码，仅增加，被邀请人的时长，邀请人的时长则在邀请记录之后记录
                if ($vipLevel == 10 || $vipLevel == 20) {
                    //三个月
                    if ($goods_tag && $goods_tag !='0') {
                        
                        if($user->expire_time-3600*24*7 <= time() && $user->expire_time > time() && $user->vip > 0){
                            $user->expire_time =$user->expire_time + 8208000+15*24*3600+15*24*3600;
                        }elseif($user->vip < 0 ){
                            $user->expire_time = $paid_charge->created + 8208000+15*24*3600+15*24*3600;
                        }else{
                            $user->expire_time = $paid_charge->created + 8208000+15*24*3600;
                        }
                    } else {
                        if($user->expire_time-3600*24*7 <= time() && $user->expire_time > time() && $user->vip > 0){
                            $user->expire_time =$user->expire_time + 8208000+15*24*3600;
                        }elseif($user->vip < 0 ){
                            $user->expire_time = $paid_charge->created + 8208000+15*24*3600;
                        }else{
                            $user->expire_time = $paid_charge->created + 8208000;
                        }
                    }
                    
                } elseif ($vipLevel == 30 || $vipLevel == 40) {
                    //半年
                    if ($goods_tag && $goods_tag !='0') {
                        if($user->expire_time-3600*24*7 <= time() && $user->expire_time > time() && $user->vip > 0){
                            $user->expire_time = $user->expire_time + 16416000+30*24*3600+15*24*3600;
                        }elseif($user->vip < 0 ){
                            $user->expire_time = $paid_charge->created + 16416000+30*24*3600+15*24*3600;
                        }else{
                            $user->expire_time = $paid_charge->created + 16416000+15*24*3600;
                        }
                    } else {
                        if($user->expire_time-3600*24*7 <= time() && $user->expire_time > time() && $user->vip > 0){
                            $user->expire_time = $user->expire_time + 16416000+30*24*3600;
                        }elseif($user->vip < 0 ){
                            $user->expire_time = $paid_charge->created + 16416000+30*24*3600;
                        }else{
                            $user->expire_time = $paid_charge->created + 16416000;
                        }
                    }
                    
                } elseif ($vipLevel == 50) {
                    //全年
                    if ($goods_tag && $goods_tag !='0') {
                        if($user->expire_time-3600*24*7 <= time() && $user->expire_time > time() && $user->vip > 0){
                            $user->expire_time = $user->expire_time + 31968000+45*24*3600+30*24*3600;
                        }elseif($user->vip < 0 ){
                            $user->expire_time = $paid_charge->created + 31968000+45*24*3600+30*24*3600;
                        }else{
                            $user->expire_time = $paid_charge->created + 31968000+30*24*3600;
                        }
                    } else {
                         if($user->expire_time-3600*24*7 <= time() && $user->expire_time > time() && $user->vip > 0){
                            $user->expire_time = $user->expire_time + 31968000+45*24*3600;
                        }elseif($user->vip < 0 ){
                            $user->expire_time = $paid_charge->created + 31968000+45*24*3600;
                        }else{
                            $user->expire_time = $paid_charge->created + 31968000;
                        }
                        
                    }
                   
                }
                $user->vip = $vipLevel;
                //判断是否存在邀请会员支付，如果存在则增加邀请记录并记录邀请人会员福利（被邀请人的福利在上段代码中已经添加）
                if ($goods_tag && $goods_tag !='0') {
                    InviteService::addExpire($goods_tag, $user, $vipLevel);
                }
                $user->save();
                // 更新vip支付的成功
                $vip->status = Vip::PAY_SUCCESS;
                $vip->pingpp_id = $pingpp_id;
                $vip->expire_time = $paid_charge->time_expire;
                $vip->pay_time = $paid_charge->created;
                $vip->pay_price = $paid_charge->amount / 100;
                $vip->paid_time = $paid_charge->time_paid;
                $vip->client_ip = $paid_charge->client_ip;
                $vip->subject = $paid_charge->subject;
                $vip->body = $paid_charge->body;
                $vip->currency = $paid_charge->currency;
                $vip->failure_code = $paid_charge->failure_code;
                $vip->failure_msg = $paid_charge->failure_msg;
                $vip->save();
            } else {
                $pinghookErr = [
                    'type' => PinghookErr::TYPE_VIP,
                    'note' => 'vip订单记录没有查询到',
                ];
                $pinghookFlag = 1;
            }

            $pay_log = PayLog::find()
                        ->where(['order_no' => $order_no])
                        ->one();
            if ($pay_log) {
                $pay_status = $paid_charge->paid;

                if (empty($pay_status)) {
                    $pay_status = 0;
                }

                $pay_log->pay_status = $pay_status;
                $pay_log->save();
            }
        } else {
            if ($pingpp_id == 'ch_Xsr7u35O3m1Gw4ed2ODmi4Lw') {
                $pinghookErr = [
                        'type' => PinghookErr::TYPE_TEST,
                        'note' => 'ping++后台webhook测试数据！',
                    ];
            } else {
                $pinghookErr = [
                    'type' => PinghookErr::TYPE_UNABLE_TO_IDENTIFY,
                    'note' => 'order_no 无法识别！',
                ];
            }
            $pinghookFlag = 1;
        }

        if ($pinghookFlag) {
            $pinghookErrData = array_merge($pinghookData, $pinghookErr);
            PingppHooksService::CreatePinghookErr($pinghookErrData);
        }
        // 插入回调的数据和ping++保持一致
        PingppHooksService::CreatePingppCallback($paid_charge);

        Yii::$app->getResponse()->data = 'finished job';
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onSucceededRefund()
    {
        $refundResult = $this->event->data->object;
        $order_no = $refundResult->order_no;
        // 判断订单号 是vip 还是活动订单
        $sub_order_no = substr($order_no, 0, 3);

        $pingpp_id = $refundResult->charge;
        $pinghookFlag = 0;
        $pinghookData = [
            'pingpp_id' => $pingpp_id,
            'callback' => $refundResult,
            'hook_created' => $refundResult->created,
            'failure_code' => $refundResult->failure_code,
            'failure_msg' => $refundResult->failure_msg,
            'object' => $refundResult->object,
            'amount' => $refundResult->amount,
            'order_no' => $refundResult->order_no,
        ];

        // 退款状态（目前支持三种状态: pending: 处理中 10 默认; succeeded: 成功 20; failed: 失败 30）。
        $status = [
            'pending' => 10,
            'succeeded' => 20,
            'failed' => 30,
            ];

        // 如果是活动则更新退款信息
        if ($sub_order_no == 'act') {
            $answer = Answer::find()
                      ->where(['pingpp_id' => $pingpp_id])
                      ->one();

            if ($answer) {
                // 更新退款记录
                $answer->refunded = 1;
                $answer->save();
            } else {
                $pinghookErr = [
                        'type' => PinghookErr::TYPE_REFUND,
                        'note' => '退款时活动订单记录没有查询到',
                    ];
                $pinghookFlag = 1;
            }
        }

        $refund = Refund::find()
            ->where(['pingpp_id' => $pingpp_id])
            ->one();

        if ($refund) {
            $refund->status = $status[$refundResult->status];
            $refund->succeed = $refundResult->succeed;
            $refund->time_succeed = $refundResult->time_succeed;
            $refund->failure_msg = $refundResult->failure_msg;
            $refund->failure_code = $refundResult->failure_code;
            $refund->time_succeed = $refundResult->time_succeed;
            $refund->save();
        } else {
            if ($pingpp_id == 'ch_Xsr7u35O3m1Gw4ed2ODmi4Lw') {
                $pinghookErr = [
                        'type' => PinghookErr::TYPE_TEST,
                        'note' => 'ping++后台webhook测试数据！',
                    ];
            } else {
                $pinghookErr = [
                    'type' => PinghookErr::TYPE_UNABLE_TO_IDENTIFY,
                    'note' => 'order_no 无法识别！',
                ];
            }
            $pinghookFlag = 1;
        }

        if ($pinghookFlag) {
            $pinghookErrData = array_merge($pinghookData, $pinghookErr);
            PingppHooksService::CreatePinghookErr($pinghookErrData);
        }

        Yii::$app->getResponse()->data = 'finished job';
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onSucceededTransfer()
    {
        try {
            $transferResult = $this->event->data->object;
            $order_no = $transferResult->order_no;
            $pingpp_id = $transferResult->id;

            $status = [
            'pending' => Transfer::STATUS_PENDING,
            'paid' => Transfer::STATUS_PAID,
            'scheduled' => Transfer::STATUS_SCHEDULED,
            'failed' => Transfer::STATUS_FAILED,
            'canceled' => Transfer::STATUS_CANCELED,
            ];

            $transfer = Transfer::find()
                    ->where(['pingpp_id' => $pingpp_id])
                    ->one();
            $transfer->updated_at = time();
            $transfer->status = $status[$transferResult->status];
            $transfer->transaction_no = $transferResult->transaction_no;
            $transfer->time_transferred = $transferResult->time_transferred;
            $transfer->save();
        } catch (\Exception $e) {
            echo "捕获自定义的异常：".$e->getMessage();
            Yii::warning($e->getMessage(), '企业转账');
        }
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onSentRedEnvelope()
    {
        Yii::$app->end();
    }

    /**
     * {@inheritdoc}
     */
    public function onReceivedRedEnvelope()
    {
        Yii::$app->end();
    }
}
