<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>留资客户</title>
</head>
<body>

		<table cellpadding=1 cellspacing=1 border=1>
			<tr style="background: #F0F0F0;">
				<td>姓名</td>
				<td>奖品</td>
				<td>电话</td>
				<td>中奖时间</td>
			</tr>
		<?php
		if(!empty($list)){
			foreach ($list as $item){
				?>
				<tr>
					<td><?php echo $item['name'];?></td>
					<td><?php echo $prizeArr[$item['prize']];?></td>
					<td>'<?php echo $item['tel'];?></td>
					<td><?php echo date("Y-m-d H:i:s",$item['raffle_time']);?></td>
					
				</tr>
				<?php 
			}
		}
		?>

		<tr>
			<td colspan="4" rowspan="" headers="">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">制表时间: <?php echo date('Y-m-d H:i:s', time()) ?></td>
			<td colspan="2">中奖人次：<?php echo $count, '/', $total;?></td>			
		</tr>
		</table>

</body>
</html>