//{method:'get',url:'xxx.php',async:true
//data:{usernanem:'tom',age:19},callback:fn}
//请求时传递的参数        //username=tom&age=19
function ajax(obj)
{
	//1 建立ajax对象
	var xhr = new　XMLHttpRequest();

	//4 监测服务器返回数据
	xhr.onreadystatechange = function(){

		if (xhr.readyState == 4  && xhr.status ==200) {
			console.log(xhr.responseText);
			//var jsonData = eval('(' + xhr.responseText + ')');
			obj.callback(xhr.responseText);
		}
	}

	//处理url
	//预防缓存
	var url = obj.url+"?rand="+Math.random();

	//处理请求参数
	var str = '';
	//index属性名  
	for(var index in obj.data) {
		//encodeURIComponent会对参数的特殊字符串进行转义
		str += encodeURIComponent(index)+"="+encodeURIComponent(obj.data[index]) +'&';
	}
	//去掉末尾&
	str = str.slice(0,-1);
	// console.log(str);

	//判断请求类型
	if (obj.method == 'get') {
		url += "&"+str;	
	} 

	//如果不是同步，默认是异步
	if (obj.async != false ) {
		obj.async = true
	}
	// console.log(obj.async);
	xhr.open(obj.method,url,obj.async);

	//3 发送请求
	if (obj.method == 'get') {
		xhr.send(null);
	} else {
		xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
		xhr.send(str);
	}
}

function get(url,obj,fn)
{
	ajax({
		method:'get',
		url:url,
		data:obj,
		callback:fn
	});
}
function post(url,obj,fn)
{
	ajax({
		method:'post',
		url:url,
		data:obj,
		callback:fn
	});
}