<?php
namespace app\index\model;

use think\Controller;
use think\Request;
use think\Image;
use think\Db;//引入数据库操作类
class Index
{
    //所有商品
    public function indexs()
    {
        $res = Db::table('order_shoper s,order_menu m ')->where('s.sid=m.sid')->where('putaway',0)->select();
		return $res;
    }

    //中餐
    public function chinese()
    {
        return Db::table('order_shoper s,order_menu m')->where("m.classify = '中餐' and s.sid = m.sid")->where('putaway',0)->select();
    }

    //西餐
    public function western()
    {
        return Db::table('order_shoper s,order_menu m')->where("m.classify = '西餐' and s.sid = m.sid")->where('putaway',0)->select();
    }

    //甜点
    public function sweet()
    {
        return Db::table('order_shoper s,order_menu m')->where("m.classify = '甜点' and s.sid = m.sid")->where('putaway',0)->select();
    }

    //日韩料理
    public function rhll()
    {
        return Db::table('order_shoper s,order_menu m')->where("m.classify = '日韩料理' and s.sid = m.sid")->where('putaway',0)->select();
    }

    //商品详情
    public function detailsps()
    {
        $mid = $_GET['mid'];
        $res = Db::name('menu')->where('mid',$mid)->select();
		
        //商品的地址
        $address = Db::table('order_menu m ,order_shoper s')->where('m.sid=s.sid')->field('s.address')->select()[0]['address'];
        
        return [$res,$address];
    }

    //购物车
    public function cart()
    {
        if (!empty(input())) {
            $mid = input('mid');
            $num = input('Number');
            $uid = Session('uid');

            //判断当前用户在购物车中是否已经加入了该商品
            $result = Db::name('cart')->where('mid',$mid)->select();

            //如果商品不在购物车中，则将商品加入购物车
            if (empty($result)) {
                $date = Db::name('menu')->where('mid',$mid)->select();
                foreach ($date as $key => $value) {
                    $data = Db::name('cart')->insert(['mid' => $mid,'sid'=>$value['sid'],'uid' => $uid]);
                }   
            } else {
                //若商品已经存在于购物车中，修改购物车中商品的数量
                $data = Db::name('cart')->where('mid',$mid)->setInc('num',$num);
            }
        }

        $uid = Session('uid');
        //查询购物车中商品详情
        $res = Db::table('order_menu m,order_cart c')->where("c.uid=$uid and m.mid=c.mid")->field('m.name,m.price,m.picture,c.num,m.mid,m.discount')->select();
        
        //查询购物车中的商品总数
        $totalNum = Db::table('order_cart')->where("uid=$uid")->sum('num');
        
        //商家
        $shoper = Db::table('order_cart c,order_shoper s')->where('c.sid = s.sid')->field('s.address,c.mid')->select();

        //购物车已选商品的数量
        $count = Db::table('order_cart')->where("uid = $uid")->count('cid');

        return [$res,$shoper,$count];
    }

    //订单状态
    public function status($id)
    {
        $uid = $id;
        if ($uid == 0){
            //查询所有的订单
             $res = Db::name('order')->where('status != -1')->select();
             //订单收货人
            $people = Db::table('order_order o,order_user u')->where('o.uid = u.uid')->field('u.username,u.uid,o.uid')->select();
        } else {
            $res = Db::name('order')->where("status != -1 and uid = $uid ")->select();
            $people = Db::table('order_order o,order_user u')->where("o.uid = u.uid and u.uid=$uid")->field('u.username,u.uid,o.uid')->select();
        }
        return ['res' => $res,'people' => $people];
    }


    //商品详情中的商家
    public function shoper()
    {
        $sid = input('sid');
        //商家详情
        $detail = Db::name('shoper')->field('name,address,phone,credit,status,description,picture,charge')->find();

        //该商家下的商品
        $menu = Db::name('menu')->field('name,discount,price,description,picture,putaway,mid')->where("sid=$sid")->select();
        
        return [$detail,$menu];
    }

    //首页商家
    public function shoperIndex()
    {
        return Db::name('shoper')->field('sid,picture,name,address,description')->select();
    }
}