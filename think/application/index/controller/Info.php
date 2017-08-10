<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;//引入数据库操作类
use app\index\model\Info as InfoModel;
use think\Session;

class Info extends Controller
{
    //用户中心首页
    public function user_center()
    {
        if (empty(Session('name') || Session('openid'))) {
            $this->error('请登录','index/user/login');
        }
        $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        //用户头像
        $picture = Db::name('user')->field('picture')->where('uid',$uid)->find();

        $this->assign('cart',$cart);
        $this->assign('picture',$picture);
        return $this->fetch();
    }

    //用户订单
    public function user_orderlist()
    {
        if (empty(Session('name') || Session('openid'))) {
            $this->error('请登录','index/user/login');
        }

        $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        $info = new InfoModel();

        //用户订单
        $userOrder = $info->userOrder();
        
        $this->assign('cart',$cart);
        $this->assign('userOrder',$userOrder);
        return $this->fetch();
    }

    //用户地址
    public function user_address()
    {
        $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        $info = new InfoModel();

        $address = $info->userAddress();

        $this->assign('cart',$cart);
        $this->assign('address',$address);
        return $this->fetch();
    }

    //账户管理
    public function user_account()
    {
        $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        $info = new InfoModel();

        //用户信息
        $user = $info->accountManage();

        $this->assign('cart',$cart);
        $this->assign('user',$user);
        return $this->fetch();
    }

    //上传头像
    public function upload()
    {
        //获取表单上传文件
        $files = request()->file('image');

        foreach ($files as $file) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public/' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息,输出 jpg
                $picture = '/uploads/' . $info->getSaveName();
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

        $nickname = input('nickname');
        $email = input('email');
        $phone = input('phone');
        //更新用户的信息
        $res = Db::name('user')->where("uid",Session('uid'))
                               ->update(['nickname' => $nickname,'email' => $email,'phone' => $phone,'picture' => $picture]);
       if ($res) {
            $this->success('更新成功','index/info/user_account');
       } else {
        $this->error('更新失败');
       }
    }

    //我要留言
    public function user_message()
    {
         $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        $this->assign('cart',$cart);
        return $this->fetch();
    }

    //优惠劵
    public function user_coupon()
    {
        $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        $this->assign('cart',$cart);
        return $this->fetch();
    }

    //我的收藏
    public function user_favorites()
    {
        if (empty(Session('name') || Session('openid'))) {
            $this->error('请登录','index/user/login');
        }
         $uid = Session('uid');

        //购物车商品数量
        $cart = Db::name('cart')->where("uid = $uid")->sum('num');

        $this->assign('cart',$cart);
        return $this->fetch();
    }
}