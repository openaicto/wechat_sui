<?php
/**
 * Created by PhpStorm.
 * User: codeboy
 * Date: 17/2/21
 * Time: 下午3:02
 */
namespace someet\common\services;

use someet\common\models\GroupUser;
use someet\common\models\GroupUp;
use someet\common\models\Profile;
use someet\common\models\User;
use Yii;

class GroupUpService  extends BaseService
{
    public static function addGrouper($user_id,$data){
        $wxinfo = Profile::find()->where(['user_id' => $user_id])->one();
        $userinfo = User::find()->where(['id'=>$user_id])->one();
        $grouper = new GroupUser();
        $grouper->user_id = $user_id;
        $grouper->head_image = $wxinfo->headimgurl;
        if(isset($data['wechat_id'])){
            $grouper->wechat_id = $data['wechat_id'];
        }else{
            $grouper->wechat_id = $userinfo->wechat_id;
        }
        if(isset($data['mobile'])){
            $grouper->mobile = $data['mobile'];
        }else{
            $grouper->mobile = $userinfo->mobile;
        }

        $grouper->name = $userinfo->username;
        $grouper->count_success = 0;
        $grouper->count_fail = 0;
        $grouper->introduce = '暂无';
        $grouper->content = '暂无';
        $grouper->created_at =time();
        $grouper->updated_at = time();
        $grouper->status = 1;

        if($grouper->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public static function addGroupUpData($data){
        //获取表所有字段
        $db=Yii::$app->getDb();
        $r=$db->getSchema()->getTableSchema('group_up');//获取表字段名
        $field = [];
        foreach($r->columns as $key=>$val){
            $field[] = $key;
        }
        $group = new GroupUp();
        foreach($data as $key=>$row){
            if(in_array($key,$field) && $row){
                if($key == 'start_time' || $key == 'end_time'){
                    if(!is_int($row)){
                        $group->$key = strtotime($row);
                    }
                }else{
                    $group->$key = $row;
                }
            }
        }
        if($group->save()){
            return $group->id;
        }
        return 0;
//        return $group->getErrors();
    }


    /**
     * 把图片存在服务器上面
     * @return [type] [description]
     */
    public static function UploadImgData($data)
    {

        $redis = Yii::$app->redis;
        $token = self::GetUploadToken();
        $upToken = $token['token'];

        if($redis->get('weixin_token')){
            $weixin_token = $redis->get('weixin_token');
        }else{
            $weixin_token = \DockerEnv::get('WEIXIN_TOKEN');
            $appid = \DockerEnv::get('WEIXIN_APP_ID');
            $secret = \DockerEnv::get('WEIXIN_APP_SECRET');
            $url_get = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
            $json=self::curlGet($url_get);
            $weixin_token =  json_decode($json);
            $weixin_token=$weixin_token->access_token;
            $redis -> set('weixin_token',$weixin_token);
            $redis ->expire('weixin_token',7000);
            $weixin_token = $redis->get('weixin_token');
        }


        $img = $data['img'];
        $str = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$weixin_token."&media_id=".$img;


        $access_key = \DockerEnv::get('QINIU_ACCESS_KEY');
        $secret_key = \DockerEnv::get('QINIU_SECRET_KEY');
        //$this->request_by_curl($remote_server,$post_string,$upToken);
        $strr = file_get_contents($str);
        $fetch =base64_encode($strr);
        $imggg = self::request_by_curl('http://upload.qiniu.com/putb64/-1',$fetch,$upToken);
        $imgs = json_decode(trim($imggg),true);
        $imgss = $imgs['hash'];
        $imgUrl = 'https://obf949end.qnssl.com/'.$imgss.'?imageslim';
        return $imgUrl;

    }

    /**
     * 获取七牛的token
     * @return array
     */
    public static function GetUploadToken()
    {
        $bucket = Yii::$app->params['qiniu.bucket'];
        $expires = Yii::$app->params['qiniu.upload_token_expires'];
        $qiniu = Yii::$app->qiniu;
        $token = $qiniu->getUploadToken($bucket, null, $expires);
        // print_r($token);
        return [
            'token' => $token,
            'bucket' => $bucket,
            'expires' => $expires,
        ];


    }

    /**
     * 抓取图片信息
     * @param $url
     * @return mixed
     */
    public function curlGet($url){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        return $temp;
    }

    public function request_by_curl($remote_server,$post_string,$upToken) {

        $headers = array();
        $headers[] = 'Content-Type:image/png';
        $headers[] = 'Authorization:UpToken '.$upToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$remote_server);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER ,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}