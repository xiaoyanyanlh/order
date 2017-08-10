$(document).ready(function () {

	// 全选        
	$(".allselect").click(function () {
		
		$(".gwc_tb2  input[type='checkbox']").each(function () {
			$(this).attr("checked", true);
		});
		$('#invert').attr('checked',false);
		GetCount();
	});

	//反选
	$("#invert").click(function () {
		$(".gwc_tb2 input[type='checkbox']").each(function () {
			if ($(this).attr("checked")) {
				$(this).attr("checked", false);
			} else {
				$(this).attr("checked", true);

			} 
		});
		$('.allselect').attr('checked',false);
		GetCount();
	});

	//取消
	$("#cancel").click(function () {
		$(".gwc_tb2 input[type='checkbox']").each(function () {
			$(this).attr("checked", false);
		});
		$('.allselect').attr('checked',false);
		$('#invert').attr('checked',false);
		GetCount();
		$("#jz1").css("display", "block");
		$("#jz2").css("display", "none");
	});

	// 所有复选(:checkbox)框点击事件
	$(".gwc_tb2 input[type='checkbox']").click(function () {
		var aaaa = 0;
		console.log(111);
		console.log(this);
		if ($(this).attr("checked")) {
			aaaa++;
		} else {

		}
		if (aaaa == 0) {
			$("#jz1").css("display", "block");
		$("#jz2").css("display", "none");
		}
	});

	// 输出
	$(".gwc_tb2 input[type='checkbox']").click(function () {
		GetCount();
	});
});

function GetCount() {
	var conts = 0;
	var aa = 0;
	$(".gwc_tb2 input[type='checkbox']").each(function () {
		if ($(this).attr("checked")) {
			for (var i = 0; i < $(this).length; i++) {
				//总计
				conts += parseInt($(this).parent().parent().find('.tb1_td6').children().children().html());
				aa += 1;
			}
		}
	});

	$("#shuliang").text(aa);
	$("#zong1").html((conts).toFixed(2));
	$("#jz1").css("display", "none");
	$("#jz2").css("display", "block");
}


<!---总数---->
$(function () {
	$(".quanxun").click(function () {
		setTotal();
	});
	function setTotal() {
		var len = $(".tot");
		var num = 0;
		for (var i = 0; i < len.length; i++) {
			num = parseInt(num) + parseInt($(len[i]).text());

		}
		var num5 = 121;
		// toFixed(n):固定小数点位数
		$("#zong1").text(num5);
		$("#shuliang").text(len.length);
	}
})

//add to cart shoppage
var data = {"total":0,"rows":[]};
var totalCost = 0;
		
$(function(){
			$('#cartcontent').datagrid({
				singleSelect:true
			});
			$('.item').draggable({
				revert:true,
				proxy:'clone',
				onStartDrag:function(){
					$(this).draggable('options').cursor = 'not-allowed';
					$(this).draggable('proxy').css('z-index',2);
				},
				onStopDrag:function(){
					$(this).draggable('options').cursor='move';
				}
			});
			$('.cart').droppable({
				onDragEnter:function(e,source){
					$(source).draggable('options').cursor='auto';
				},
				onDragLeave:function(e,source){
					$(source).draggable('options').cursor='not-allowed';
				},
				onDrop:function(e,source){
					var name = $(source).find('p:eq(0)').html();
					var price = $(source).find('p:eq(1)').html();
					addProduct(name, parseFloat(price.split('￥')[1]));
				}
			});
		});
		
function addProduct(name,price){
			function add(){
				for(var i=0; i<data.total; i++){
					var row = data.rows[i];
					if (row.name == name){
						row.quantity += 1;
						return;
					}
				}
				data.total += 1;
				data.rows.push({
					name:name,
					quantity:1,
					price:price
				});
			}
			add();
			totalCost += price;
			$('#cartcontent').datagrid('loadData', data);
			$('div.cart .total').html('共计金额: ￥'+totalCost);
}