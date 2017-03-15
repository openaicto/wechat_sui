<?php

namespace someet\common\services;

use someet\common\models\MobilePush;
use someet\common\models\User;

class MobilePushService extends BaseService
{
    public static function createMobilePush($data)
    {
        $user = User::findOne($data['user_id']);
        $mobileMsg = new MobilePush();
        $mobileMsg->content = $data['content'];
        $mobileMsg->user_id = $data['user_id'];
        $mobileMsg->type = $data['type'];
        $mobileMsg->note = $data['note'];
        $mobileMsg->username = $user->username;
        $mobileMsg->mobile = $user->mobile;
        $mobileMsg->answer_id = $data['answer_id'];
        $mobileMsg->created_at = time();
        $mobileMsg->save();
    }
}
