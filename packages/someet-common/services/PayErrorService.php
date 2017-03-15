<?php
namespace someet\common\services;

use someet\common\models\PingppCallback;
use someet\common\models\PayError;
use yii\web\ServerErrorHttpException;
use app\components\DataValidationFailedException;

class PayErrorService  extends BaseService
{   

    /**
     * 创建pingCallback 数据
     * @param [type] $charge [description]
     */
    public static function CreatePayError($data)
    {
        $model = new PayError();
        if (isset($data['user_id'])) {
            $model->user_id = $data['user_id'];

        }

        if (isset($data['from_id'])) {
            $model->from_id = $data['from_id'];
        }

        if (isset($data['err_msg'])) {
            $model->err_msg = $data['err_msg'];
        }

        if (isset($data['err_extra'])) {
            $model->err_extra = $data['err_extra'];
        }

        if (isset($data['pay_result'])) {
            $model->pay_result = $data['pay_result'];
        }        

        if (isset($data['client_charge'])) {
            $model->client_charge = json_encode($data['client_charge']);
        }

        $model->created_at = time();

        $model->status = 10; //未处理

        $model->save();
    }
}
