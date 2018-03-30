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
	$.get("api.php",function(data,status){
		$("#node").append(data);
	});
});