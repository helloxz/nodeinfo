<?php
	class Nodequery{
		function ListServer($key){
			//echo $key;
			$url = "https://nodequery.com/api/servers/?api_key=".$key;
			$curl = curl_init($url);
		    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36");
		    curl_setopt($curl, CURLOPT_FAILONERROR, true);
		    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		    $reinfo = curl_exec($curl);
		    curl_close($curl);
		    return $reinfo;
		}
	}

	$api = new Nodequery;
	//设置Nodequery API
	$data = $api->ListServer("xxxxxx");
	$data = json_decode($data);
	$status = $data->status;
	//$data = json_decode($data->data[0]);
	//var_dump($data->data[0]);
	//请求数据成功
	if($status == 'OK') {
		foreach( $data->data[0] as $value )
		{
			//更新时间
			$uptime = date('Y-m-d H:i:s',$value->update_time);
			//echo $uptime;
			//内存
			$ram_total = round($value->ram_total / 1024 / 1024);
			$ram_use = round($value->ram_usage / 1024 / 1024);
			$ram_percent = @round($value->ram_usage / $value->ram_total * 100);
			//磁盘
			$disk_total = round($value->disk_total / 1024 / 1024 / 1024);
			$disk_usage = sprintf("%.1f", $value->disk_usage / 1024 / 1024 / 1024); 
			$disk_percent = @round($value->disk_usage / $value->disk_total * 100);
			//网络
			$network_rx = round($value->current_rx / 1024 / 180);
			$network_tx	= round($value->current_tx / 1024 / 180);
			//可用性
			if($value->status == 'active') {
				$css = 'layui-btn-normal';
				$status = '正常';
			}
			else {
				$css = 'layui-btn-danger';
				$status = $value->status;
			}
			
?>
<tr>
	<td><?php echo $value->name; ?></td>
	<td><?php echo $value->load_percent; ?>%</td>
	<td><?php echo $value->load_average; ?></td>
	<td>
		<?php echo $ram_use."MB/".$ram_total."MB"; ?>
		<div class="layui-progress layui-progress-big" lay-showPercent="yes">
		  <div class="layui-progress-bar layui-bg-blue" lay-percent="<?php echo $ram_percent; ?>%" style="width: <?php echo $ram_percent; ?>%;"> <?php echo $ram_percent; ?>%</div>
		</div>
	</td>
	<td>
		<?php echo $disk_usage."GB/".$disk_total."GB"; ?>
		<div class="layui-progress layui-progress-big" lay-showPercent="yes">
		  <div class="layui-progress-bar layui-bg-blue" lay-percent="<?php echo $disk_percent; ?>%" style="width: <?php echo $disk_percent; ?>%;"> <?php echo $disk_percent; ?>%</div>
		</div>
	</td>
	<td>
		<div id="net-left">↑ <?php echo $network_tx."kb/s"; ?></div>
		<div id="net-right">↓ <?php echo $network_rx."kb/s"; ?></div>
	</td>
	<td><?php echo $value->availability; ?></td>
	<td>
		<div class="layui-btn layui-btn-xs <?php echo $css; ?>"><?php echo $status; ?></div>
	</td>
</tr>
<?php }} ?>
