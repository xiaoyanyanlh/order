<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;//引入数据库操作类
use app\admin\model\User as UserModel;
use think\Session;
use think\File;
class Index extends Controller
{
    public function Index()
    {
        if (empty(Session::get('type')) && Session::get('type') !== 2) {
            $this->error('请登录',"/admin/user/login");
        }
       return $this->fetch();
    }
    public function welcome()
    {
        return $this->fetch();
    }
    public function bye()
    {
        Session::clear();
        $this->success('退出成功','/admin/user/login');
    }
    public function productlist()//产品管理页面
    {
        if (session::get('type') == 2){
            $re = Db::name('menu')->count();
            $this->assign('re',$re);
            $user = new UserModel();
            $res = $user->productlists();
            
            $this->assign('res',$res);
            $r = Db::name('menu-order')->select();
            $this->assign('r',$r[0]['num']);

        } else {
            $shoper = Db::name('shoper')->where('name',session::get('name'))->select();
            $re = Db::name('menu')->where('sid',$shoper[0]['sid'])->count();
            $this->assign('re',$re);
            $res = Db::name('menu')->where('sid',$shoper[0]['sid'])->select();
            $this->assign('res',$res);

            //卖出的菜品
        $ress = Db::name('shoper')->where('name',session::get('name'))->find();
        $ress = $ress['sid'];
        $rew = Db::name('menu')
                    ->where("mid",$ress)
                    //->where("mo.mid = m.mid")
                    //->where("num")
                    ->select();
        
        $r = Db::name('menu-order')->where('mid',$rew[0]['mid'])->select();
        $this->assign('r',$r[0]['num']);
        }
        return $this->fetch();
    }
    public function productlis()//产品下架
    {
        $mid = $_GET['mid'];
        $user = new UserModel();
        $res = $user->productliss($mid);
        if ($res) {
            $this->redirect('/admin/index/productlist');
        } else {
            $this->error('下架失败');
        }
    }
    public function productliss()//产品上架
    {
        $mid = $_GET['mid'];
        $user = new UserModel();
        $res = $user->productlisss($mid);
        if ($res) {
            $this->redirect('/admin/index/productlist');
        } else {
            $this->error('上架失败');
        }
    }
    public function delete()//产品删除
    {
        $mid = $_GET['mid'];
        $user = new UserModel();
        $res = $user->deletes($mid);
        if ($res) {
            $this->redirect('/admin/index/productlist');
        } else {
            $this->error('删除失败');
        }
    }
    public function batch()//产品批量删除
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            foreach ($id as $key => $value) {
               $res = Db::name('menu')->where("mid in ($value)")->delete();
            }
            if ($res) {
                $this->redirect('/admin/index/productlist');
            } else {
                $this->error('删除失败');
            }
        } else {
            echo "<script>alert('请选择菜品');</script>";
        }
    }
    public function productadd()//上传产品页面
    {
        return $this->fetch();
    }
    public function productaddd()//上传产品操作
    {
        $sg = input('sg');//所属食馆
        $jg = input('jg');//菜品价格
        $jgs = input('jgs');//打折后价格
        $users = input('user');//菜名
        $sy = input('sy');//菜品剩余量
        $des = $_POST['description'];//菜品简述
        $re = Db::name('shield')->where('content','like',"%$sg%")->whereor('content','like',"%$users%")->whereor('content','like',"%$des%")->select();
        if ($re) {
            $this->error("不能包含隐敏词汇");
        }
        $classify = $_POST['t'];
        if ($classify == 'z') {
            $classify = '中餐';
        } elseif ($classify == 'x') {
            $classify = '西餐';
        } elseif ($classify == 't') {
            $classify = '甜点';
        } else {
            $classify = '日韩料理';
        }
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        if (empty($file)) {
            $this->error("图片不能为空");
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();die;
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();die;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();die;
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
        $info = "\uploads". "\\" . $info->getSaveName();
        $user = new UserModel();
        $res = $user->productadds($sg,$jg,$users,$des,$info,$sy,$jgs,$classify);
        if ($res) {
            $this->success('上传成功',"/admin/index/productlist");
        } else {
            $this->error("上传失败");
        }
    }
    public function productbrand()//商家页面
    {
        if (session::get('type') == 2) {
            $re = Db::name('shoper')->count();
            $this->assign('re',$re);
            $user = new UserModel();
            $res = $user->productbrands();
            $this->assign('res',$res);
        } else {
            $re = Db::name('shoper')->where('name',session::get('name'))->count();
            $this->assign('re',$re);
            $res = Db::name('shoper')->where('name',session::get('name'))->select();
            $this->assign('res',$res);
        }
        return $this->fetch();
    }
    public function close()//店家打烊操作
    {
        $sid = $_GET['sid'];
        $res = Db::name('shoper')->where('sid',$sid)->update(['status'=>1]);
        if ($res) {
            $this->redirect("admin/index/productbrand");
        } else {
            $this->error("修改失败");
        }
      
    }
    public function business()//店家营业操作
    {
        $sid = $_GET['sid'];
        $res = Db::name('shoper')->where('sid',$sid)->update(['status'=>0]);
        if ($res) {
            $this->redirect("admin/index/productbrand");
        } else {
            $this->error("修改失败");
        }
    }
    public function store()//添加商家
    {
        $pp = input('pp');//店铺名称
        $ms = input('ms');//店铺描述
        $dz = input('dz');//店铺地址
        $tel = input('tel');//店铺电话
        $pwd = md5(input('pwd'));         //店铺密码
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        if (empty($file)) {
            $this->error("图片不能为空");
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();die;
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();die;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();die;
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
        $info = "\uploads". "\\" . $info->getSaveName();//图片上传的路径
        $user = new UserModel();
        $res = $user->stores($pp,$ms,$info,$dz,$tel,$pwd);
        if ($res) {
            $this->redirect('/admin/index/productbrand');
        } else {
            $this->error("添加失败");
        }
    }
    public function stores()//添加店铺页面
    {
        return $this->fetch();
    }
    public function shan()//删除店铺操作
    {
        $sid = $_GET['sid'];//店铺id
        $user = new UserModel();
        $res = $user->shans($sid);
        if ($res) {
            $this->redirect('/admin/index/productbrand');
        } else {
            $this->error("删除失败");
        }
    }
    public function shans()//批量删除店铺页面
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            foreach ($id as $key => $value) {
               $res = Db::name('shoper')->where("sid in ($value)")->delete();
            }
            if ($res) {
                $this->redirect('/admin/index/productbrand');
            } else {
                $this->error('删除失败');
            }
        } else {
            echo "<script>alert('请选择店家');</script>";
        }
    }
    public function shopchange()//更改店铺页面
    {
        $sid = $_GET['sid'];
        $res = Db::name('shoper')->where('sid',$sid)->select();
        $this->assign('res',$res);
        return $this->fetch();
    }
    public function change()//更改店铺操作
    {
        $pp = $_POST['pp'];//店铺名称
        $ms = $_POST['ms'];//店铺描述
        $dz = $_POST['dz'];//店铺地址
        $tel = $_POST['tel'];//店铺电话
        $sid = $_POST['sid'];//店铺id
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        if (empty($file)) {
            $this->error("图片不能为空");
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();die;
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();die;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();die;
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
            $info = "\uploads". "\\" . $info->getSaveName();//图片上传的路径
            $user = new UserModel();
            $res = $user->changes($sid,$pp,$ms,$info,$dz,$tel);
        if ($res) {
            $this->redirect('/admin/index/productbrand');
        } else {
            $this->error("更新失败");
        }
    }
}