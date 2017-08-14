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
				<td>姓名</td>
				<td>电话</td>
				<td>称呼</td>
				<td>省</td>
				<td>城市</td>
				<td>经销商</td>
				<td>意向车型</td>
				<td>试驾时间</td>
				<td>购车时间</td>
				<td>提交时间</td>
				<td>来源</td>
			</tr>
	<?php
	if(!empty($list)){
		foreach ($list as $item){
			?>
			<tr>
				<td><?php echo $item->uname;?></td>
				<td><?php echo $item->phone;?></td>
				<td><?php echo $item->sex;?></td>
				<td><?php echo $item->province;?></td>
				<td><?php echo $item->city;?></td>
				<td><?php echo $item->dealer;?></td>
				<td><?php echo $item->cartype;?></td>
				<td><?php echo $item->drive_date;?></td>
				<td><?php echo $item->order_date;?></td>
				<td><?php echo date('	Y-m-d H:i:s',$item->create_date);?></td>
				<td><?php echo $item->from_usergent;?></td>
			</tr>
			<?php 
		}
	}
	?>
	</table>
</body>
</html>