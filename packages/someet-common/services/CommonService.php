<?php
namespace someet\common\services;

use Yii;

class CommonService extends BaseService
{
    public static function get_access_token()
    {
        // 获取微信的 access_token
        $weixin_token = \DockerEnv::get('WEIXIN_TOKEN');
        $appid = \DockerEnv::get('WEIXIN_APP_ID');
        $secret = \DockerEnv::get('WEIXIN_APP_SECRET');
        $url_get = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $json=self::curlGet($url_get);
        $weixin_token =  json_decode($json);
        return $weixin_token=$weixin_token->access_token;
    }

    public static  function curlPost($url){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);// 1s to timeout.

        $temp = curl_exec($ch);
        return $temp;
    }

    public static function curl_post($url, $data, $header = array()){
        if(function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            if(is_array($header) && !empty($header)){
                $set_head = array();
                foreach ($header as $k=>$v){
                    $set_head[] = "$k:$v";
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $set_head);
            }
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);// 1s to timeout.
            $response = curl_exec($ch);
            if(curl_errno($ch)){
                //error
                return curl_error($ch);
            }
            $reslut = curl_getinfo($ch);
            print_r($reslut);
            curl_close($ch);
            $info = array();
            if($response){
                $info = json_decode($response, true);
            }
            return $info;
        } else {
            throw new Exception('Do not support CURL function.');
        }
    }

    public static function curlGet($url){
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
}
