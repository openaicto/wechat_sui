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

class ActivityOrderService extends BaseService
{

    /**
    *创建活动订单
    *@param $answer_id 报名id $chargeFormData 创建ping++ 后返回的数据
    *@return 返回 status 成功：1； 失败：2；
    */
    public function CreateActOrder($answer_id, $chargeFormData)
    {
        $answer = Answer::findOne($answer_id);
        $activity = Activity::findOne($answer->activity_id);

        $account = Account::find()
            ->where(['user_id' => $answer->user_id ])
            ->one();

        $openid = $account->client_id;

        $user = User::findOne($answer->user_id);

        $detail = $user->username."支付活动费用";

  
        $model = new ActivityOrder();
        $model->order_no = $chargeFormData['order_no'];
        $model->openid = $openid;
        $model->mobile = $user->mobile;
        $model->user_id = $answer->user_id;
        $model->username = $user->username;
        $model->activity_id = $answer->activity_id;
        $model->activity_title = $activity->title;
        $model->activity_image = $activity->poster;
        $model->answer_id = $answer->id;
        $model->price = $activity->cost;
        $model->subject = $chargeFormData['subject'];
        $model->body = $chargeFormData['body'];
        $model->pingpp_id = $chargeFormData['id'];
        $model->expire_time = $chargeFormData['expire_time'];
        $model->discount = 100;
        $model->status = 10;
        $model->created_at = time();
        $model->detail = $detail;
        $model->save();
        if ($model->save()) {
            return ['status' => 1,'data' => $model];
        } else {
            return ['status' => 0,'data' => $model->order_no.'创建失败！'];
        }
    }
}
