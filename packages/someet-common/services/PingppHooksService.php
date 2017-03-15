<?php

namespace someet\common\services;

use someet\common\models\PingppCallback;
use someet\common\models\PinghookErr;
use app\components\DataValidationFailedException;

class PingppHooksService extends BaseService
{
    /**
     * pingCallback 错误处理.
     *
     * @param 数组 $data 记录的错误信息；
     */
    public static function CreatePinghookErr($data)
    {
        if (empty($data)) {
            return '数据不能为空！';
        }

        $pinghookErr = new PinghookErr();

        if (!empty($data['pingpp_id'])) {
            $pinghookErr->pingpp_id = $data['pingpp_id'];
        }

        if (!empty($data['user_id'])) {
            $pinghookErr->user_id = $data['user_id'];
        }

        if (!empty($data['note'])) {
            $pinghookErr->note = $data['note'];
        }

        if (isset($data['type'])) {
            $pinghookErr->type = $data['type'];
        }

        if (!empty($data['callback'])) {
            $pinghookErr->callback = json_encode($data['callback']);
        }

        if (!empty($data['object'])) {
            $pinghookErr->object = $data['object'];
        }

        if (!empty($data['order_no'])) {
            $pinghookErr->order_no = $data['order_no'];
        }
        if (!empty($data['failure_msg'])) {
            $pinghookErr->failure_msg = $data['failure_msg'];
        }
        if (!empty($data['failure_code'])) {
            $pinghookErr->failure_code = $data['failure_code'];
        }

        if (!empty($data['hook_created'])) {
            $pinghookErr->hook_created = $data['hook_created'];
        }
        if (!empty($data['amount'])) {
            $pinghookErr->amount = $data['amount'];
        }

        $pinghookErr->save();
    }

    /**
     * 创建pingCallback 数据.
     *
     * @param [type] $charge [description]
     */
    public static function CreatePingppCallback($charge)
    {
        $model = new PingppCallback();

        if (!empty($charge->id)) {
            $model->pingpp_id = $charge->id;
            if (!$model->validate('pingpp_id')) {
                throw new DataValidationFailedException($model->getFirstError('pingpp_id'));
            }
        }

        if (!empty($charge->object)) {
            $model->object = $charge->object;
            if (!$model->validate('object')) {
                throw new DataValidationFailedException($model->getFirstError('object'));
            }
        }

        if (!empty($charge->created)) {
            $model->created = $charge->created;
            if (!$model->validate('created')) {
                throw new DataValidationFailedException($model->getFirstError('created'));
            }
        }
        if (!empty($charge->paid)) {
            $model->paid = $charge->paid;
            if (!$model->validate('paid')) {
                throw new DataValidationFailedException($model->getFirstError('paid'));
            }
        }

        if (!empty($charge->livemode)) {
            $model->livemode = strval($charge->livemode);
            if (!$model->validate('livemode')) {
                throw new DataValidationFailedException($model->getFirstError('livemode'));
            }
        }

        if (!empty($charge->client_ip)) {
            $model->client_ip = $charge->client_ip;
            if (!$model->validate('client_ip')) {
                throw new DataValidationFailedException($model->getFirstError('client_ip'));
            }
        }

        if (!empty($charge->refunded)) {
            $model->refunded = $charge->refunded;
            if (!$model->validate('refunded')) {
                throw new DataValidationFailedException($model->getFirstError('refunded'));
            }
        }
        if (!empty($charge->app)) {
            $model->app = $charge->app;
            if (!$model->validate('app')) {
                throw new DataValidationFailedException($model->getFirstError('app'));
            }
        }
        if (!empty($charge->channel)) {
            $model->channel = $charge->channel;
            if (!$model->validate('channel')) {
                throw new DataValidationFailedException($model->getFirstError('channel'));
            }
        }
        if (!empty($charge->order_no)) {
            $model->order_no = $charge->order_no;
            if (!$model->validate('order_no')) {
                throw new DataValidationFailedException($model->getFirstError('order_no'));
            }
        }

        if (!empty($charge->amount)) {
            $model->amount = $charge->amount;
            if (!$model->validate('amount')) {
                throw new DataValidationFailedException($model->getFirstError('amount'));
            }
        }
        if (!empty($charge->amount_settle)) {
            $model->amount_settle = $charge->amount_settle;
            if (!$model->validate('amount_settle')) {
                throw new DataValidationFailedException($model->getFirstError('amount_settle'));
            }
        }
        if (!empty($charge->currency)) {
            $model->currency = $charge->currency;
            if (!$model->validate('currency')) {
                throw new DataValidationFailedException($model->getFirstError('currency'));
            }
        }
        if (!empty($charge->subject)) {
            $model->subject = $charge->subject;
            if (!$model->validate('subject')) {
                throw new DataValidationFailedException($model->getFirstError('subject'));
            }
        }
        if (!empty($charge->body)) {
            $model->body = $charge->body;
            if (!$model->validate('body')) {
                throw new DataValidationFailedException($model->getFirstError('body'));
            }
        }
        if (!empty($charge->time_paid)) {
            $model->time_paid = $charge->time_paid;
            if (!$model->validate('time_paid')) {
                throw new DataValidationFailedException($model->getFirstError('time_paid'));
            }
        }
        if (!empty($charge->time_expire)) {
            $model->time_expire = $charge->time_expire;
            if (!$model->validate('time_expire')) {
                throw new DataValidationFailedException($model->getFirstError('time_expire'));
            }
        }
        if (!empty($charge->time_settle)) {
            $model->time_settle = $charge->time_settle;
            if (!$model->validate('time_settle')) {
                throw new DataValidationFailedException($model->getFirstError('time_settle'));
            }
        }
        if (!empty($charge->transaction_no)) {
            $model->transaction_no = $charge->transaction_no;
            if (!$model->validate('transaction_no')) {
                throw new DataValidationFailedException($model->getFirstError('transaction_no'));
            }
        }
        if (!empty($charge->amount_refunded)) {
            $model->amount_refunded = $charge->amount_refunded;
            if (!$model->validate('amount_refunded')) {
                throw new DataValidationFailedException($model->getFirstError('amount_refunded'));
            }
        }
        if (!empty($charge->failure_code)) {
            $model->failure_code = $charge->failure_code;
            if (!$model->validate('failure_code')) {
                throw new DataValidationFailedException($model->getFirstError('failure_code'));
            }
        }
        if (!empty($charge->failure_msg)) {
            $model->failure_msg = $charge->failure_msg;
            if (!$model->validate('failure_msg')) {
                throw new DataValidationFailedException($model->getFirstError('failure_msg'));
            }
        }
        if (!empty($charge->description)) {
            $model->description = $charge->description;
            if (!$model->validate('description')) {
                throw new DataValidationFailedException($model->getFirstError('description'));
            }
        }
        $model->save();
    }
}
