<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;//引入数据库操作类
use app\admin\model\User as UserModel;
use think\Session;

class User extends Controller
{
    public function login()
    {
        return $this->fetch();
    }
    public function checks($code = '')//验证验证码和登陆密码
    {
        $captcha = new \think\captcha\Captcha();
        if (!$captcha->check($code)) {
            $this->error('验证码错误');
        } else {
            $users = new UserModel();
            $user = input('user');
            $pwd = md5(input('pwd'));
            $ban = Db::name('shoper')->where('name',$user)->select();
            foreach ($ban as $key => $value) {
            if ($value['isOrdered'] == 1) {
                $this->error('你已被拉入黑名单，请联系超级管理员');
            }
        }
            $re = $users->login($user,$pwd);
            if ($re) {
            foreach ($re as $key => $values) {
               if ($values['type'] !== 0) {
                Session::set('name',input('user'));
                Session::get('name');
                Session::get('type');
                $this->redirect("/admin/index/index");
            } else {
                $this->error("没有权限","/admin/index/login");
                }
            }
        }else{
            $this->error("用户名或密码错误","/admin/user/login");
        }
        }
    }
    public function feedbacklist(Request $request)//评论列表页面
    {
        $r = Db::name('remark')->count();
        $this->assign('r',$r);
        $user = new UserModel();
        $re = $user->feedbacklists();//遍历评论
        //dump($re);
        $this->assign('re',$re);
        return $this->fetch();
    }
    public function deletefeed()//删除评论操作
    {
        $rid = $_GET['rid'];
        $user = new UserModel();
        $re = $user->deletefeeds($rid);
        if ($re) {
             $this->redirect("/admin/user/feedbacklist");
         } else {
            $this->error('删除失败');
         }
    }
    public function souping()//搜索评论页面及操作
    {
        $num = $_GET['user'];
        $res = Db::table('order_user user,order_menu menu,order_remark remark,order_order order')
                //->where("morder.oid = remark.oid")
                ->where("order.oid = remark.oid")
                //->where("morder.mid = remark.mid")
                ->where("menu.mid = remark.mid")
                ->where("user.uid = remark.uid")
                ->where("order.orderNum",$num)
                ->select();
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function memberlist()//会员列表页面
    {
        $res = Db::name('user')->where('type',0)->count();
        $this->assign('res',$res);
        $user = new UserModel();
        $re = $user->memberlists();//遍历会员
        $this->assign('re',$re);
        return $this->fetch();
    }
    public function smemberlist()//搜索会员页面
    {
        $user = input('user');
        $res = Db::name('user')->where('username',$user)->select();
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function changepassword()//修改会员密码页面
    {
        $uid = $_GET['uid'];
        $res = Db::name('user')->where('uid',$uid)->select();
        $this->assign('res',$res);
        return $this->fetch();      
    }
    public function changes()//修改会员密码操作
    {
        $pwd = $_POST['pwd'];
        $uid = $_POST['uid'];
        $res = Db::name('user')->where('uid',$uid)->update(['password'=>$pwd]);
        if ($res) {
            echo '<script>window.close();</script>';
            echo "<script>alert('修改成功');</script>";
        } else {
            $this->error('修改失败');
        }
    }
    public function stop()//封禁会员操作
    {
        $uid = $_GET['uid'];
        $res = Db::name('user')->where('uid',$uid)->update(['isOrdered'=>1]);
        if ($res) {
            $this->redirect("/admin/user/memberlist");
        } else {
            $this->error('修改失败');
        }
    }
    public function go()//启用会员操作
    {
        $uid = $_GET['uid'];
        $res = Db::name('user')->where('uid',$uid)->update(['isOrdered'=>0]);
        if ($res) {
            $this->redirect("/admin/user/memberlist");
        } else {
            $this->error('修改失败');
        }
    }
    public function duser()//删除会员操作
    {
        $uid = $_GET['uid'];
        $res = Db::name('user')->where('uid',$uid)->delete();
        if ($res) {
            $this->redirect("/admin/user/memberlist");
        } else {
            $this->error("失败");
        }
    }
    public function dingdans()
    {
        $res = Db::table('order_order o,order_user u,order_menu m')
        ->where('u.uid = o.uid')
        ->where('m.mid = o.mid')
        ->find();
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function dingdan()//订单详情
// <<<<<<< HEAD
//     {          
//         if (session::get('type') == 2) {
//         $res = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('status',0)
//         ->select();
//         $this->assign('res',$res);
//         $re = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('status',2)
//         ->select();
//         $this->assign('re',$re);
//         $ress = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('status',1)
//         ->select();
//         $this->assign('ress',$ress);
//         $r = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('status',3)
//         ->select();
//         $this->assign('r',$r);
//     }else {
//         $sid = implode('',session::get('sid'));
//         $res = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('sid',$sid)
//         ->where('status',0)
//         ->select();
//         $this->assign('res',$res);
//         $re = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('sid',$sid)
//         ->where('status',2)
//         ->select();
//         $this->assign('re',$re);
//         $ress = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('sid',$sid)
//         ->where('status',1)
//         ->select();
//         $this->assign('ress',$ress);
//         $r = Db::table('order_order o,order_user u,order_menu m')
//         ->where('u.uid = o.uid')
//         ->where('m.mid = o.mid')
//         ->where('sid',$sid)
//         ->where('status',3)
//         ->select();
//         $this->assign('r',$r);
//     }
//     return $this->fetch();
// =======
    {   
        if (session::get('type') == 2) {
        //未发货
        $noSend = Db::table("order_order o,order_menu-order om,order_user u,order_menu m")->where("o.oid=om.oid and o.uid=u.uid and o.status = 0 and m.mid=om.mid")->select();

        //配送中
        $sending = Db::table("order_order o,order_menu-order om,order_user u,order_menu m")->where("o.oid=om.oid and o.uid=u.uid and o.status = 1 and m.mid=om.mid")->select();

        //已签收
        $have = Db::table("order_order o,order_menu-order om,order_user u,order_menu m")->where("o.oid=om.oid and o.uid=u.uid and o.status = 2 and m.mid=om.mid")->select();

        //退货
        $return = Db::table("order_order o,order_menu-order om,order_user u,order_menu m")->where("o.oid=om.oid and o.uid=u.uid and o.status = 4 and m.mid=om.mid")->select();

        $this->assign('noSend',$noSend);
        $this->assign('sending',$sending);
        $this->assign('have',$have);
        $this->assign('return',$return);
    } else {
        //dump(session::get('type'));
        $sid = implode('',session::get('sid'));
                //未发货
        $noSend = Db::table('order_order o,order_user u,order_menu m,order_menu-order om')
        ->where('u.uid = o.uid')
        ->where("o.oid = om.oid")
        ->where('m.mid = om.mid')
        ->where('o.sid',$sid)
        ->where('status',0)
        ->select();

        //配送中
        $sending = Db::table('order_order o,order_user u,order_menu m,order_menu-order om')
        ->where('u.uid = o.uid')
        ->where("o.oid = om.oid")
        ->where('m.mid = om.mid')
        ->where('o.sid',$sid)
        ->where('status',1)
        ->select();

        //已签收
        $have = Db::table('order_order o,order_user u,order_menu m,order_menu-order om')
        ->where('u.uid = o.uid')
        ->where("o.oid = om.oid")
        ->where('m.mid = om.mid')
        ->where('o.sid',$sid)
        ->where('status',2)
        ->select();

        //退货
        $return = Db::table('order_order o,order_user u,order_menu m,order_menu-order om')
        ->where('u.uid = o.uid')
        ->where("o.oid = om.oid")
        ->where('m.mid = om.mid')
        ->where('o.sid',$sid)
        ->where('status',4)
        ->select();

        $this->assign('noSend',$noSend);
        $this->assign('sending',$sending);
        $this->assign('have',$have);
        $this->assign('return',$return);
    }
    return $this->fetch();
    }
    public function dchange()//修改未发货订单页面
    {
        $oid = $_GET['oid'];
        $user = new UserModel();
        $res = $user->dchanges($oid);//查找管理员信息
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function changess()//修改未发货订单操作
    {
        $uid = $_GET['sid'];
        $phone = input('pp');//用户手机
        $address = input('dz');//用户地址
        $user = new UserModel();
        $re = $user->changess($uid,$phone,$address);
        if ($re) {
            $this->redirect("/admin/user/dingdan");
        } else {
            $this->error("修改失败","admin/user/dingdan");
        }
    }
    public function fahuo()//确认发货操作
    {
        $oid = $_GET['oid'];
        $res = Db::name('order')->where('oid',$oid)->update(['status'=>1]);
        if ($res) {
            $this->redirect("/admin/user/dingdan");
        } else {
            $this->error("发货失败");
        }
    }
    public function sou()//搜索用户订单页面
    {  
        $user = $_GET['user'];
        $users = new UserModel();
        $res = $users->sous($user);
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function adminlist()//管理员列表页面
    {
        $res = Db::name('shoper')->count();
        $this->assign('res',$res);
        $user = new UserModel();
        $re = $user->adminlists();//查找管理员信息
        $this->assign('re',$re);
        return $this->fetch();
    }
    public function sadminlist()//搜索管理员页面
    {
        $user = $_GET['user'];
        $res = Db::name('shoper')->where('name',$user)->select();
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function adminlists()//封禁管理员操作
    {
        $sid = $_GET['sid'];
        $user = new UserModel();
        $re = $user->banned($sid);
        if ($re) {
            $this->redirect("/admin/user/adminlist");
        } else {
            $this->error("封禁失败");
        }
    }
    public function open()//解封管理员操作
    {
        $sid = $_GET['sid'];
        $user = new UserModel();
        $re = $user->banneds($sid);
        if ($re) {
            $this->redirect("/admin/user/adminlist");
        } else {
            $this->error("解禁失败");
        }
    }
    public function shanchu()//删除管理员操作
    {
        $sid = $_GET['sid'];
        $user = new UserModel();
        $re = $user->shanchu($sid);
        if ($re) {
            $this->redirect("/admin/user/adminlist");
        } else {
            $this->error("删除失败");
        }
    }
    public function systemshielding()//屏蔽词展示页面
    {
        $res = Db::name('shield')->select();
        $this->assign("res",$res);
        return $this->fetch();
    }
    public function shield()//提交屏蔽词页面
    {
        $content = $_GET['shield'];
        $res = Db::name('shield')->where('hid',1)->update(['content'=>$content]);
        if ($res) {
            $this->redirect('/admin/user/systemshielding');
        } else {
            $this->error("提交失败");
        }
    }
}