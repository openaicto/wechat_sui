<?php
namespace app\controllers;

use someet\common\models\Activity;
use someet\common\models\PermanentMaterial;
use someet\common\services\CommonService;
use Yii;
use yii\web\Controller;

define("TOKEN", "someetweixin");
/**
 * 微信控制器
 *
 * @author  Maxwell Du <maxwelldu@someet.so>
 * @package app\controllers
 */
class WechatController extends Controller
{
    public $enableCsrfValidation = false;
    private $help = "使用帮助: 回复数字查看活动文章中对应序号的活动";

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
    }

    /**
     * 微信接口接入方法
     */
    public function actionValid()
    {
        if (isset($_GET['echostr'])) { // 验证
            $this->valid();
        } else { //响应消息和事件
            $this->responseMsg();
        }
    }

    /**
     * 微信接入验证
     */
    public function valid()
    {
        $echoStr = Yii::$app->request->get("echostr");
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }




    /**
     * 上传永久素材
     * @return [type] [description]
     */
    public function UploadPermanentMaterial($mediaPath, $type, $name)
    {
        // $uploadMedia['media_id'] = '221112322131231221';
        // $uploadMedia['url'] = 'sadaasdasass';
        $wechat = Yii::$app->wechat;
        $uploadMedia = $wechat->addMaterial($mediaPath, $type);
        var_dump($uploadMedia);
        $PermanentMaterial = new PermanentMaterial();
        $PermanentMaterial->media_id = $uploadMedia['media_id'];
        $PermanentMaterial->name = $name;
        $PermanentMaterial->url = $uploadMedia['url'];
        $PermanentMaterial->created_at = time();
        if ($PermanentMaterial->save()) {
            return ['status' => 1,'data' => '存储成功'];
        } else {
            return ['status' => 0,'data' => '存储失败'];
        }
    }

    /*
     * 请假
     */
    public function actionReplyLeave()
    {
        $mediaPath = "/var/www/html/web/image/common/autoReplyLeave.png";
        $type = 'image/png';
        $name = "leave";
        $res = $this->UploadPermanentMaterial($mediaPath, $type, $name);
        echo $res['data'];
    }

    /*
    支付
    */
    public function actionReplyPay()
    {
        $mediaPath = "/var/www/html/web/image/common/autoReplyPay.png";
//            $mediaPath = "http://7xn8h3.com1.z0.glb.clouddn.com/Fnc7xiLXfdmrBVzNQOhQy1_uSYW5";
            $type = 'image/png';
        $name = "pay";
        $res = $this->UploadPermanentMaterial($mediaPath, $type, $name);
        echo $res['data'];
    }

    /*
     * 编辑
     */
    public function actionReplyEdit()
    {
        $mediaPath = "/var/www/html/web/image/common/autoReplyEdit.png";
        $type = 'image/png';
        $name = "edit";
        $res = $this->UploadPermanentMaterial($mediaPath, $type, $name);
        echo $res['data'];
    }

    /*
     * 申诉
     */
    public function actionReplyAppeal()
    {
        $mediaPath = "/var/www/html/web/image/common/autoReplyAppeal.png";
        $type = 'image/png';
        $name = "appeal";
        $res = $this->UploadPermanentMaterial($mediaPath, $type, $name);
        echo $res['data'];
    }

    /*
     * 加入群组
     */
    public function actionJoinGroup()
    {
        $mediaPath = "/var/www/html/web/image/common/autoReplyJoinGroup.png";
        $type = 'image/png';
        $name = "joingroup";
        $res = $this->UploadPermanentMaterial($mediaPath, $type, $name);
        echo $res['data'];
    }



    /**
     * 上传动作
     * @return [type] [description]
     */
    public function actionUpMaterial()
    {
        $mediaPath = '/var/www/html/web/image/common/me.png';
        $type = 'image/png';
        $name = "请假";
        $res = $this->UploadPermanentMaterial($mediaPath, $type, $name);
        $wechat = Yii::$app->wechat;
        // $uploadMedia = $wechat->addMaterial($mediaPath, $type);
        echo "<pre>";
        var_dump($uploadMedia);
        die;
        $mediaPath1 = '/var/www/html/web/image/common/autoReplyLeave.png';
        $mediaPath2 = '/var/www/html/web/image/common/autoReplyPay.png';
        $mediaPath3 = '/var/www/html/web/image/common/autoReplyEdit.png';
        $mediaPath4 = '/var/www/html/web/image/common/autoReplyAppeal.png';
        $mediaPath5 = '/var/www/html/web/image/common/autoReplyJoinGroup.png';

        $data = [
            [
                'name' => "leave",
                'mediaPath' => $mediaPath1,
            ],
            [
                'name' => "pay",
                'mediaPath' => $mediaPath2,
            ],
            [
                'name' => "edit",
                'mediaPath' => $mediaPath3,
            ],
            [
                'name' => "appeal",
                'mediaPath' => $mediaPath4,
            ],
            [
                'name' => "joingroup",
                'mediaPath' => $mediaPath5,
            ],
        ];
        echo "<pre>";
        // print_r($data);
        $type = 'image/png';
        foreach ($data as $key => $value) {
            $res = $this->UploadPermanentMaterial($value['mediaPath'], $type, $value['name']);
            echo $res['data'];
            // print_r($value);
            // die;
        }
    }

    /**
     * 验证签名
     *
     * @return bool
     * @throws Exception 如果TOKEN没有定义, 则抛出异常
     */
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $request = Yii::$app->request;
        $signature = $request->get("signature");
        $timestamp = $request->get("timestamp");
        $nonce = $request->get("nonce");

        $token = TOKEN;
        $tmpArr = [$token, $timestamp, $nonce];
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature;
    }

    /**
     * 响应消息和事件
     */
    public function responseMsg()
    {
        $postData = $GLOBALS['HTTP_RAW_POST_DATA'];
        // $postData = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

        if (!empty($postData)) {
            libxml_disable_entity_loader(true);
            $obj = simplexml_load_string($postData, "SimpleXMLElement", LIBXML_NOCDATA);

            $MsgType = $obj->MsgType;

            switch ($MsgType) {
                case 'text':
                    echo $this->receiveText($obj);
                    break;
                case 'image':
                    echo $this->receiveImage($obj);
                    break;
                case 'voice':
                    echo $this->receiveVoice($obj);
                    break;
                case 'event':
                    $this->receiveEvent($obj); //当退订的时候不用输出, 所以这里将echo去掉, 在里面去处理
                    break;
                default:
                    break;
            }
        } else {
            echo "Error";
        }
    }

    /**
     * 接收文字消息
     *
     * @param  SimpleXMLElement $obj 接收的微信对象
     * @return string
     */
    public function receiveText($obj)
    {
        $Content = trim($obj->Content);

        //数字回复对应的活动信息
        if (is_numeric($Content)) {
            $json = Yii::$app->cache->get('wechatReply');
            //非空校验
            if (empty($json)) {
                return $this->replyText($obj, $this->help);
            }
            //格式校验
            if (!$this->isJson($json)) {
                return $this->replyText($obj, $this->help);
            }
            //转成数组
            $wechatJson = json_decode($json, true);
            $activityId = 0;
            foreach ($wechatJson as $item) {
                if ($item['order_id'] == $Content) {
                    $activityId = $item['activity_id'];
                    break;
                }
            }
            //没找到序号对应的活动校验
            if ($activityId==0) {
                return $this->replyText($obj, $this->help);
            }
            //只查询发布的对应序号的活动
            $model = Activity::find()->where(['id' => $activityId])->one();
            //未查询到处理
            if (!$model) {
                return $this->replyText($obj, $this->help);
            }
            //正常返回一个活动的图文
            $title = $model->title;
            $description = "点击查看详情";
            $pic = $model->poster;
            $url = Yii::$app->params['domain'] . 'activity/'.$model->id;

            $newsArr = array(
                array(
                    "Title" => $title,
                    "Description" => $description,
                    "PicUrl" => $pic,
                    "Url" => $url,
                ),
            );
            return $this->replyNews($obj, $newsArr);
        }

        // 关键字回复
        $replyTextList = [
           "你可以点击以下分类查看你想要的活动：

1.<a href='https://m.someet.cc/activity/channel-view?type_id=11'>撩妹装逼必备技能入门</a>

2.<a href='https://m.someet.cc/activity/channel-view?type_id=12'>那些触及心灵的对话</a>

3.<a href='https://m.someet.cc/activity/channel-view?type_id=16'>品质生活并不如你想象中那么贵</a>

4.<a href='https://m.someet.cc/activity/channel-view?type_id=13'>艺术细菌研究室</a>

5.<a href='https://m.someet.cc/activity/channel-view?type_id=15'>做一个热爱生活的「绿茶婊」</a>

6.<a href='https://m.someet.cc/activity/channel-view?type_id=20'>没见过的奇葩猎奇小众...</a>

7.<a href='https://m.someet.cc/activity/channel-view?type_id=17'>释放自我，遇见一个真实的自己</a>

8.<a href='https://m.someet.cc/activity/channel-view?type_id=18'>找到对的小伙伴，这些事儿会更有趣</a>

9.<a href='https://m.someet.cc/activity/channel-view?type_id=19'>一起变胖，是我能想到最浪漫的事</a>

10.<a href='https://m.someet.cc/activity/channel-view?type_id=14'>在这里充值你的想象力</a>",
        ];
        if (in_array($Content, ['目录', '频道', '推荐'])) {
            return $this->replyText($obj, $replyTextList[0]);
        }

        $replyImage = '城市游乐场入口： https://m.someet.cc/wish-hider/wish-map';
        if (in_array($Content, ['开门', '试管', '地图', '线索'])) {
            return $this->replyText($obj, $replyImage);
        }

        $replyService = ['Someet小海豹没有猜到你的问题，您可以选择添加值班小伙伴的微信（微信号：focus678），或拔打他的电话153-2791-1959将由他为您解答',
        "Someet推出以时间维度计算的会员资格（季度、半年、全年），而“会员制”收费的本质是出售一定时间内社区的会员资格，拥有会员资格才可以报名活动，我们会在会员有效期内每周为你提供品类丰富、质量优秀的活动（目前Someet仅在北京地区实行会员制）\n<a href='https://m.someet.cc/vip/index'>快来加入Someet吧</a>",
        '自由基介绍http://mp.weixin.qq.com/s/YOQ3GdJbLlqNytDKtF5GIQ',
        "小海豹猜您想了解\n1. Someet会员是什么？回复“会员”\n2. 自由基俱乐部是什么？回复“自由基”\n3. 报名活动后，去不了了怎么办？回复“请假”\n4. 如何支付活动费用？回复“支付”\n5. 如何进入活动群？回复“入群”\n6. 什么是黄／黑牌，收到黄／黑牌之后如何申诉撤销？回复“申诉”\n7. 怎么修改我的个人信息（昵称、微信号、手机号）？回复“编辑”\n8. 其他问题／人工客服，回复“客服”",];
        if (in_array($Content, ['客服'])) {
            return $this->replyText($obj, $replyService[0]);
        }

        if (in_array($Content, ['会员'])) {
            return $this->replyText($obj, $replyService[1]);
        }

        if (in_array($Content, ['自由基'])) {
            return $this->replyText($obj, $replyService[2]);
        }

        if (in_array($Content, ['请假'])) {
            $info = PermanentMaterial::find()
                    ->where(['name'=>'leave'])
                    ->one();
            $MediaId = $info->media_id;
            return $this->replyImage($obj, $MediaId);
        }
        if (in_array($Content, ['支付'])) {
            $info = PermanentMaterial::find()
                ->where(['name'=>'pay'])
                ->one();
            $MediaId = $info->media_id;
            return $this->replyImage($obj, $MediaId);
        }
        if (in_array($Content, ['申诉'])) {
            $info = PermanentMaterial::find()
                ->where(['name'=>'appeal'])
                ->one();
            $MediaId = $info->media_id;
            return $this->replyImage($obj, $MediaId);
        }
        if (in_array($Content, ['编辑'])) {
            $info = PermanentMaterial::find()
                ->where(['name'=>'edit'])
                ->one();
            $MediaId = $info->media_id;
            return $this->replyImage($obj, $MediaId);
        }
        if (in_array($Content, ['入群'])) {
            $info = PermanentMaterial::find()
                ->where(['name'=>'joingroup'])
                ->one();
            $MediaId = $info->media_id;
            return $this->replyImage($obj, $MediaId);
        }



        /*
        if ($Content == "你好") {
            return $this->replyText($obj, "大家好才是真的好");
        } elseif ($Content == "新闻") {
            $newsArr = array(
                array(
                    "Title" => "大新闻",
                    "Description" => "这是一条新闻",
                    "PicUrl" => "http://sdk.tools.sinaapp.com/static/image/sae_editor/logo.gif",
                    "Url" => "http://www.baidu.com",
                ),
                array(
                    "Title" => "大新闻2",
                    "Description" => "这是一条新闻2",
                    "PicUrl" => "http://sdk.tools.sinaapp.com/static/image/sae_editor/logo.gif",
                    "Url" => "http://www.baidu.com",
                ),
            );
            return $this->replyNews($obj, $newsArr);
        } elseif ($Content == "音乐") {
            $music = array(
                "Title" => "好久不见",
                "Description" => "好久不见",
                "MusicUrl" => "http://yinyueshiting.baidu.com/data2/music/134369899/2927661435208461128.mp3?xcode=263525952f55237f19a583210f1a2e09",
                "HQMusicUrl" => "http://yinyueshiting.baidu.com/data2/music/134369899/2927661435208461128.mp3?xcode=263525952f55237f19a583210f1a2e09",
            );
            return $this->replyMusic($obj, $music);
        }
        return $this->replyText($obj, $Content);
        */
        return $this->replyText($obj, $replyService[3]);
    }


    /**
     * 接受图片消息
     *
     * @param  SimpleXMLElement $obj 接收的微信对象
     * @return string
     */
    public function receiveImage($obj)
    {
        $MediaId = $obj->MediaId;
        return $this->replyImage($obj, $MediaId);
    }

    /**
     * 接受声音消息
     *
     * @param  SimpleXMLElement $obj 接收的微信对象
     * @return string
     */
    public function receiveVoice($obj)
    {
        $MediaId = $obj->MediaId;
        return $this->replyVoice($obj, $MediaId);
    }

    /**
     * 接受事件
     *
     * @param SimpleXMLElement $obj 接收的微信对象
     */
    public function receiveEvent($obj)
    {
        $Event = $obj->Event;
        switch ($Event) {
            case 'subscribe': //关注
                //保存到数据库里面
                // echo $this->replyText($obj, '嗨，我在这里等你好久了。Someet是一个城市青年基于兴趣自由发起、参与线下活动的社区；每周三晚，会给大家推送发生在身边的各种有趣好玩的线下活动；这里是Someet服务号，致力于为你提供更便捷的活动报名体验。你可以点击底栏菜单中的<a href="https://m.someet.cc/vip/index?openin=manual">购买会员</a>，进入Someet会员套餐购买页面；点击自定义菜单中“关于活动”，查看、报名当周众多活动；也可以点击“发起活动”，自己发起一场Someet活动；我们一起换个姿势，开启一种全新的生活方式。');  //文字欢迎

                echo $this->replyText($obj, '来了就对了。这里是Someet，青年自发兴趣社区，每周上百场年轻人自发活动，无论你想玩什么，这都有一群最棒的小伙伴。

最近Someet在玩个「试管计划」，我们想用3000+个试管，把北上广冰冷的街头变成一个巨大的「城市游乐场」。

这里是Someet服务号，欲了解「城市游乐场」后续，请关注Someet订阅号（ID：Someet2015）。

<a href="https://m.someet.cc/playground/sub-wish">你也可以直接去投放一支属于自己的试管</a>

<a href="http://mp.weixin.qq.com/s/KWdnPl3qqhQO0QHMtBnLQQ">点击这里查看详情</a>
');
                /*
                 $newsArr = array(
                array(
                "Title" => "欢迎您关注MaxwellDu",
                "Description" => "welcome",
                "PicUrl" => "http://sdk.tools.sinaapp.com/static/image/sae_editor/logo.gif",
                "Url" => "http://www.baidu.com",
                ),
                );
                echo $this->replyNews($obj, $newsArr); // 图文欢迎
                    */
                break;
            case 'unsubscribe': //取消关注
                // 做一些自己的事情, 例如: 将数据库用户的状态修改一下, 做一下用户统计, 哪些用户退订了
                break;
            case 'TEMPLATESENDJOBFINISH': //消息模板发送结束时的事件推送, 包括送达成功, 送达由于用户拒收, 送达由于其他原因失败
                //获取接受消息模板用户的openid
                $openid = $obj->FromUserName;
                //获取发送状态
                $status = $obj->Status;

                // 点击菜单拉取消息时的事件推送
            case 'CLICK':
                $EventKey = $obj->EventKey;

                switch ($EventKey) {
                    case 'V1001_TODAY_MUSIC':
                        echo $this->replyText($obj, "您点击了菜单");
                        break;
                    default:
                        // code...
                        break;
                }
                break;
            default:
                // code...
                break;
        }
    }

    /**
     * 回复文本
     *
     * @param  SimpleXMLElement $obj     接收的微信对象
     * @param  string           $Content 回复的文本内容
     * @return string
     */
    public function replyText($obj, $Content)
    {
        $replyXml = "<xml>
						<ToUserName><![CDATA[".$obj->FromUserName."]]></ToUserName>
						<FromUserName><![CDATA[".$obj->ToUserName."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[".$Content."]]></Content>
						</xml>";
        return $replyXml;
    }

    /**
     * 回复图片
     *
     * @param  SimpleXMLElement $obj     接收的微信对象
     * @param  string           $MediaId 媒体ID
     * @return string
     */
    public function replyImage($obj, $MediaId)
    {
        $replyXml = "<xml>
						<ToUserName><![CDATA[".$obj->FromUserName."]]></ToUserName>
						<FromUserName><![CDATA[".$obj->ToUserName."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[image]]></MsgType>
						<Image>
						<MediaId><![CDATA[".$MediaId."]]></MediaId>
						</Image>
						</xml>";
        return $replyXml;
    }

    /**
     * 回复声音
     *
     * @param  SimpleXMLElement $obj     接收的微信对象
     * @param  string           $MediaId 媒体ID
     * @return string
     */
    public function replyVoice($obj, $MediaId)
    {
        $replyXml = "<xml>
						<ToUserName><![CDATA[".$obj->FromUserName."]]></ToUserName>
						<FromUserName><![CDATA[".$obj->ToUserName."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[voice]]></MsgType>
						<Voice>
						<MediaId><![CDATA[".$MediaId."]]></MediaId>
						</Voice>
						</xml>";
        return $replyXml;
    }

    /**
     * 回复音乐
     *
     * @param  SimpleXMLElement $obj   接收的微信对象
     * @param  array            $music 音乐对象
     * @return string
     */
    public function replyMusic($obj, $music)
    {
        $replyXml = "<xml>
						<ToUserName><![CDATA[".$obj->FromUserName."]]></ToUserName>
						<FromUserName><![CDATA[".$obj->ToUserName."]]></FromUserName>
						<CreateTime>".time()."</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[".$music['Title']."]]></Title>
						<Description><![CDATA[".$music['Description']."]]></Description>
						<MusicUrl><![CDATA[".$music['MusicUrl']."]]></MusicUrl>
						<HQMusicUrl><![CDATA[".$music['HQMusicUrl']."]]></HQMusicUrl>
						</Music>
						</xml>";
        return $replyXml;
    }

    /**
     * 回复多条图文
     *
     * @param  SimpleXMLElement $obj     接收的微信对象
     * @param  array            $newsArr 新闻数组
     * @return string
     */
    public function replyNews($obj, $newsArr)
    {
        $itemStr = "";
        if (is_array($newsArr)) {
            foreach ($newsArr as $item) {
                $itemXml = "<item>
								<Title><![CDATA[%s]]></Title>
								<Description><![CDATA[%s]]></Description>
								<PicUrl><![CDATA[%s]]></PicUrl>
								<Url><![CDATA[%s]]></Url>
								</item>";
                $itemStr .= sprintf($itemXml, $item['Title'], $item["Description"], $item["PicUrl"], $item["Url"]);
            }

            $replyXml = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>%s</ArticleCount>
							<Articles>
							{$itemStr}
							</Articles>
							</xml> ";
            return sprintf($replyXml, $obj->FromUserName, $obj->ToUserName, time(), count($newsArr));
        }
    }
}
