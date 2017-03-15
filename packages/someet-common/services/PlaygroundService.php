<?php
/**
 * Created by PhpStorm.
 * User: maxwelldu
 * Date: 25/5/2016
 * Time: 5:55 PM
 */

namespace someet\common\services;

use someet\common\models\User;
use someet\common\models\TestTube;
use someet\common\models\TubeType;
use someet\common\models\ShareWish;
use someet\common\models\TubeLimit;
use Yii;
use yii\web\Response;
class PlaygroundService extends BaseService
{
	public static function checkWish($wish_id)
	{
		$wishinfo = TestTube::find()->where(['id'=>$wish_id])->one();
		$wish_type = $wishinfo->type;
		$user_id = Yii::$app->user->id;
        $is_exists = TestTube::find()->where(['user_id'=>$user_id,'type'=>$wish_type])->one();
        if($is_exists && $is_exists->wish_content !=null && $is_exists->wish_jetton !=null && $is_exists->status !=null && $is_exists->mobile != null){
            return ['status'=>-1,'data'=>$is_exists];
        }elseif($is_exists->status !=null && $is_exists->mobile == null){
        	return ['status'=>-2,'data'=>$is_exists];
        }


        //每人限制两个试管
        $total_person = 2;
        $my_wish_count = TestTube::find()->where(['user_id'=>$user_id])->andWhere("status is not null and mobile is not null")->count();
        if($my_wish_count >= $total_person){
        	return ['status'=>0,'data'=>$is_exists];
        }
        
        $wish_count = TestTube::find()
                        ->where(['city'=>$wishinfo->city])
                        ->andWhere("mobile is not null or wechat is not null")
                        ->count();
        $all_count = TubeLimit::find()
                    ->select('limit')
                    ->where(['city_id'=>$wishinfo->city])
                    ->sum('`limit`');
        // if($wishinfo->city==2){
        //     $all_count = 4000;
        // }elseif($wishinfo->city==3){
        //     $all_count = 3000;
        // }else{
        //     $all_count = 3000;
        // }

        if($wish_count >= $all_count){
            return ['status'=>-20,'data'=>'已经爆满'];
        }
        return ['status'=>1,'data'=>$wishinfo];
	}

    public static function getMsg($wish_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $msg = self::checkWish($wish_id);
        if($msg['status']=='-1'){
            return $this->redirect(['/playground/poster-view?wish_id='.$msg['data']['id']]);
        }
        if($msg['status'] == '-2'){
            return $this->render('userinfo');
        }
        if($msg == '-10'){
            return ['status'=>0,'data'=>'用户数据不符'];
        }
        if($msg['status']==0){
            return ['status'=>0,'data'=>'只能填两个愿望'];
        }
        return false;
    }
}