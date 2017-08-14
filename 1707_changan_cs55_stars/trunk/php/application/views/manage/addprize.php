<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="utf-8">
	<title>新建奖项</title>

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
	input{
	  font-family: Consolas, Monaco, Courier New, Courier, monospace;
	  font-size: 12px;
	  background-color: #F9F9F9;
	  border: 1px solid #D0D0D0;
	  color: #002166;
	  display: block;
	  margin: 14px 5px;
	  padding: 12px 10px 12px 10px;
	}

	input[type="radio"] {

	  display: inline;
	}
	input[type="text"] {
	  width: 250px;
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
			window.location.href = '<?php echo base_url('manage/index/delprize/id/'); ?>' + id;
		}
		return false;
	}
	function edit(id){
		window.location.href = '<?php echo base_url('manage/index/editprize/id/'); ?>' + id;
		return false;
	}
	
	function chgPage(ele){
		var page = ele.value;
		page = Number(page);
		if(isNaN(page)){
			page = 1;
		}
		window.location.href = "<?php echo base_url('manage/index/index/page/'); ?>"+page;
	}
	</script>
</head>
<body>

<div id="container">
	<h1>新建奖项
	<?php $this->load->view('manage/nav');?>
<!-- 	<span class="add_button"><a href="index.php?c=index&m=export">+导出excel</a></span> -->
<!-- 	<span class="add_button"><a href="javascript:changepsw();">#修改密码</a></span> -->
	</h1>

	<div id="body">
		<form action="<?php echo base_url('manage/index/addprize'); ?>" method="post">
			<table>
				<tbody>
					<tr>
						<td width="5em" align="right">key:</td>
						<td align="left"><input type="text" name="key"></td>
					</tr>
					<tr>
						<td>名称:</td>
						<td align="left"><input type="text" name="name"></td>
					</tr>
					<tr>
						<td>概率:</td>
						<td align="left"><input type="text" name="probability"></td>
					</tr>
					<tr>
						<td>数量:</td>
						<td align="left"><input type="text" name="category"></td>
					</tr>
					<tr>
						<td>剩余:</td>
						<td align="left"><input type="text" name="remainder"></td>
					</tr>
					<tr>
						<td>启用:</td>
						<td align="left" style="text-align: left;">
							<label>启用<input type="radio" name="enabled" value="1" checked="checked"></label>
							<label>禁用<input type="radio" name="enabled" value="0"></label>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left" style="text-align: left;">
							<input type="submit" value="保存" style="width: 150px;">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
</body>
</html>