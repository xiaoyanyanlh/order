<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"C:\wamp64\www\1707\test\WM\think\public/../application/index\view\user\login.html";i:1501291189;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>DeathGhost-登录</title>
<meta name="keywords" content="DeathGhost,DeathGhost.cn,web前端设,移动WebApp开发" />
<meta name="description" content="DeathGhost.cn::H5 WEB前端设计开发!" />
<meta name="author" content="DeathGhost"/>
<link href="/style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/public.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jqpublic.js"></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src='/js/ajax.js'></script>
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc.js"></script>

</head>
<body>
<header>
 <section class="Topmenubg">
  <div class="Topnav">
   <div class="LeftNav">
    <a href="/index/user/register">注册</a>/<a href="/index/user/login">登录</a><a href="#">QQ客服</a><a href="#">微信客服</a>
   </div>
   <div class="RightNav">
    <a href="user_center.html">用户中心</a> <a href="user_orderlist.html" target="_blank" title="我的订单">我的订单</a> <a href="cart.html">购物车（0）</a>
    <a href="/index/user/logout">退出</a>
   </div>
  </div>
 </section>
 <div class="Logo_search">
  <div class="Logo">
   <a href='/index/index/index'>
    <img src="/images/logo.jpg" title="DeathGhost" alt="模板">
  </a>
   <i></i>
   <span>西安市 [ <a href="#">莲湖区</a> ]</span>
  </div>
  <div class="Search"> 
   <form method="get" id="main_a_serach" onsubmit="return check_search(this)">
   <div class="Search_nav" id="selectsearch">
    <a href="javascript:;" onClick="selectsearch(this,'restaurant_name')" class="choose">餐厅</a>
    <a href="javascript:;" onClick="selectsearch(this,'food_name')">食物名</a>
   </div>
   <div class="Search_area"> 
   <input type="search" id="fkeyword" name="keyword" placeholder="请输入您所需查找的餐厅名称或食物名称..." class="searchbox" />
   <input type="submit" class="searchbutton" value="搜 索" />
   </div>
   </form>
   <p class="hotkeywords"><a href="#" title="酸辣土豆丝">酸辣土豆丝</a><a href="#" title="这里是产品名称">螃蟹炒年糕</a><a href="#" title="这里是产品名称">牛奶炖蛋</a><a href="#" title="这里是产品名称">芝麻酱凉面</a><a href="#" title="这里是产品名称">滑蛋虾仁</a><a href="#" title="这里是产品名称">蒜汁茄子</a></p>
  </div>
 </div>
 <nav class="menu_bg">
  <ul class="menu">
   <li><a href="index.html">首页</a></li>
   <li><a href="list.html">订餐</a></li>
   <li><a href="category.html">积分商城</a></li>
   <li><a href="article_read.html">关于我们</a></li>
  </ul>
 </nav>
</header>
<!--Start content-->
<section class="Psection MT20">
 <form action="/index/user/checks" method="post" name="form1">
  <table class="login">
    <tr>
      <td width="40%" align="right" class="FontW"><span id='error'></span>账号：</td>
      <td><input type="text" name="user" required autofocus placeholder="账号/电子邮件/手机号码"></td>
    </tr>

    <tr> 
      <td width="40%" align="right" class="FontW">密码：</td>
      <td><input type="password" name="pwd" required></td>
    </tr>
   <!--  <tr>
      <td width="40%" align="right" class="FontW" ><span id='yzm' style="color:red;"></span>&nbsp;&nbsp;&nbsp;验证码：</td>
      <td><input type="text" name="code" id="code"><img src="<?php echo captcha_src(); ?>" onclick="this.src='<?php echo captcha_src(); ?>'" /></td>
    </tr> -->
    <tr>
      <td width="40%" align="right"></td>
      <td>
        <input type="submit" name="" value="登 录" class="Submit_b" id="sb" onclick="return check()" />
        <a href="<?php echo url('index/user/qqlogin'); ?>">
          <span id="qqLoginBtn"><img src="/upload/Connect_logo_3.png"/></span>
        </a>
      </td>
    </tr>
  </table>
 </form>
</section>
<!--End content-->
<div class="F-link">
  <span>友情链接：</span>
  <a href="http://www.deathghost.cn" target="_blank" title="DeathGhost">DeathGhost</a>
  <a href="http://www.17sucai.com/pins/15966.html" target="_blank" title="免费后台管理模板">绿色清爽版通用型后台管理模板免费下载</a>
  <a href="http://www.17sucai.com/pins/17567.html" target="_blank" title="果蔬菜类模板源码">HTML5果蔬菜类模板源码</a>
  <a href="http://www.17sucai.com/pins/14931.html" target="_blank" title="黑色的cms商城网站后台管理模板">黑色的cms商城网站后台管理模板</a>
 </div>
<footer>
 <section class="Otherlink">
  <aside>
   <div class="ewm-left">
    <p>手机扫描二维码：</p>
    <img src="/images/Android_ico_d.gif">
    <img src="/images/iphone_ico_d.gif">
   </div>
   <div class="tips">
    <p>客服热线</p>
    <p><i>1830927**73</i></p>
    <p>配送时间</p>
    <p><time>09：00</time>~<time>22:00</time></p>
    <p>网站公告</p>
   </div>
  </aside>
  <section>
    <div>
    <span><i class="i1"></i>配送支付</span>
    <ul>
     <li><a href="article_read.html" target="_blank" title="标题">支付方式</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">配送方式</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">配送效率</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">服务费用</a></li>
    </ul>
    </div>
    <div>
    <span><i class="i2"></i>关于我们</span>
    <ul>
     <li><a href="article_read.html" target="_blank" title="标题">招贤纳士</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">网站介绍</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">配送效率</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">商家加盟</a></li>
    </ul>
    </div>
    <div>
    <span><i class="i3"></i>帮助中心</span>
    <ul>
     <li><a href="article_read.html" target="_blank" title="标题">服务内容</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">服务介绍</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">常见问题</a></li>
     <li><a href="article_read.html" target="_blank" title="标题">网站地图</a></li>
    </ul>
    </div>
  </section>
 </section>
<div class="copyright">© 版权所有 2016 DeathGhost 技术支持：<a href="http://www.deathghost.cn" title="DeathGhost">DeathGhost</a></div>
</footer>
</body>
</html>
 <script type="text/javascript">
<!-- QQ登录 -->
function toLogin()
{
	var A=window.open("oauth/index.php","TencentLogin", 
   "width=450,height=320,menubar=0,scrollbars=1,
   resizable=1,status=1,titlebar=0,toolbar=0,location=1");
}
</script>