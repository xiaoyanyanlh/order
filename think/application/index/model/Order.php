<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Order
{
    //查询数据库中用户的收货地址
    public function address()
    {
        $uid = Session('uid');
        //地址表
        return Db::table('order_address')->field('province,address,recipient,phone')->where("uid=$uid")->select();
    }
}