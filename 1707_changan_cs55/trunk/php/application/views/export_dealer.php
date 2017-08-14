<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>试驾列表</title>

	<style type="text/css">
	td{boder:1ps solid #ddd; width:100px;}
	</style>
</head>
<body>
	<table>
			<tr>
				<td>ID</td>
				<td>姓名</td>
				<td>电话</td>
				
				<td>经销商</td>
				
				<td>提交时间</td>
			</tr>
	<?php
	if(!empty($list)){
		foreach ($list as $item){
			?>
			<tr>
				<td><?php echo $item->id;?></td>
				<td><?php echo $item->uname;?></td>
				<td><?php echo $item->phone;?></td>
				<td><?php echo $item->dealer;?></td>
				<td><?php echo date('Y-m-d H:i:s',$item->create_date);?></td>
			</tr>
			<?php 
		}
	}
	?>
	</table>
</body>
</html>