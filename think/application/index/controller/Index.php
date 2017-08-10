<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Image;
use think\Db;//引入数据库操作类
use app\index\model\Index as IndexModel; 

//短信验证
use \xyy\Ucpass;

class Index extends Controller
{
    //首页
    public function index()
    {
        $detai = new IndexModel();
 
        if (!empty(Session('uid'))){
            $uid = Session("uid");
        } else {
            $uid = 0;
        }

        //所有商品
        $re = $detai->indexs();

        //中餐
        $chinese = $detai->chinese();

        //西餐
        $western = $detai->western();

        //甜点
        $sweet = $detai->sweet();

        //日韩料理
        $rhll = $detai->rhll();

        //订单状态
        $status1 = $detai->status($uid);
        $status = $status1['res'];

        //30分钟更新一下订单状态
        $time = time();
        $order = Db::name('order')->field('create_time,status,oid')->where("status",'neq','-1')->select();
        foreach ($order as $value) {
            //订单状态
            $create_time = strtotime($value['create_time']);
            for ($i = 0;$i < 4;$i ++) {
                if (($time - $create_time) == 30 * 3600) {
                    Db::name('order')->where('oid',$value['oid'])->setInc('status');
                }
            }
        }
        //收件人
        $people = $status1['people'];

        //购物车商品数量
        $cart = Db::name('cart')->sum('num');

        //店铺
        $shoper = $detai->shoperIndex();

        $this->assign('status',$status);
        $this->assign('people',$people);
        $this->assign('re',$re);
        $this->assign('cart',$cart);
        $this->assign('shoper',$shoper);
        $this->assign('chinese',$chinese);
        $this->assign('western',$western);
        $this->assign('sweet',$sweet);
        $this->assign('rhll',$rhll);
        return $this->fetch();
    }

    //商品详情
    public function detailsp()
    {
        $detai = new IndexModel();
        $re = $detai->detailsps();

        //购物车商品数量
        $cart = Db::name('cart')->sum('num');

        $this->assign('re',$re[0]);
        $this->assign('address',$re[1]);
        $this->assign('cart',$cart);
        return $this->fetch();
    }

    //购物车详情
    public function cart()
    {
        if (empty(Session('name') || Session('openid'))) {
            $this->error('请登录','index/user/login');
        }
        //商品数量
        $detai = new IndexModel();
        $data = $detai->cart();

        $re = $data[0];

        $this->assign('re',$re);
        
        //地址
        $address = $data[1];
        $this->assign('address',$address);
        
        //购物车中商品的总数
        $count = $data[2];

        //购物车商品数量
        $cart = Db::name('cart')->sum('num');

        $this->assign('count',$count);
        $this->assign('cart',$cart);
        return $this->fetch();
    }

    //修改购物车商品的数量
    public function changeNum()
    {
  
        // 1.接收参数并且处理参数
        $mid = input('mid');
        $num = input('num');
        $uid = Session('uid');
       
        // 2.完成更新操作
        $res = Db::table('order_cart')->where('mid',$mid)->update(['num' => $num]);

        //3.返回处理结果
        echo json_encode($res);
    }

    //删除购物车中的商品
    public function deleteProduct()
    {
         // 1.接收参数并且处理参数
         $mid = input('mid');
         // 2.删除数据表
         $res = Db::name('cart')->where("mid",$mid)->delete();
         // 3.返回处理结果
         echo json_encode($res);
    }


    //清空购物车
    public function clear()
    {
        //将该用户下的所有购物车数据删除
        $uid = Session('uid');

        $res = Db::name('cart')->where('uid',$uid)->delete();
        echo json_encode($res);

    }

    //商品总计
    public function total()
    {
        $detai = new IndexModel();
        $data = $detai->cart();
        $re = $data[0];
        //总计
        $total = 0;
        foreach ($re as $key => $value) {
            $total += ($value['num'] * $value['discount']);
        }
        echo json_encode($total);
    }

    //天气
     public function weather()
    {
         return $this->fetch();
    }

    //店铺
    public function shop()
    {
        $detai1 = new IndexModel();

        //页面顶部购物车商品数量
        $cart = Db::name('cart')->sum('num');
        $this->assign('cart',$cart);

        //店铺详情页
        $detai = $detai1->shoper();

        //店铺详情
        $detail = $detai[0];

        //店铺中的商品详情
        $menu = $detai[1];

        //购物车详情
        $cartDetail = $detai1->cart();

        //购物车中已选商品
        $chosed = $cartDetail[0];

        //购物车中商品的总金额
        $total = 0;
        foreach ($chosed as $key => $value) {
            $total += $value['num'] * $value['price'];
        }

        //购物车商品数量
        $cart = Db::name('cart')->sum('num');

        $this->assign('detail',$detail);
        $this->assign('menu',$menu);
        $this->assign('chosed',$chosed);
        $this->assign('total',$total);
        $this->assign('cart',$cart);
        return $this->fetch();
    }
}
