<?php
namespace app\index\model;

use think\Model;
use think\Db;
class Info
{
    //账户管理
    public function accountManage()
    {
        return Db::name('user')->field('email,phone,picture,nickname')->where("uid",Session('uid'))->find();
    }

    //用户订单
    public function userOrder()
    {
        $uid = Session('uid');
        return Db::table('order_order o,order_menu-order mo,order_menu m')->where("o.oid=mo.oid and mo.uid = $uid and m.mid=mo.mid")->select();
    }

    //用户地址
    public function userAddress()
    {
        $uid = Session('uid');
        // Db::table('think_user')->where('status=1')->order('id desc')->limit(5)->select();
        return Db::name('address')->where("uid=$uid")->order('aid desc')->limit(1)->select();
    }
}
