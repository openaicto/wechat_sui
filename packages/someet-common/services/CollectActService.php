<?php
namespace someet\common\services;

use someet\common\models\Answer;
use someet\common\models\Activity;
use someet\common\models\CollectAct;
use Yii;

class CollectActService extends BaseService
{
    /**
     * 添加收藏
     * @param [type] $data [description]
     */
    public static function addCollect($data)
    {
        $type = $data['type'];
        unset($data['type']);
        //如果是取消收藏
        if ($type=='uncollect') {
            $msg = self::unCollect($data);
            return $msg;
        } else {
            $collect = new CollectAct();
            foreach ($data as $key=>$row) {
                $collect->$key = $row;
            }
            $collect->created_at = time();
            $collect->status = CollectAct::COLLECT;
            $is_exists = CollectAct::find()->where(['user_id'=>$data['user_id'], 'activity_id'=>$data['activity_id']])->one();
            if (!$is_exists) {
                if ($collect->save()) {
                    return ['status' => 1,'data'=>'收藏成功'];
                } else {
                    return ['status' => 1,'data'=>'收藏失败'];
                }
            } else {
                if ($is_exists->status == 0) {
                    $is_exists->status = 1;
                    $is_exists->updated_at = time();
                    if ($is_exists->save()) {
                        return ['status' => 1,'data'=>'收藏成功'];
                    } else {
                        return ['status' => 1,'data'=>'收藏失败'];
                    }
                } else {
                    $msg = self::unCollect($data);
                    return $msg;
                }
            }
        }
    }

    public static function unCollect($data)
    {
        $is_exists = CollectAct::find()->where(['user_id'=>$data['user_id'], 'activity_id'=>$data['activity_id']])->one();
        if (!$is_exists) {
            $collect = new CollectAct();
            foreach ($data as $key=>$row) {
                $collect->$key = $row;
            }
            $collect->created_at = time();
            $collect->updated_at = time();
            $collect->status = CollectAct::UNCOLLECT;
            if ($collect->save()) {
                return ['status' => 2,'data'=>'取消收藏成功'];
            } else {
                return ['status' => 0,'data'=>'取消收藏失败'];
            }
        } else {
            $is_exists->updated_at = time();
            $is_exists->status = CollectAct::UNCOLLECT;
            if ($is_exists->save()) {
                return ['status' => 2,'data'=>'取消收藏成功'];
            } else {
                return ['status' => 0,'data'=>'取消收藏失败'];
            }
        }
    }
}
