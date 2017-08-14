<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>试驾列表</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	input {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px auto;
		padding: 12px 10px 12px 10px;
		width:250px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	#body>p>span{float:left;}
	#body>p>a{float:right;margin-left: 1em;}
	#body>p{float: none;clear: both;height: 3em;border-bottom: 1px solid #F8F8F8;line-height: 2em;}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px auto;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	.add_button{float:right;cursor: pointer;padding-left: 12px;}
	table{
		border: 1px solid #BBB;
		width: 100%;
	}
	tr{}
	td{
		min-width: 150px;
		border-bottom: 1px solid #BBB;
		height: 3em;
		vertical-align: middle;
		text-align: center;
	}
	</style>
	<script>
	function del(){
		if(window.confirm("您确定要删除吗？")){
			return true;
		}
		return false;
	}

	function chgPage(ele){
		var page = ele.value;
		page = Number(page);
		if(isNaN(page)){
			page = 1;
		}
		window.location.href = "index.php?c=admin&m=index&page="+page;
	}
	</script>
</head>
<body>

<div id="container">
	<h1>预约试驾列表
	<?php $this->load->view('nav');?>
	<span class="add_button"><a target="_blank" href="index.php?c=admin&m=export_dealer&page=1">+导出厂商</a></span>
	<span class="add_button"><a target="_blank" href="index.php?c=admin&m=export&page=1">+导出留资</a></span>
	</h1>

	<div id="body">
		<table cellpadding=0 cellspacing=0 border=0>
			<tr style="background: #F0F0F0;">
				<td>姓名</td>
				<td>电话</td>
				<td>厂商</td>
				
				<td>提交时间</td>
				
			</tr>
		<?php
		if(!empty($list)){
			foreach ($list as $item){
				?>
				<tr>
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
	</div>
	<p class="footer">
	
	第<?php echo isset($page)?$page:1;?>页 | 转到第几页
	<select id="pagechg" onchange="chgPage(this)">
		<?php 
		$dataCount = 0;
		$j = 1;
		while($dataCount < $count){
		?>
		<option <?php if($j == $page){echo 'selected';}?> ><?php echo $j?></option>
		<?php 
		$dataCount = $j * $pageSize;
		$j++;
		}?>
	</select>
	power by CTI</p>
</div>
<script type="text/javascript" src="scripts/jquery-2.1.4.min.js"></script>
</body>
</html>