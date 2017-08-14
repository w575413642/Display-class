<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title><?php echo $title?>统计列表</title>

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
		min-width: 7em;
		border-bottom: 1px solid #BBB;
		height: 3em;
		vertical-align: middle;
		text-align: center;
	}
	</style>
	
</head>
<body>

<div id="container">
	<h1><?php echo $title?>统计列表（总用户数：<?php echo $count;?>，车主数：<?php echo $owner;?>）

	<?php $this->load->view('nav');?>
	</h1>

	<div style="margin: 0 15px 0 15px;">
		<a href="<?php echo site_url('c=admin&m=shear&type=1')?>">分享</a> |
		<a href="<?php echo site_url('c=admin&m=shear&type=2')?>">投票</a> |
		<a href="<?php echo site_url('c=admin&m=shear&type=3')?>">抽奖</a> 
	</div>
	<div id="body">
		<table cellpadding=0 cellspacing=0 border=0>
			<tr style="background: #F0F0F0;">
				<td>日期</td>
				<td>数量（人次）</td>
			</tr>
		<?php
		if(!empty($list)){
			foreach ($list as $item){
				?>
				<tr>
					<td><?php echo $item['dateflag'];?></td>
					<td><?php echo $item['c'];?></td>
				</tr>
				<?php 
			}
		}
		?>
		</table>
	</div>
	<p class="footer">
	power by CTI</p>
</div>
</body>
</html>