<?php
namespace someet\common\components;

use yii\base\Component;
use someet\common\models\YellowCard;
use someet\common\models\Answer;
use someet\common\models\User;
use dektrium\user\models\Account;
use someet\common\models\ActivityOrder;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use Yii;

class CommonFunction extends Component
{
    /**
     * 获取openid
     * @param $user_id 用户id
     * @return 用户用户的open id
     */
    public static function getOpenid($user_id)
    {
        $account = Account::find()
                ->where(['user_id' => $user_id])
                ->one();
        return $account->client_id;
    }
}
