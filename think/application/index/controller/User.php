<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;//引入数据库操作类
use app\index\model\User as UserModel;
use think\Session;

//短信验证
use \xyy\Ucpass;

//qq登录
use \qqconnect\Recorder;
use \qqconnect\Oauth;
use \qqconnect\QC;

class User extends Controller
{
    protected $user;

    //登录
    public function login()
    {
       return $this->fetch();
    }

    //检测登录
    public function checks()
    {
        $data = input();
        // if(!captcha_check($data['code'])) {
        //     $this->error('验证码错误');
        // }      
        
        $users = $data['user'];
        $pwd = md5($data['pwd']);
        $user = new UserModel();
        $res = $user->login();

        foreach ($res as $key => $value) {
            $uid = $value['uid'];
            $phone = $value['phone'];
            $type = $value['type'];
            if (($users == $value['username'] || $users == $phone) && $pwd == $value['password']) {
                if ($value['isOrdered'] == 1) {
                    echo "<script>alert('你已被拉黑，请联系管理员');</script>";
                }

                //将用户的id、用户名、用户类型存进session
                Session::set('name',$value['username']);
                Session::set('uid',$uid);
                Session::set('type',$type);
                echo "<meta http-equiv='refresh' content='0;url=/index/index/index'>";
               die;
            } 
        }

        $this->error('用户名或手机号或密码错误');        
    }

    //退出
    public function logout()
    {
        if (!empty(Session::get())) {
        Session::clear();
        $this->success('退出成功','/index/index/index');
        } else {
            $this->redirect("/index/index/index");
        }

    }

    //注册
    public function register()
    {
        return $this->fetch();
    }

    //处理注册信息 依赖注入
    public function doRegister(UserModel $user)
    {
        //获取注册信息
        $data = input(); 

        $name = $data['username'];
        $password = $data['pwd'];
        $confirm = $data['confirm'];
        $email = $data['email'];
        $phone = $data['phone'];
        $ip = $_SERVER['SERVER_ADDR'];
        if (!strsecmp($ip,'::1')) {
            $ip = '127.0.0.1';
        }
        $ip = ip2long($ip);

        //检测用户名          
        //用户名由字母(不区分大小写)、数字、点、减号或下划线组成,只能以字母开头,长度为3-12个字符
        $preg = '/^[a-zA-Z]\w{2,12}$/i';
        if (!preg_match($preg,$name,$matches)) {
            $this->error('用户名由字母(不区分大小写)、数字、点、减号或下划线组成,只能以字母开头,长度为3-12个字符');
        }

        //检测密码
        // 密码以字母开头,长度在5~12之间,只能包含字符、数字和下划线。
        $preg = '/^[a-zA-Z]\w{5,12}$/i';
        if (!preg_match($preg,$password,$matches)) {
            $this->error('密码以字母开头,长度在6~12之间,只能包含字符、数字和下划线');
        }
        if (strcasecmp($password,$confirm)) {
            $this->error('两次密码输入不一致');
        }
    
        //控制器验证验证码
        // if(!captcha_check($data['code'])){
        //     $this->error('验证码错误');
        // }       

        if ($data['phoneCode'] !== Session::get('code')) {
            $this->error('手机验证码错误');
        }

        $pwd = md5($password);
        $data = [
            'username' => $name,
            'password' => $pwd,
            'phone' => $phone,
            'create_ip' => $ip,
            'email' => $email,
        ];

        $result = Db::table('order_user')->insert($data);
        
        if ($result) {
            $uid = Db::table('order_user')->field('uid')->where("username='$name' and password='$pwd' and phone='$phone'")->find();

            $uid = $uid['uid'];
            Session::set('uid',$uid);
            Session::set('name',$name);
            $this->success('注册成功','index/index/index');
        } else {
            $this->error('注册失败');
        }
    }
    
     //发送手机号验证码
    public function sendCode()
    {
        if (!empty($_POST)){
            $phone = $_POST['phone'];
        }
        
        //初始化必填
        $options['accountsid']='d543139754c4da305d0cb422ab4f81db';
        $options['token']='04967a5828458e4a7b4da569fdb99346';

        //初始化 $options必填
        $ucpass = new Ucpass($options);

        //随机生成4位验证码
        $str = '0123456789';
        $code = substr(str_shuffle($str),0,4);

        //开发者账号信息查询默认为json或xml
        //echo $ucpass->getDevinfo('json');
        $appId = '7dfc9c1135644fe4abe89b68e3bfdec1';
        $param = $code;
        $templateId = '92321';
        $to = $phone;
        $arr = $ucpass->templateSMS($appId,$to,$templateId,$param);
        Session::set('code',$param);;
    }

    //QQ登录页面
    public function qqLogin(Oauth $oauth)
    {
        $address = $oauth->qq_login();
        $this->redirect($address);
    }

    //QQ
    public function qqcallback(Oauth $oauth)
    {
        $user = new UserModel();
        $accesstoken = $oauth->qq_callback();
        $openid = $oauth->get_openid();
        
        //判断openid是否存在
        $res = $user->openidExists($openid);
        if ($res !== 0) {
            Session::set('openid',$openid);
            echo "<meta http-equiv='refresh' content='0;url=/index/index/index'>";
        }

        //若openid不存在,获取用户qq的信息
        $qc = new QC($accesstoken,$openid);
        $userInfo = $qc->get_user_info();

        $nickname = $userInfo['nickname'];
        $gender = $userInfo['gender'];
        $picture = $userInfo['figureurl'];

        $data = [
            'nickname' => $nickname,
            'gender' => $gender,
            'picture' => $picture,
            'openid' => $openid,
            'phone' => '11111111111',
            'address' => '北京市海淀区',
        ];

        //存入数据库
        $result = $user->qqInfoSave($data);
        if ($result) {
            Session::set('uid',$result);
            Session::set('openid',$openid);
            Session::set('nickname',$nickname);
            echo "<meta http-equiv='refresh' content='0;url=/index/index/index'>";
        } else {
            $this->error('登陆失败');
        }
    }
}