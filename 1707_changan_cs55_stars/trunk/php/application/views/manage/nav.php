	<script>
	function changepsw(){
		var psw = window.prompt("输入新密码");
		if(psw){
			var psw2 = window.prompt("请再输入一次");
			if(psw2){
				if(psw == psw2){
					if(window.confirm("您将使用新密码：" +psw+ "是否继续？")){
						window.location.href = "index.php?c=login&m=changepsw&password="+psw+"&password2="+psw2;
					}
				}else{
					alert("抱歉，两次密码不一致！");
				}
			}
		}
	}
	</script>
	<span class="add_button"><a href="<?php echo base_url('manage/login/logout'); ?>">-登出</a></span>
	<!-- <span class="add_button"><a href="javascript:changepsw();">#修改密码</a></span> -->
	<span class="add_button"><a href="<?php echo base_url('manage/index/shear'); ?>">+统计</a></span>
	<span class="add_button"><a href="<?php echo base_url('manage/index/customer'); ?>">+留资记录</a></span>
	<span class="add_button"><a href="<?php echo base_url('manage/index/prize'); ?>">+奖品列表</a></span>
	<span class="add_button"><a href="<?php echo base_url('manage/index/piece'); ?>">+线索列表</a></span>
	<span class="add_button"><a href="<?php echo base_url('manage/index/index'); ?>">+玩家列表</a></span>
	<!--<span class="add_button"><a href="index.php?c=admin&m=order">+预约购车</a></span>
	<span class="add_button"><a href="index.php?c=admin">+预约试驾</a></span>-->