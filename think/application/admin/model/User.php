<?php
namespace app\admin\model;
use think\Model;
use think\Db;//引入数据库操作类
use think\Session;
use think\paginate;
class User
{
    public function login($user,$pwd)//验证
    {
       $res = Db::query("select type from order_user where username=? AND password=?",[$user,$pwd]);
       if (!$res) {
            $res = Db::query("select type from order_shoper where name=? AND password=?",[$user,$pwd]);
            Session::set('type',1);
            $re = Db::query("select sid from order_shoper where name=? AND password=?",[$user,$pwd]);
            //dump($re);
            foreach ($re as $key => $value) {
               Session::set('sid',$value);
            }  
            return $res;
       } else {
            Session::set('type',2);
            return $res;
       }       
    }
    public function productlists()
    {
        $res = Db::name('menu')->paginate(5,true);
        return $res;
    }
    public function productliss($mid)
    {
        $res = Db::name('menu')->where('mid',$mid)->update(['putaway'=>1]);
        return $res;
    }
    public function productlisss($mid)
    {
        $res = Db::name('menu')->where('mid',$mid)->update(['putaway'=>0]);
        return $res;
    }
    public function deletes($mid)
    {
        $res = Db::name('menu')->where('mid',$mid)->delete();
        return $res;
    }
    public function productbrands()
    {
        $res = Db::name('shoper')->paginate(4);
        return $res;
    }
    public function productadds($sg,$jg,$users,$des,$file,$sy,$jgs,$classify)
    {
        $data = ['sid'=>$sg,'price'=>$jg,'name'=>$users,'description'=>$des,'picture'=>$file,'remain'=>$sy,'discount'=>$jgs,'putaway'=>0,'classify'=>$classify];
        $res = Db::name('menu')->insert($data);
        //dump($res);
        return $res;
    }
    public function stores($pp,$ms,$info,$dz,$tel,$pwd)
    {
        $data = ['name'=>$pp,'description'=>$ms,'picture'=>$info,'address'=>$dz,'phone'=>$tel,'password'=>$pwd];
        $res = Db::name('shoper')->insert($data);
        return $res;
    }
    public function shans($sid)
    {
        $res = Db::name('shoper')->where('sid',$sid)->delete();
        return $res;
    }
    public function changes($sid,$pp,$ms,$info,$dz,$tel)
    {
        $res = Db::name('shoper')->where('sid',$sid)->update(['name'=>$pp,'description'=>$ms,'picture'=>$info,'address'=>$dz,'phone'=>$tel]);
        return $res;
    }
    public function memberlists()
    {
        $res = Db::name('user')->where('type',0)->select();
        return $res;
    }
    public function adminlists()
    {
        $res = Db::name('shoper')->select();
        return $res;
    }
    public function banned($sid)
    {
        $res = Db::name('shoper')->where('sid',$sid)->update(['isOrdered'=>1]);
        return $res;
    }
    public function banneds($sid)
    {
        $res = Db::name('shoper')->where('sid',$sid)->update(['isOrdered'=>0]);
        return $res;
    }
    public function shanchu($sid)
    {
        $res = Db::name('shoper')->where('sid',$sid)->delete;
        return $res;
    }
    public function feedbacklists()
    {
        $res = Db::table('order_user user,order_menu menu,order_remark remark,order_order order')
                ->where("order.oid = remark.oid")
                ->where("menu.mid = remark.mid")
                ->where("user.uid = remark.uid")
                ->select();
        return $res;
    }
    public function deletefeeds($rid)
    {
        $res = Db::name('remark')->where('rid',$rid)->delete();
        return $res;
    }
    public function dchanges($oid)
    {
        $res = Db::name('order')->where('oid',$oid)->select();
        $re = Db::name('user')->where('uid',$res[0]['uid'])->select();
        dump($re);
        return $re;
    }
    public function changess($uid,$phone,$address)
    {
        $res = Db::name('user')->where('uid',$uid)->update(['phone'=>$phone,'address'=>$address]);
        return $res;
    }
    public function sous($user)
    {
        $r = Db::table('order_order o,order_user u,order_menu m,order_menu-order om')
        ->where('o.uid = u.uid')
        ->where('m.mid = om.mid')
        ->where('o.oid = om.oid')
        ->where('username',$user)
        ->select();
        return $r;
    }
}