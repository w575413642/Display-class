<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
  <head>
    <title>长安CS55双星之旅 - 数据后台</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <base href="<?php echo base_url(); ?>" />
    <link href="css/login.css" type="text/css" rel="stylesheet"/>
  </head>
  <body class="login-body">
	<div class="login-header">
		<a href="#" class="login-logo" style="font-size: 2em;margin: 9px 0 0 12px;display: block;">
		  长安CS55双星之旅
		</a>
	</div>
	<div class="login-main">
        <!-- <form action="<?=site_url('manage/login')?>" method="post"> -->
        <form action="<?=site_url('manage/login')?>" method="post">
    		<h2>长安CS55双星之旅 - 数据后台</h2>
    		<input placeholder="账号" class="username" name="username" value="<?=$username?>" type="text"/>
    		<input placeholder="密码" class="password" name="password" value="<?=$password?>" type="password"/>
            <div class="msg"><?=$msg?></div>
  		    <button type="submit" class="submit">登陆</button>
        </form>
	</div>
	<div class="login-footer">
		<p>长安行天下 © 2016</p>
	</div>
  </body>
</html>
