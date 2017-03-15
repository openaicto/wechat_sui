<?php
namespace someet\common\services;

use someet\common\models\User;
use someet\common\models\AccessRecords;
use Yii;

class AccessRecordsService extends BaseService
{
    /**
     * 检查该用户是否首次访问，飞首次访问的情况下，如果$isrecord=true的情况下，写入记录表
     * @param  [object] $user        用户信息
     * @param  string $action_name [访问地址的控制器名称，例如activity]
     * @return [bool]              [判断是否需要写入数据库]
     */
    public static function checkFirst($user, $action_name='activity', $isrecord=false)
    {
        //查询访问记录表里是否存在该用户访问该路径的记录
        $record=AccessRecords::find()
              ->where(['user_id'=>$user->id, 'action_name'=>$action_name])
              ->exists();
        //如果存在该路径的访问记录，则返回true，否则返回false；
        if ($record) {
            return true;
        } else {
            //返回false，则把该用户访问记录写入数据库
            $addrecords=new AccessRecords();
            $addrecords->user_id=$user->id;
            $addrecords->action_name=$action_name;
            $addrecords->created_at=time();
            $addrecords->status=AccessRecords::STATUS;
            if ($isrecord) {
                $addrecords->save();
            }
            return false;
        }
    }
}
