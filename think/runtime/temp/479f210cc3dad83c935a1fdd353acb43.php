<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"C:\wamp64\www\1707\test\WM\think\public/../application/index\view\index\index.html";i:1501243732;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>DeathGhost</title>
<meta name="keywords" content="DeathGhost,DeathGhost.cn,web前端设,移动WebApp开发" />
<meta name="description" content="DeathGhost.cn::H5 WEB前端设计开发!" />
<meta name="author" content="DeathGhost"/>
<link href="/style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/public.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jqpublic.js"></script>
<style>
    .guanbi{display:none;}
</style>
</head>

<body>
<div id="top" style="display:none; margin-left:250px;" class="" ><img src="/images/AD-1000x60.gif" width="980" height="60" /></div>
<div id="banner" style="width:980px; height:291px;display:none; margin-left:250px;"><img src="/images/AD-1000x300.gif" width="980" height="291" /></div>
<header>
 <section class="Topmenubg">
  <div class="Topnav">
   <div class="LeftNav">
   <?php if(empty(\think\Session::get('name') || \think\Session::get('openid'))): ?>
    <a href="/index/user/register">注册</a>
    /
    <a href="/index/user/login">登录</a>
    <?php else: ?>
      欢迎，<?php echo \think\Session::get('name'); ?>  <?php echo \think\Session::get('nickname'); endif; ?>
    <a href="http://sighttp.qq.com/msgrd?v=1&amp;uin=576802885">QQ客服</a>
    <span id='tel'>电话客服</span>
    &nbsp;&nbsp;&nbsp;<span id='tel1' style="color:red"></span>
   </div>
   <div class="RightNav">
    <?php if(\think\Session::get('type') == 0): ?>
      <a href="/index/info/user_center">用户中心</a>
      <?php else: ?>
        <a href="/admin/user/login">管理中心</a>
    <?php endif; ?>
    <a href="/index/info/user_orderlist" target="_blank" title="我的订单">我的订单</a>
    <a href="/index/index/cart">购物车
    (<span style='color:red;'>
        <?php if($cart != 0): ?> 
            <?php echo $cart; else: ?> 0
        <?php endif; ?> </span>)
    </a>
    <a href="/index/info/user_favorites" target="_blank" title="我的收藏">我的收藏</a>
    <a href="#">商家入驻</a>
    <a href="/index/user/logout">退出</a>
   </div>
  </div>
 </section>
 <div class="Logo_search">
  <div class="Logo">
   <img src="/images/logo.jpg" title="DeathGhost" alt="模板">
   <i></i>
   <span>天气：北京市 [<a href="/index/index/weather">海淀区</a> ]</span>
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
<section class="Cfn">
 <aside class="C-left">
  <div class="S-time">服务时间：周一~周六<time>09:00</time>-<time>23:00</time></div>
  <div class="C-time">
   <img src="/upload/wm.jpg"/>
  </div>
  <a href="list.html" target="_blank"><img src="/images/by_button.png"></a>
  <a href="list.html" target="_blank"><img src="/images/dc_button.png"></a>
 </aside>
 <div class="F-middle">
 <ul class="rslides f426x240">
        <li><a href="javascript:"><img src="/upload/01.jpg"/></a></li>
        <li><a href="javascript:"><img src="/upload/02.jpg" /></a></li>
        <li><a href="javascript:"><img src="/upload/03.jpg"/></a></li>
    </ul>
 </div>
 <aside class="N-right">
  <div class="N-title">公司新闻 <i>COMPANY NEWS</i></div>
  <ul class="Newslist">
   <li><i></i><a href="article_read.html" target="_blank" title="这里调用新闻标题...">欢迎访问DeathGhost博客站...</a></li>
   <li><i></i><a href="article_read.html" target="_blank" title="这里调用新闻标题...">H5WEB前端开发 移动WEB模板设计...</a></li>
  </ul>
  
  <!-- 订单状态 -->
  <?php foreach($status as $key => $value): foreach($people as $peo): if($value['uid'] == $peo['uid']): ?>
    <ul class="Orderlist" id="UpRoll">
     <li>
     <p>订单编号：<?php echo $value['orderNum']; ?></p>
     <p>收件人：<?php echo $peo['username']; ?></p>
      <p>订单状态：
        <i class="State01">
        <?php if($value['status'] == 0): ?>
            未发货
            <?php else: if($value['status'] == 1): ?>
                配送中
                <?php else: if($value['status'] == 2): ?>
                    已签收
                    <?php else: if($value['status'] == 3): ?>
                    已点评
                    <?php endif; endif; endif; endif; ?>
        </i>
      </p>
     </li>
    </ul>
    <?php endif; endforeach; endforeach; ?>
  <script>
   var UpRoll = document.getElementById('UpRoll');
   var lis = UpRoll.getElementsByTagName('li');
   var ml = 0;
   var timer1 = setInterval(function(){
    var liHeight = lis[0].offsetHeight;
    var timer2 = setInterval(function(){
     UpRoll.scrollTop = (++ml);
     if(ml ==1){
        clearInterval(timer2);
        UpRoll.scrollTop = 0;
        ml = 0;
        lis[0].parentNode.appendChild(lis[0]);
    }
    },10); 
    },5000);
  </script>
 </aside>
</section>
<section class="Sfainfor">
 <article class="Sflist">
  <div id="Indexouter">
   <ul id="Indextab">
    <li  class="current">点菜</li>
    <li>餐馆</li>
    <li>中餐</li>
    <li>西餐</li>
    <li>甜点</li>
    <li>日韩料理</li>
   </ul>
  <div id="Indexcontent">
   <ul style="display:block;">
    <li>
     <p class="seekarea">
     <a href="#">碑林区</a>
     <a href="#">新城区</a>
     <a href="#">未央区</a>
     <a href="#">雁塔区</a>
     <a href="#">莲湖区</a>
     <a href="#">高新区</a>
     <a href="#">灞桥区</a>
     <a href="#">高陵区</a>
     <a href="#">阎良区</a>
     <a href="#">临潼区</a>
     <a href="#">长安区</a>
     <a href="#">周至县</a>
     <a href="#">蓝田县 </a>
     </p>

     <!-- 所有菜品 -->
     <div class="SCcontent">
     <?php foreach($re as $key => $value): ?>
     <a href="/index/index/detailsp?mid=<?php echo $value['mid']; ?>" target="_blank" title="菜品名称">
      <figure>
       <img src="<?php echo $value['picture']; ?>">
       <figcaption>
       <span class="title"><?php echo $value['name']; ?></span>
       <span class="price"><i>￥</i><?php echo $value['price']; ?></span>
       <span class="price"><i>折扣价:￥</i><?php echo $value['discount']; ?></span>
       </figcaption>
      </figure>
      </a>
      <?php endforeach; ?>
     </div>
       
       <!-- 商家logo  --> 
     <div class="bestshop">
     <?php foreach($shoper as $value): ?>
        <a href="/index/index/shop?sid=<?php echo $value['sid']; ?>" target="_blank" title="店铺名称">
          <figure>
            <img src="<?php echo $value['picture']; ?>">
          </figure>
        </a>
     <?php endforeach; ?>
     </div>
    </li>
   </ul>

   <!-- 餐馆 -->
   <ul>
    <li>
       <p class="seekarea">
       <a href="#">海淀区</a>
       <a href="#">昌平区</a>
       <a href="#">朝阳区</a>
       <a href="#">东城区</a>
       <a href="#">莲湖区</a>
       <a href="#">高新区</a>
       <a href="#">灞桥区</a>
       <a href="#">高陵区</a>
       <a href="#">阎良区</a>
       <a href="#">临潼区</a>
       <a href="#">长安区</a>
       <a href="#">周至县</a>
       <a href="#">蓝田县 </a>
       </p>
       <div class="DCcontent">
        <?php foreach($shoper as $value): ?>
          <a href="/index/index/shop?sid=<?php echo $value['sid']; ?>" target="_blank" title="店铺名称">
           <figure>
              <img src="<?php echo $value['picture']; ?>">
              <figcaption>
                  <span class="title"><?php echo $value['name']; ?></span>
                  <span class="price">预定折扣：<i>8.9折</i></span>
              </figcaption>
              <p class="p1"><q>仅售169元！价值289元的4-5人餐，提供免费WiFi。</q></p>
              <p class="p2">
                 店铺评分：
                 <img src="/images/star-on.png">
                 <img src="/images/star-on.png">
                 <img src="/images/star-on.png">
                 <img src="/images/star-on.png">
                 <img src="/images/star-off.png">
              </p>
              <p class="p3">店铺地址：<?php echo $value['address']; ?></p>
           </figure>
          </a>
        <?php endforeach; ?>
       </div>
    </li>
  </ul>

  <!-- 中餐 -->
  <ul>
    <li>
       <p class="seekarea">
       <a href="#">海淀区</a>
       <a href="#">昌平区</a>
       <a href="#">朝阳区</a>
       <a href="#">东城区</a>
       <a href="#">莲湖区</a>
       <a href="#">高新区</a>
       <a href="#">灞桥区</a>
       <a href="#">高陵区</a>
       <a href="#">阎良区</a>
       <a href="#">临潼区</a>
       <a href="#">长安区</a>
       <a href="#">周至县</a>
       <a href="#">蓝田县 </a>
       </p>
      <div class="SCcontent">
     <?php foreach($chinese as $key => $value): ?>
     <a href="/index/index/detailsp?mid=<?php echo $value['mid']; ?>" target="_blank" title="菜品名称">
      <figure>
       <img src="<?php echo $value['picture']; ?>">
       <figcaption>
       <span class="title"><?php echo $value['name']; ?></span>
       <span class="price"><i>￥</i><?php echo $value['price']; ?></span>
       <span class="price"><i>折扣价:￥</i><?php echo $value['discount']; ?></span>
       </figcaption>
      </figure>
      </a>
      <?php endforeach; ?>
     </div>
    </li>
    </ul>


<!-- 西餐 -->
<ul>
  <li>
     <p class="seekarea">
     <a href="#">海淀区</a>
     <a href="#">昌平区</a>
     <a href="#">朝阳区</a>
     <a href="#">东城区</a>
     <a href="#">莲湖区</a>
     <a href="#">高新区</a>
     <a href="#">灞桥区</a>
     <a href="#">高陵区</a>
     <a href="#">阎良区</a>
     <a href="#">临潼区</a>
     <a href="#">长安区</a>
     <a href="#">周至县</a>
     <a href="#">蓝田县 </a>
     </p>
      <div class="SCcontent">
     <?php foreach($western as $key => $value): ?>
     <a href="/index/index/detailsp?mid=<?php echo $value['mid']; ?>" target="_blank" title="菜品名称">
      <figure>
       <img src="<?php echo $value['picture']; ?>">
       <figcaption>
       <span class="title"><?php echo $value['name']; ?></span>
       <span class="price"><i>￥</i><?php echo $value['price']; ?></span>
       <span class="price"><i>折扣价:￥</i><?php echo $value['discount']; ?></span>
       </figcaption>
      </figure>
      </a>
      <?php endforeach; ?>
     </div>
  </li>
  </ul>



  <!-- 甜点 -->
  <ul>
  <li>
     <p class="seekarea">
     <a href="#">海淀区</a>
     <a href="#">昌平区</a>
     <a href="#">朝阳区</a>
     <a href="#">东城区</a>
     <a href="#">莲湖区</a>
     <a href="#">高新区</a>
     <a href="#">灞桥区</a>
     <a href="#">高陵区</a>
     <a href="#">阎良区</a>
     <a href="#">临潼区</a>
     <a href="#">长安区</a>
     <a href="#">周至县</a>
     <a href="#">蓝田县 </a>
     </p>
      <div class="SCcontent">
     <?php foreach($sweet as $key => $value): ?>
     <a href="/index/index/detailsp?mid=<?php echo $value['mid']; ?>" target="_blank" title="菜品名称">
      <figure>
       <img src="<?php echo $value['picture']; ?>">
       <figcaption>
       <span class="title"><?php echo $value['name']; ?></span>
       <span class="price"><i>￥</i><?php echo $value['price']; ?></span>
       <span class="price"><i>折扣价:￥</i><?php echo $value['discount']; ?></span>
       </figcaption>
      </figure>
      </a>
      <?php endforeach; ?>
     </div>
  </li>
  </ul>


  <!-- 日韩料理 -->
  <ul>
  <li>
     <p class="seekarea">
     <a href="#">海淀区</a>
     <a href="#">昌平区</a>
     <a href="#">朝阳区</a>
     <a href="#">东城区</a>
     <a href="#">莲湖区</a>
     <a href="#">高新区</a>
     <a href="#">灞桥区</a>
     <a href="#">高陵区</a>
     <a href="#">阎良区</a>
     <a href="#">临潼区</a>
     <a href="#">长安区</a>
     <a href="#">周至县</a>
     <a href="#">蓝田县 </a>
     </p>
      <div class="SCcontent">
     <?php foreach($rhll as $key => $value): ?>
     <a href="/index/index/detailsp?mid=<?php echo $value['mid']; ?>" target="_blank" title="菜品名称">
      <figure>
       <img src="<?php echo $value['picture']; ?>">
       <figcaption>
       <span class="title"><?php echo $value['name']; ?></span>
       <span class="price"><i>￥</i><?php echo $value['price']; ?></span>
       <span class="price"><i>折扣价:￥</i><?php echo $value['discount']; ?></span>
       </figcaption>
      </figure>
      </a>
      <?php endforeach; ?>
     </div>
  </li>
  </ul>

 </div>
 </div>
 </article>
 <aside class="A-infor">
  <img src="/upload/2014911.jpg">
  <div class="usercomment">
   <span>用户菜品点评</span>
   <ul>
    <li>
     <img src="/upload/01.jpg">
     用户“DeathGhost”对[ 老李川菜馆 ]“酸辣土豆丝”评说：味道挺不错，送餐速度挺快...
    </li>
    <li>
     <img src="/upload/02.jpg">
     用户“DeathGhost”对[ 魏家凉皮 ]“酸辣土豆丝”评说：味道挺不错，送餐速度挺快...
    </li>
   </ul>
  </div>
 </aside>
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

<!-- 网易七鱼 -->
<script src="https://qiyukf.com/script/a7716a8632828bd3a94fb2983bcac6b0.js"></script>
</body>
</html>
<script type="text/javascript">
  oTel = document.getElementById('tel');
  oTel1 = document.getElementById('tel1');
  oTel.onmouseover = function(){
    oTel1.innerHTML = '010-1234567';
  }
  oTel.onmouseout = function(){
    oTel1.innerHTML = '';
  }

    $(document).ready(function(){
    $("#banner").slideDown("slow"); /*下拉速度 可自己设置*/
});
function displayimg(){
    $("#banner").slideUp(1000,function(){
    $("#top").slideDown(1000);/*下拉速度 可自己设置*/
    $("#top").fadeOut(3000);  
})}
setTimeout("displayimg()",4000);    /*大图显示时间 可自己设置*/

</script>
