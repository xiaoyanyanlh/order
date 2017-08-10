<?php
namespace app\index\model;

use think\Model;
use think\Db;

class User
{
    //登录
    public function login()
    {
        $res = Db::name('user')->field('username,password,openid,phone,uid,type,isOrdered')->select();
        return $res;
    }

    //判断openid是否存在
    public function openidExists($openid)
    {

        $res = Db::name('user')->field('openid')->select();
        //dump($res);
        foreach ($res as $value) {
           if ($openid == $value['openid']) {
                return $openid;
            }
        }
        
    }
    //保存qq用户的信息
    public function qqInfoSave($data)
    {
        return Db::name('user')->insertGetId($data);
    }
}