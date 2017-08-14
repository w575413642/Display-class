<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>线索列表</title>

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
	<base href="<?php echo base_url(); ?>" />
	<script src="js/jquery-1.11.1.js"></script>
	<script>
	function del(id){
		if(id && window.confirm("您确定要删除吗？")){
			window.location.href = 'index.php?d=manage&c=index&m=delprize&id=' + id;
		}
		return false;
	}
	function edit(id){
		window.location.href = 'index.php?d=manage&c=index&m=editprize&id=' + id;
		return false;
	}
	
	function chgPage(ele){
		var page = ele.value;
		page = Number(page);
		if(isNaN(page)){
			page = 1;
		}
		window.location.href = "<?php echo base_url('manage/index/index/page/page') ?>";
	}
	</script>
</head>
<body>

<div id="container">
	<h1>线索列表
	<?php $this->load->view('/manage/nav');?>
	<!-- <a href="index.php?d=manage&c=index&m=addprize">+增加线索</a> -->
	</h1>

	<div id="body">
		<table cellpadding=0 cellspacing=0 border=0>
			<tr style="background: #F0F0F0;">
				<td>KEY</td>
				<td>名称</td>
				<td>概率</td>
				<!-- <td>总数</td> -->
				<!-- <td>剩余</td> -->
				<td>激活</td>
				<td>操作</td>
			</tr>
		<?php
		if(!empty($list)){
			foreach ($list as $item){
				?>
				<tr>
					<!-- <td><?php echo $item->id;?></td> -->
					<td><?php echo $item->key;?></td>
					<td><?php echo $item->name;?></td>
					<td>1/<?php echo $item->probability;?></td>
					<!--<td><?php echo $item->category;?></td>-->
					<!--<td><?php echo $item->remainder;?></td>-->
					<td><?php echo empty($item->enabled)?'未激活':'激活';?></td>
					<td>
						<a href=""  onclick="return del(<?php echo $item->id?>);">删除</a>
						<a href="<?php echo base_url('manage/index/editpiece/id/'.$item->id) ?>" onclick="">编辑</a>
					</td>
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
</body>
</html>