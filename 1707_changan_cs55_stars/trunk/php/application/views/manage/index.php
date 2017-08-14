<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>玩家列表</title>

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
	tr.hidden{
		display:none;
	}
	td{
		/*min-width: 150px;*/
		border-bottom: 1px solid #BBB;
		height: 3em;
		vertical-align: middle;
		text-align: center;
	}
	.childrentr td{
		border:0;
	}
	td.childname{
		text-align:left;
		padding-left:10%;
	}
	.btn{
		border:1px solid #ddd;
		text-align:center;
		vertical-align:middle;
		cursor:pointer;
	}
	</style>
	<base href="<?php echo base_url(); ?>" />
	<script src="js/jquery-1.11.1.js"></script>
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
		window.location.href = "index.php/manage/index/index/page/"+page;
	}

	function showchild(e,t){
		if($(t).val()=='+')
			$(t).val("-");
		else
			$(t).val("+");
		$(".children_"+e).toggleClass("hidden");
	}
	</script>
</head>
<body>

<div id="container">
	<h1>玩家列表(<?php echo $total; ?>)
	<?php $this->load->view('/manage/nav');?>
	<span class="add_button"><a href="<?php echo base_url('manage/index/export');?>">+导出excel</a></span>
	</h1>

	<div id="body">
		<table cellpadding=0 cellspacing=0 border=0>
			<tr style="background: #F0F0F0;">
				<td>姓名</td>
				<td>电话</td>
				<td>省份</td>
				<td>城市</td>
				<td>地区</td>
				<td>经销商</td>
				<td>时间</td>
				<td>已有碎片</td>
			</tr>
		<?php
		if(!empty($data)){
			foreach ($data as $item){
				?>
				<tr>
					<td><?php echo $item['name'];?></td>
					<td><?php echo $item['tel'];?></td>
					<td><?php echo $item['province'];?></td>
					<td><?php echo $item['city'];?></td>
					<td><?php echo $item['town'];?></td>
					<td><?php echo $item['dealer'];?></td>
					<td><?php echo $item['create_time'];?></td>
					<td><?php echo $item['num'];?></td>
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
		$pagesize = empty($pagesize)?20:$pagesize;
		$j = 1;
		while($dataCount < $total){
		?>
		<option <?php if($j == $page){echo 'selected';}?> ><?php echo $j?></option>
		<?php
		$dataCount = $j * $pagesize;
		$j++;
		}?>
	</select>
	每页<?php echo $pagesize;?>
	power by CTI</p>
</div>
</body>
</html>