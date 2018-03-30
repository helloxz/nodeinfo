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
	$data = $api->ListServer("JMHP9vw6HpDKEfyXvRdKoQqu4KzX7GRCQbUHhu4YfSIXiG48");
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
			$ram_total = round($value->ram_total / 1000 / 1000);
			$ram_use = round($value->ram_usage / 1000 / 1000);
			$ram_percent = round($value->ram_usage / $value->ram_total * 100);
			//磁盘
			$disk_total = round($value->disk_total / 1024 / 1024 / 1024);
			$disk_percent = round($value->disk_usage / $value->disk_total * 100);
			//网络
			$network_rx = round($value->current_rx / 1024 / 8);
			$network_tx	= round($value->current_tx / 1024 / 8);
			
?>
<tr>
	<td><?php echo $value->name; ?></td>
	<td><?php echo $value->load_average; ?></td>
	<td>
		<?php echo $ram_use."MB/".$ram_total."MB"; ?>
		<div class="layui-progress" lay-showPercent="yes">
		  <div class="layui-progress-bar layui-bg-blue" lay-percent="<?php echo $ram_percent; ?>%" style="width: <?php echo $ram_percent; ?>%;"></div>
		</div>
	</td>
	<td>
		<?php echo $disk_total."GB"; ?>
		<div class="layui-progress" lay-showPercent="yes">
		  <div class="layui-progress-bar layui-bg-blue" lay-percent="<?php echo $disk_percent; ?>%" style="width: <?php echo $disk_percent; ?>%;"></div>
		</div>
	</td>
	<td>
		↑ <?php echo $network_tx."kb/s"; ?> &nbsp;&nbsp;
		↓ <?php echo $network_rx."kb/s"; ?> 
	</td>
	<td><?php echo $value->availability; ?></td>
	<td><?php echo $value->status; ?></td>
</tr>
<?php }} ?>