<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Image;
use think\Db;//引入数据库操作类

//订单
use app\index\model\Order as OrderModel;

header("Content-Type:text/html;charset=utf-8");

class Order extends Controller
{
    //ajax提交订单
    public function submitOrder()
    {
        $order = new OrderModel();

        $data = input();
        $mid = $data['mid'];

        $uid = Session('uid');
        $create_time = date('Y-m-d H:i:s');
        $orderNum = time();
        //用户地址
        $address = Db::name('address')->field('address')->where('uid',$uid)->find();
        $address = $address['address'];

        //插入订单表
        $order = [
            'uid' => $uid,
            'create_time' => $create_time,
            'orderNum' => $orderNum,
            'address' => $address,
            'status' => -1,//从购物车提交到订单表
        ];
        $res = Db::name('order')->insert($order);
        if ($res) {
            foreach ($mid as $key => $value) {
                //对应商品数量
                $num = Db::name('cart')->field('num')->where("mid",$value)->find();
                 //插入订单菜品表
                 $oid = Db::name('order')->field('oid')->where('orderNum',$orderNum)->find();
                 $data = [
                    'uid' => $uid,
                    'mid' => $value,
                    'oid' => $oid['oid'],
                    'num' => $num['num'],
                 ];
                 $menuOrder = Db::name('menu-order')->insert($data);
                 if ($menuOrder) {
                    //清空购物车中对应的商品
                    $clear = Db::name('cart')->where("mid",$value)->delete();

                    //商品剩余量-1
                    $remain = Db::name('menu')->where('mid',$value)->setDec('remain');
                 }
            }
        }
        echo json_encode($mid);
    }
    public function confirm_order()
    {
        //购物车商品数量
        $cart = Db::name('cart')->sum('num');

        //从ajax提交的form表单中获取的菜品id
        $data = input();
        $menuId = $data['mid'];

        $order = new OrderModel();

        $data = $order->address();

        $uid = Session('uid');

        //订单详情-商品名、商品价格、商品的折扣价、菜品id
        $menuInfo = Db::name('menu')->alias('m')->join('order_menu-order mo','mo.mid= m.mid')->join('order_order o','mo.oid = o.oid')->field('m.name,m.price,m.discount,m.mid,mo.num,o.orderNum')->where("m.mid in (".$menuId.") and o.status = -1 and mo.uid =$uid ")->select();

        //商品的数量
        $num = Db::name('menu-order')->field('num,mid,oid')->where("mid in (" . $menuId . ")")->select();
        
        //订单总价
        foreach ($menuInfo as $key => $value) {
            foreach ($num as $val) {
                if ($value['mid'] == $val['mid']) {
                    $total = $value['price'] * $val['num'];
                }
            }
        }

        //订单编号
        foreach ($num as $value) {
            $orderNum = Db::name('order')->field('orderNum')->where("oid",$value['oid'])->find();
        }
        $orderNum = $orderNum['orderNum'];

        $this->assign('data',$data);
        $this->assign('menuInfo',$menuInfo);
        $this->assign('num',$num);
        $this->assign('total',$total);
        $this->assign('orderNum',$orderNum);
        $this->assign('cart',$cart);
        return $this->fetch();
    }

    //添加地址
    public function addAddress()
    {
        $province = input('user_province');
        $address = input('user_city') . input('user_area') . input('area');
        $recipient = input('recipient');
        $phone = input('phone');
        $uid = Session('uid');
        $data = [
            'province' => $province,
            'address' => $address,
            'recipient' => $recipient,
            'phone' => $phone,
            'uid' => $uid,
        ];
        $addAddress = Db::name('address')->insert($data);
        echo json_encode($address,JSON_UNESCAPED_UNICODE);
    }

    //支付中心
    public function submit_order()
    {
        //购物车商品数量
        $cart = Db::name('cart')->sum('num');

        $pay = input();
        $total = $pay['total'];
        $orderNum = $pay['orderNum'];
        $uid = Session('uid');
        //更新订单状态
        $status = Db::name('order')->where("uid=$uid")->update(["status" => 0]);
        $this->assign('total',$total);
        $this->assign('orderNum',$orderNum);
        $this->assign('cart',$cart);

        return $this->fetch();
    }
}