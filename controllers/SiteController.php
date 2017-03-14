<?php

namespace app\controllers;

use someet\common\components\WindValidator;
use Yii;
use yii\web\Controller;
use app\models\forms\PasswordResetRequestForm;
use app\models\forms\ResetPasswordForm;
use someet\common\models\User;
use dektrium\user\models\Account;
use e96\sentry\SentryHelper;

/**
 * 站点控制器
 *
 * @author  Maxwell Du <maxwelldu@someet.so>
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => '\app\components\AccessControl',
                'allowActions' => [
                    'login',
                    'logout',
                    'create-menu',
                    'test',
                    'get-menu'
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 创建菜单
     *
     * @param $menu string 菜单
     * [
    [
    'name' => '一起玩耍',
    'sub_button' => [
    [
    'type' => 'view',
    'name' => '我要做PMA',
    'url' => 'https://mp.weixin.qq.com/s?__biz=MzAwNzM1NjgyMA==&mid=208506281&idx=1&sn=cc74d113fcd7c250acae1d0f8f0915ed&scene=18&uin=Mzg1NTMxODE1&key=ac89cba618d2d9762eb7272357fd4155218259913debf64c8201dc72381119433a215e34c46ba31e476300e2c76defd2&devicetype=iMac+Macmini7%2C1+OSX+OSX+10.11.1+build(15B42)&version=11020201&lang=en&pass_ticket=EAEN%2FN3XxmmGvbGFUi36cIti3DmFXEf3oDoFc83ZP1%2BmbX0xZc%2B%2F%2Fe5Hzb2ZPFqW'
    ],
    [
    'type' => 'view',
    'name' => '我要发活动',
    'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNzM1NjgyMA==&mid=401715971&idx=2&sn=ee4f412e5039112f182c3514ec9e879e&scene=21#wechat_redirect'
    ],
    [
    'type' => 'view',
    'name' => '关于Someet',
    'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNzM1NjgyMA==&mid=208439805&idx=1&sn=da8d7a23dc4913461212c7b58d1f0d5d&scene=18#wechat_redirect'
    ],
    [
    'type' => 'view',
    'name' => '5句话了解Someet',
    'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNzM1NjgyMA==&mid=400296516&idx=1&sn=fb60ad75571cf5e41ff22f9e1129939b&scene=18#wechat_redirect'
    ],
    [
    'type' => 'view',
    'name' => '吐槽直通车',
    'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNzM1NjgyMA==&mid=400514277&idx=1&sn=e6910f1f137b98b0c96c8dc19dac6246&scene=18#rd'
    ],
    ]
    ],
    [
    'type' => 'view',
    'name' => '本周活动',
    'url' => 'https://m.someet.cc'
    ],
    [
    'type' => 'view',
    'name' => '精彩回顾',
    'url' => 'https://m.someet.cc/review/index'
    ],
    ]
     */
    public function actionCreateMenu()
    {
        $wechat = Yii::$app->wechat;
        $m = [
            [
                'name' => '一起玩耍',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '我要发活动',
                        'url' => Yii::$app->params['domain'] . '/member/founder-apply'
                    ],
                    [
                        'type' => 'view',
                        'name' => '我要做PMA',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNzM1NjgyMA==&mid=507950857&idx=1&sn=7fe2ef06079f6e359a2cc227a3c05927&scene=0#wechat_redirect'
                    ],
                    [
                        'type' => 'view',
                        'name' => '使用手册',
                        'url' => 'https://mp.weixin.qq.com/s?__biz=MzAxNDY4MzM1OA==&mid=401328148&idx=2&sn=49f70bd1b299a0e91951c417cd52e933&scene=4#wechat_redirect'
                    ],
                    [
                        'type' => 'view',
                        'name' => '吐槽直通车',
                        'url' => 'https://mp.weixin.qq.com/s?__biz=MzAxNDY4MzM1OA==&mid=401274866&idx=1&sn=df6c9c2128c2bb93f94d26d265591679&scene=0&previewkey=JZg7qLbadIF1XNph2rZYTMwqSljwj2bfCUaCyDofEow%3D&uin=Mzg1NTMxODE1&key=41ecb04b051110038921a7331ef7e755a7adfd5553d97b9d0afe567e5ce48d5f69c3b556579a36ce7139010af1026b63&devicetype=iMac+Macmini7%2C1+OSX+OSX+10.11.1+build(15B42)&version=11020201&lang=en&pass_ticket=ejT6tYrWWeZe5mLtDrZjkuVFClEaHcMT8CaULi5ZOv5ZWEcDj8cf8xphrO9vGdNZ'
                    ],
                    [
                        'type' => 'view',
                        'name' => '关于Someet',
                        'url' => 'https://mp.weixin.qq.com/s?__biz=MzAxNDY4MzM1OA==&mid=401274881&idx=1&sn=1b1d5b40e0377a591b404f4fb54657cc&scene=0&previewkey=JZg7qLbadIF1XNph2rZYTMwqSljwj2bfCUaCyDofEow%3D&uin=Mzg1NTMxODE1&key=41ecb04b0511100327ba730407e296ce27fc9e495f97e4f35022cae789bfb26555ffca1bbee110c7f54e587e897f066a&devicetype=iMac+Macmini7%2C1+OSX+OSX+10.11.1+build(15B42)&version=11020201&lang=en&pass_ticket=ejT6tYrWWeZe5mLtDrZjkuVFClEaHcMT8CaULi5ZOv5ZWEcDj8cf8xphrO9vGdNZ'
                    ],
                ]
            ],
            [
                'name' => '本周活动',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '北京活动',
                        'url' => Yii::$app->params['domain'] . 'activities?city_id=2'
                    ],
                    [
                        'type' => 'view',
                        'name' => '上海活动',
                        'url' => Yii::$app->params['domain'] . 'activities?city_id=3'
                    ],
                    [
                        'type' => 'view',
                        'name' => '广州活动',
                        'url' => Yii::$app->params['domain'] . 'activities?city_id=4'
                    ],
                    [
                        'type' => 'view',
                        'name' => '我',
                        'url' => 'https://m.someet.cc/member/index'
                    ],
                ]
            ],
            [
                'type' => 'view',
                'name' => '购买会员',
                'url' => 'https://m.someet.cc/vip/index'
            ],

        ];
        $r = $wechat->createMenu($m);
        return !$r ? '创建菜单失败，原因是'.$r : '创建菜单成功';
    }

    /**
     * 获取菜单
     */
    public function actionGetMenu()
    {
        $wechat = Yii::$app->wechat;
        $r = $wechat->getMenu();
        var_dump($r);
    }

    /**
     * 跳转到首页
     */
    public function actionIndex()
    {
        return $this->redirect(Yii::$app->params['domain'].'activities');
    }

    /**
     * 微信登录接口
     */
    public function actionLogin()
    {
        //微信客户端的名称
        $client = 'wechat';

        //跳转过来的链接
        $returnUrl = Yii::$app->user->returnUrl;

        //微信跳转链接
        $redirect_uri = Yii::$app->params['domain']."site/login";
        //用户登录保存session的时间
        $duration = 3600 * 24 * 30;

        //判断如果已经登录, 判断如果是首页则跳到活动列表页,如果是其他页面则跳转到来源页面
        if (!Yii::$app->user->isGuest) {
            $returnUrl = '/site/login' == $returnUrl ? Yii::$app->params['domain'].'activities' : $returnUrl;
            return $this->redirect($returnUrl);
        }

        //微信组件
        $wechat = Yii::$app->wechat;
        //Session组件
        $session = Yii::$app->session;

        //获取openid
        $snsapi_userinfo_url = $wechat->getOauth2AuthorizeUrl($redirect_uri, 'authorize', 'snsapi_userinfo');

        if (Yii::$app->request->get('code', null) === null) {
            return $this->redirect($snsapi_userinfo_url);
        }

        $code = Yii::$app->request->get('code');
        //获取access token
        $access_token_arr = $wechat->getOauth2AccessToken($code);

        $oauth2AccessToken = $access_token_arr['access_token'];
        $openid = $access_token_arr['openid'];


        //判断是否已经绑定过微信
        /* @var $account Account */
        $account = Account::find()->where(
            [
            'provider' => $client,
            'client_id' => $openid,
            ]
        )->with(['user'])->one();

        //如果已经存在了则登录
        if ($account) {

            //进行登录, 保持登录状态30天
            $user = $account->user;
            Yii::$app->user->login($user, $duration);
            return $this->redirect($returnUrl);
        } else {

            //获取用户的userinfo, //如果没有关注的话,用户名使用 getSnsUserInfo
            $notScribeAttributes = $wechat->getSnsUserInfo($openid, $oauth2AccessToken);
            //已关注获取的属性
            $attributes = $wechat->getUserInfo($openid);

            //判断如果不存在unionid
            if (!isset($attributes['unionid'])) {
                //记录错误, 设置错误提示, 显示页面
                Yii::error('保存用户失败');
                $session->setFlash('danger', '登录失败, 请重新尝试');
                return $this->render('error', ['name' => 'test', 'message' => '登陆失败，请重新尝试, 原因是该公众号没有绑定开放平台']);
            }

            //生成6位字符随机密码
            $password = Yii::$app->security->generateRandomString(6);
            $unionid = $attributes['unionid'];
            $subscribe = $attributes['subscribe'];
            $subscribe_time = $attributes['subscribe_time'];
            //1 表示已关注, < 1表示未关注
            if ($subscribe < 1) {
                $attributes = $notScribeAttributes;
            }
            $username = $attributes['nickname'];

            //注册用户, 暂时不绑定用户, 直接使用微信昵称作为用户名
            $user = new User(
                [
                    'unionid' => $unionid,
                    'username' => $username,
                    'subscribe' => $subscribe,
                    'subscribe_time' => $subscribe_time,
                    'password' => $password,
                ]
            );
            $user->scenario = 'register';
            //$user->generateAuthKey();
            //$user->generatePasswordResetToken(false);

            //开启事务
            $transaction = $user->getDb()->beginTransaction();

            //尝试保存用户
            if (!$user->save()) {

                //回滚事务
                $transaction->rollBack();
                Yii::error('保存用户失败');
                $session->setFlash('danger', '登录失败, 请重新尝试');
                return $this->render('error');
            }

            //设置profile
            $profile = $user->profile;
            $profile->attributes = [
                'name' => $username,
                'sex' => $attributes['sex'],
                'city' => $attributes['city'],
                'province' => $attributes['province'],
                'country' => $attributes['country'],
                'headimgurl' => $attributes['headimgurl'],
            ];

            //尝试保存Profile
            if (!$profile->save()) {

                //回滚事务
                $transaction->rollBack();
                Yii::error('保存用户资料失败');
                $session->setFlash('danger', '登录失败, 请重新尝试');
                return $this->render('error');
            }

            //设置微信对象
            $account = new Account(
                [
                'user_id' => $user->id,
                'provider' => 'wechat',
                'unionid' => $unionid,
                'client_id' => $openid,
                'data' => json_encode($attributes),
                'username' => $username,
                'created_at' => time(),
                ]
            );

            //尝试保存微信对象
            if (!$account->save()) {

                //回滚事务
                $transaction->rollBack();
                Yii::error('保存微信对象失败');
                $session->setFlash('danger', '登录失败, 请重新尝试');
                return $this->render('error');
            }

            $auth = Yii::$app->authManager;
            $role = $auth->getRole('user');

            //判断当前没有被赋user权限的时候则赋权
            if (!$auth->getAssignment('user', $user->id)) {

                //赋普通会员权限
                if (!$auth->assign($role, $user->id)) {
                    Yii::error('设置用户权限为user失败');
                    $session->setFlash('danger', '登录失败, 请重新尝试');
                    return $this->render('error');
                }
            }

            //提交事务
            $transaction->commit();

            //登录并跳回活动首页
            Yii::$app->user->login($user, $duration);
            return $this->redirect($returnUrl);
        }
    }

    /**
     * 用户退出
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return ['logout success'];
    }

    /**
     * 用户注册
     */
    public function actionSignup()
    {
        $user = new User(['scenario' => 'signup']);
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('user-signed-up');
            return $this->refresh();
        }

        if (Yii::$app->session->hasFlash('user-signed-up')) {
            return $this->render('signedUp');
        }

        return $this->render(
            'signup',
            [
                'model' => $user,
            ]
        );
    }

    /**
     * 确认邮件
     */
    public function actionConfirmEmail($token)
    {
        $user = User::find()->emailConfirmationToken($token)->one();

        if ($user!==null && $user->confirmEmail()) {
            Yii::$app->getUser()->login($user);
            return $this->goHome();
        }

        return $this->render('emailConfirmationFailed');
    }

    /**
     * 请求重置密码
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render(
            'requestPasswordResetToken',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * 重置密码
     *
     * @param  string $token TOKEN
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render(
            'resetPassword',
            [
                'model' => $model,
            ]
        );
    }

    public function actionTest($city_id)
    {
        echo getUserCityId();
    }
}
