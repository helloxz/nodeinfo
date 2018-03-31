layui.use(['layer', 'form','element','laydate'], function(){
    var form = layui.form;
    var layer = layui.layer;
    var element = layui.element;
    var laydate = layui.laydate;
});

//请求API数据
function btn(){
	
}
$(document).ready(function(){
	$.get("ListServers.php",function(data,status){
		$("#node").append(data);
		$("#loading").hide();
	});
	setTimeout(refresh, 180000);
	//10秒刷新一次
	//while(refresh()){
	//	setTimeout(refresh(), 10000);
	//}
});

//function refresh(){
//	$("#node").empty();
//	$("#loading").show();
//	$.get("api.php",function(data,status){
//		$("#node").append(data);
//		$("#loading").hide();
//	});
//}
function refresh(){
	window.location.reload();
}