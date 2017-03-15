<?php
namespace someet\common\services;

use dektrium\user\models\Account;
use someet\common\models\ActivityCheckIn;
use someet\common\models\Answer;
use someet\common\models\ActivityOrder;
use someet\common\models\Activity;
use someet\common\models\User;
use someet\common\models\Noti;
use someet\common\models\NotificationTemplate;

class VipService  extends BaseService
{
    public static function Create($level)
    {

        // http://192.168.99.100:8089/test/view-service
        // 创建订单数据，不能重复创建，每个报名id创建一个订单

        // 订单号处理 date('ymdHis').str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT)
        // 前缀 + 2位随机数+年月日时分秒 + 2位随机数字  为了和vip订单对应
        // vip类型 10:59元 20:99元 30:199元 60:999元
        $user = Yii::$app->user->id;
        $order_no =  'act'.'0'.$level.date('ymdHis').str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
        $user_id = Yii::$app->user->id;
        // 获取用户的openid
        $account = Account::find()
            ->where(['user_id' => $user_id ])
            ->one();
        $openid = $account->client_id;
        $detail = "用户id".$user_id."开通vip".$level;

        $vipInfo = VipInfo::find()
                    ->where(['level' => $level])
                    ->one();

        $model = new Vip();
        $model->order_no = $order_no;
        $model->openid = $openid;
        $model->mobile = $user->mobile;
        $model->user_id = $answer->user_id;
        $model->username = $user->username;
        $model->level = $level;
        $model->price = $vipInfo->price;
        $model->status = Vip::PAY_YET;
        $model->price = $activity->cost;
        // $model->pay_time = time();
        // $model->paid_time = time();
        $model->created_at = time();
        $model->detail = $detail;
        $model->detail = $detail;
        // $model->pay_status = $pay_status;
        // $model->pay_time = $pay_status;
        // $model->expire_time = $pay_status;
        // $model->refund_status = 0;
        // $model->currency = 100;
        // $model->refund_price = $detail;
        // $model->failure_msg = $detail;
        // $model->failure_code = $detail;
        // $model->pingpp_id = $detail;
        // $model->refund_status = $detail;
        $model->save();
    }
}
