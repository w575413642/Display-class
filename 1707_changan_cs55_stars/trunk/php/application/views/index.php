<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$viewIsShowLogin     = $viewIsShowLogin;
$viewIsFull          = $viewIsFull;
$viewIsMyselfJourney = $viewIsMyselfJourney;
$viewIsNewJourney    = $viewIsNewJourney;
$hasIds       		 = $hasIds;
$journey             = $journey;
// echo vide
// print_r($viewIsFull);
?>
<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="format-detection" content="telephone=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title>长安CS55带你穿越星空</title>
		<meta name="keywords" itemprop="name" content="">
		<meta name="description" itemprop="description" content="探秘红蓝双星，寻找CS55线索，赢取500M流量！">
		<meta name="content" itemprop="image" content="探秘红蓝双星，寻找CS55线索，赢取500M流量！">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<base href='<?php echo base_url(); ?>' />
		<link href="css/swiper.css" rel="stylesheet" type="text/css">
		<link href="css/animate.min.css" rel="stylesheet" type="text/css">
		<link href="css/reset.css" rel="stylesheet" type="text/css">
		<link href="css/common.css" rel="stylesheet" type="text/css">
		<link href="css/index.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
		<script type="text/javascript" src="tour.js">
		</script>
		<!-- <script type="text/javascript" src="js/pano2vr_player.js?v=1">
		</script> -->
		<!-- <script type="text/javascript" src="js/pano2vrgyro.js">
		</script> -->
		<!-- <script type="text/javascript" src="js/vconsole.min.js">
		</script> -->
		<style type="text/css">
			.backg-1 {
				background: url('images/page2/page2_gif/ALL-60.png') 0 0 no-repeat;
			}
			
			.backg-2 {
				background: url('images/page3/page3_gif/ALL-HD.png') 0 0 no-repeat;
			}
			
			.backg-3 {
				background: url('images/page4/page4_gif/ALL-HD.png') 0 0 no-repeat;
			}
			
			.backg-4 {
				background: url('images/page5/page5_gif/ALL-HD.png') 0 0 no-repeat;
			}
			
			.backg-5 {
				background: url('images/loading.gif') 0 0 no-repeat;
			}
			
			.backg-6 {
				background: url('images/2.jpg') 0 0 no-repeat;
			}
			
			.width100 {
				width: 100%;
			}
			
			.page_bg {
				width: 100%;
				height: 100%;
				position: absolute;
				top: 0px;
				left: 0px;
				bottom: 0px;
				background-size: 100%;
				background-position: center;
			}
			
			.pic {
				width: 100%;
			}
			
			.loading_bg {
				position: fixed;
				top: 0px;
				left: 0px;
				z-index: 9999999999;
			}
			/* page1 */
			
			.page1_bg {
				background-image: url('images/page1/page1_bg.jpg');
				z-index: 888;
			}
			
			.page1_title1 {
				width: 35%;
				top: 10%;
				position: absolute;
				left: 60%;
			}
			
			.page1_title2 {
				width: 100%;
				top: 10%;
				position: absolute;
			}
			
			.page1_btn_desc {
				position: absolute;
				bottom: 13%;
			}
			
			.page1_bottom {
				position: absolute;
				bottom: 5%;
			}
			/* page2 */
			
			.page2_font_gif {}
			
			.pagegif_bottom {
				bottom: 3%;
				position: absolute;
			}
			
			.text_box {
				position: absolute;
				bottom: 10%;
				width: 80%;
				left: 10%;
				z-index: 1111;
			}
			
			.text_box p {
				color: #fff;
				font-size: 12px;
				line-height: 20px;
				text-align: center;
			}
			
			.lo {
				position: absolute;
				z-index: 999999;
				top: 0px;
				left: 0px;
				width: 100%;
				display: none;
			}
			
			.choose {
				position: relative;
				width: 100%;
			}
			
			.b {
				position: absolute;
				left: 11%;
				top: 32%;
				width: 40%;
				animation: mymove 1s infinite;
				-webkit-animation: mymove 1s infinite;
				/* Safari 和 Chrome */
			}
			
			.r {
				position: absolute;
				right: 7%;
				top: 19%;
				width: 20%;
				animation: mymove 1s infinite;
				-webkit-animation: mymove 1s infinite;
				/* Safari 和 Chrome */
			}
			
			.layer {
				/*background: url('images/layer.png') repeat;*/
				background:rgba(0, 0, 0, 0.5);
				position: fixed;
				width: 100%;
				height: 100%;
				left: 0px;
				right: 0px;
				z-index: 999999999999;
				transition: .6s all;
				margin-top: -200%;
			}
			
			.la5,
			.la4,
			.la3,
			.la2,
			.la1 {
				background: url('images/layer.png') repeat;
				position: fixed;
				width: 100%;
				height: 100%;
				left: 0px;
				right: 0px;
				z-index: 9999;
				transition: .6s all;
				display: none;
				margin-top: 0%;
			}
			
			.la1 {
				display: none;
			}
			
			.la2 {
				display: none;
			}
			
			.la3 {
				margin-top: 0%;
				display: none;
				z-index: 999999999;
				position: fixed;
			}
			
			.la4 {
				display: none;
				/*margin-top: -200%;*/
				z-index: 99999999;
			}
			
			.la5 {
				display: none;
				z-index: 9999999999;
			}
			
			.la3 .box {
				padding-top: 20%;
			}
			
			.la5 .box {
				padding-top: 10%;
			}
			
			.la2 .box {
				padding-top: 30%;
			}
			
			.la1 .box,
			.layer .box {
				width: 100%;
				height: 100%;
				position: relative;
			}
			
			.clo {
				position: absolute;
				right: 12%;
				top: 2%;
				z-index: 9999;
				width: 14%;
			}
			
			.theme {
				width: 45%;
				margin: auto;
				display: block;
				padding-top: 20%;
			}
			
			.la2 .box .theme {
				padding-top: 10%;
			}
			
			.msg .top {
				width: 100%;
				margin-top: 4%;
				margin-bottom: 6%;
			}
			
			.msg .bottom {
				width: 100%;
				margin-top: 6%;
			}
			
			.msg input {
				display: block;
				width: 100%;
				margin: auto;
				height: 30px;
				margin-bottom: 5%;
				margin-top: 5%;
				font-size: 16px;
				border-radius: 0px;
				text-align: center;
				padding: 0px;
			}
			
			.msg {
				width: 80%;
				margin: auto;
			}
			
			.submit-msg {
				display: block;
				margin: auto;
				width: 50%;
				margin-top: 6%;
			}
			
			.la2 .box h2 {
				text-align: center;
				color: white;
				font-size: 23px;
				margin: 10% auto 2%;
				width: 80%;
			}
			
			.la2 .small {
				font-size: 14px;
				width: 60%;
				text-align: center;
				color: white;
				margin: 0px auto 8%;
			}
			
			.la4 .box {
				margin-top: 10%;
			}
			
			.la1 .box h2,
			.layer .box h2 {
				text-align: center;
				color: white;
				font-size: 25px;
				margin: 4% auto 0px;
				width: 80%;
			}
			
			.la4 .btn {
				overflow: hidden;
				margin-top: 3%;
			}
			
			.color-w {
				color: white;
				font-size: 30px;
				text-align: center;
			}
			
			.box .btn .left {
				float: left;
				width: 50%;
				/*margin: 0px 5%;*/
			}
			
			.box .btn .right {
				float: right;
				width: 50%;
				/*margin: 0px 5%;*/
			}
			
			.wid-3 {
				width: 85%;
				overflow: hidden;
				margin: auto;
			}
			
			.wid-3 img {
				width: 33.333%;
				display: block;
				float: left;
			}
			
			.wid-2 {
				width: 56.5%;
				margin: auto;
				overflow: hidden;
				margin-bottom: 1%;
			}
			
			.wid-2 img {
				width: 50%;
				display: block;
				float: left;
			}
			
			.video {
				position: absolute;
				top: 0px;
				left: 0px;
				width: 100%;
				height: 100%;
			}
			
			.govide {
				-webkit-animation: tuski 6s steps(36);
				background-image: url('images/2.jpg');
				-moz-animation: tuski 6s steps(36);
				animation: tuski 6s steps(36);
				background-repeat: no-repeat;
				background-position: 0 0;
			}
			
			select {
				height: 35px;
			}
			/*清除ie的默认选择框样式清除，隐藏下拉箭头*/
			
			select::-ms-expand {
				display: none;
			}
			
			@-webkit-keyframes tuski {
				0% {
					background-position: 0;
				}
				100% {
					background-position: -15180px 0;
				}
			}
			
			@-moz-keyframes tuski {
				0% {
					background-position: 0;
				}
				100% {
					background-position: -15180px 0;
				}
			}
			
			@keyframes tuski {
				0% {
					background-position: 0;
				}
				100% {
					background-position: -15180px 0;
				}
			}
			
			#myCanvas {
				position: absolute;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
			}
			
			input::-webkit-input-placeholder {
				/* placeholder颜色  */
				color: black;
			}
			
			.car-title {
				color: white;
				text-align: center;
				font-size: 22px;
			}
			
			.video {
				position: absolute;
				top: 0px;
				left: 0px;
				width: 100%;
			}
			
			.imgt {
				position: absolute;
				bottom: 8%;
				width: 70%;
				display: block;
				/* margin: auto; */
				left: 15%;
			}
			
			.imgb {
				position: absolute;
				bottom: 2%;
				width: 70%;
				display: block;
				/* margin: auto; */
				left: 15%;
			}
			
			.nus,
			.yus {
				position: absolute;
				top: 0px;
				left: 0px;
				display: none;
			}
			
			.nus .us,
			.yus .us {
				width: 100%;
			}
			
			.bor {
				position: relative;
			}
			
			.click {
				position: absolute;
				bottom: 17%;
				width: 100%;
				left: 0px;
			}
			
			.lo-5 {
				position: absolute;
				top: 86.5%;
				right: 1%;
				width: 19%;
			}
			
			.filter {
				-webkit-filter: grayscale(100%);
				/* Chrome, Safari, Opera */
				filter: grayscale(100%);
				opacity: .5;
				border-radius: 130px;
			}
			
			@keyframes mymove {
				from {
					opacity: 1;
				}
				to {
					opacity: 0.4;
				}
			}
			/* swiper */
		</style>
		<!-- vr style -->
		<style>
			body,
			div,
			h1,
			h2,
			h3,
			span,
			p {
				font-family: Verdana, Arial, Helvetica, sans-serif;
				color: #000000;
			}
			
			body {
				font-size: 10pt;
				background: #ffffff;
			}
			
			table,
			tr,
			td {
				font-size: 10pt;
				border-color: #777777;
				background: #dddddd;
				color: #000000;
				border-style: solid;
				border-width: 2px;
				padding: 5px;
				border-collapse: collapse;
			}
			
			h1 {
				font-size: 18pt;
			}
			
			h2 {
				font-size: 14pt;
			}
			
			.warning {
				font-weight: bold;
			}
			/* fix for scroll bars on webkit & Mac OS X Lion */
			
			::-webkit-scrollbar {
				background-color: rgba(0, 0, 0, 0.5);
				width: 0.75em;
			}
			
			::-webkit-scrollbar-thumb {
				background-color: rgba(255, 255, 255, 0.5);
			}
			
			#container1 {
				width: 100%;
				height: auto;
				position: absolute;
				top: 0;
				bottom: 0;
				left: 0;
				right: 0;
				/* transition: .8s all; */
				/* display: none; */
			}
			
			#container2 {
				width: 100%;
				height: auto;
				position: absolute;
				top: 0;
				bottom: 0;
				left: 100%;
				right: 0;
				z-index: 99;
				transition: .8s all;
				/* display: none; */
			}
			
			.cont-tab {
				position: absolute;
				left: 0px;
				bottom: 1%;
				width: 100%;
				z-index: 99999;
			}
			
			.cont-tab div {
				width: 35%;
				float: left;
				margin: 0px 7.5%;
				text-align: center;
				padding: 8px 0px;
				border-radius: 10px;
				color: white;
			}
			
			.swiper-container {
				height: 100%;
				background: black;
				/* margin-top: -1px; */
			}
			
			.ser {
				/*background: #0f97be;*/
			}
			
			.star {
				/*background: #d62769;*/
			}
			
			.star img,
			.ser img {
				width: 100%;
			}
			
			.star-f {
				position: fixed;
				margin-left: -200%;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				/* margin-top: 5px; */
				z-index: 99999;
				transition: .8s all;
			}
			
			.block-cl {
				-webkit-filter: grayscale(0%);
				/* Chrome, Safari, Opera */
				filter: grayscale(0%);
				opacity: 1;
			}
			
			.go {
				-webkit-filter: grayscale(0%);
				/* Chrome, Safari, Opera */
				filter: grayscale(0%);
				opacity: 1;
			}
			
			.music {
				width: 9%;
				position: fixed;
				z-index: 99999999;
				right: 1%;
				top: 1%;
			}
			
			.rotate360 {
				animation: gogogo 2s infinite linear;
				-webkit-animation: gogogo 2s infinite linear;
			}
			
			.fx {
				position: fixed;
				z-index: 9999999999;
				top: 0px;
				left: 0px;
				width: 100%;
				display: none;
			}
			
			img {
				display: block;
			}
			
			.animation-box1 {
				width: 100%;
				position: absolute;
				background: url('images/page2/page2_gif/ALL-60.png?V=232') 0 0 no-repeat;
				background-size: 2400%;
				/*background-color: red;*/
				width: 100%;
				bottom: 5%;
				left: 0%;
				background-position: 0%;
			}
			
			.animation-box2 {
				width: 100%;
				position: absolute;
				background: url('images/page3/page3_gif/ALL-HD.png?V=232') 0 0 no-repeat;
				background-size: 2400%;
				width: 100%;
				bottom: 5%;
				left: 0%;
				background-position: 100%;
			}
			
			.animation-box3 {
				width: 100%;
				position: absolute;
				background: url('images/page4/page4_gif/ALL-HD.png?V=232') 0 0 no-repeat;
				background-size: 2400%;
				/*background-color: red;*/
				width: 100%;
				bottom: 5%;
				left: 0%;
				background-position: 0%;
			}
			
			.animation-box4 {
				width: 100%;
				position: absolute;
				background: url('images/page5/page5_gif/ALL-HD.png?V=232') 0 0 no-repeat;
				background-size: 2400%;
				/*background-color: red;*/
				width: 100%;
				bottom: 5%;
				left: 0%;
				background-position: 0%;
			}
			
			.animation-go1 {
				animation: heart-bursta steps(23) 2.1s both;
			}
			
			.animation-go2 {
				animation: heart-burstb steps(23) 1.3s both;
			}
			
			.animation-go3 {
				animation: heart-burstc steps(23) 2.4s both;
			}
			
			.animation-go4 {
				animation: heart-burstd steps(23) 2.2s infinite both;
			}
			
			@keyframes heart-bursta {
				0% {
					background-position: 0%;
				}
				100% {
					background-position: 100%;
				}
			}
			
			@keyframes heart-burstb {
				0% {
					background-position: 100%;
				}
				100% {
					background-position: 0%;
				}
			}
			
			@keyframes heart-burstc {
				0% {
					background-position: 0%;
				}
				100% {
					background-position: 100%;
				}
			}
			
			@keyframes heart-burstd {
				0% {
					background-position: 0%;
				}
				100% {
					background-position: 100%;
				}
			}
			
			@-webkit-keyframes gogogo {
				from {
					transform: rotate(360deg);
				}
				to {
					transform: rotate(0deg);
				}
			}
			
			.input-wrap select {
				width: 100%;
			}
			
			.input-wrap {
				width: 100%;
				/*background: white;*/
			}
			
			.backg-box {
				height: 1000px;
				width: 1000px;
				position: fixed;
				top: -999999px;
				left: -999999px;
				overflow: hidden;
			}
			
			.width80 {
				overflow: hidden;
				width: 80%;
				margin: auto;
			}
			
			.fl {
				float: left;
			}
			
			.width-3 {
				width: 30%;
				margin-bottom: 5%;
				background: white;
			}
			
			.fr {
				float: right;
			}
			
			.mr-5 {
				margin: 0px 5%;
			}
			
			.input-wrap,
			.half {
				line-height: 35px;
				position: relative;
				height: 35px;
			}
			
			.input-wrap select,
			.half select {
				width: 100%;
				opacity: 0;
				position: absolute;
				top: 0px;
				left: 0px;
				z-index: 99
			}
			
			.input-wrap .text,
			.half .text {
				z-index: 9;
				height: 100%;
				text-align: center;
				width: 100%;
				position: absolute;
				top: 0px;
				left: 0px;
				background: #fff url("images/select.png") no-repeat right center;
				background-size: 17px;
			}
			
			.text span {
				display: block;
				width: 70%;
				text-align: center;
			}
			
			.input-wrap .text span {
				width: 90%;
			}
			
			.text_box p {
				color: black;
			}
			
			.loImg {
				display: block;
				height: 100%;
				margin: auto;
			}
			
			#fir {
				position: fixed;
				left: 0px;
				top: 0px;
				width: 0%;
				height: 0px;
				z-index: -9;
			}
			
			.load-img {
				position: fixed;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 999999999;
				background: black;
			}
			.tip{
			    width: 11%;
			    position: fixed;
			    z-index: 99999999;
			    left: 2%;
			    top: 0.5%;
			    display: none;
			}
			.tip img{
				width: 100%;
				display: block;
				border-radius: 100%;
			}
			.and-luck{
				display: none;
				border-radius: 10000px;
			}
		</style>
	</head>

	<body>
		<div class="tip">
			<img src="images/tip.png">
		</div>
		</div>
		<div class="backg-box">
			<a href="" class="backg-1"></a>
			<a href="" class="backg-2"></a>
			<a href="" class="backg-3"></a>
			<a href="" class="backg-4"></a>
			<a href="" class="backg-5"></a>
			<a href="" class="backg-6"></a>
		</div>
		<div class="fx">
			<img id="fir" src="images/2.jpg" style="display:none;">
			<img src="images/close.png" class="clo">
			<img src="images/shareFriend.png" class="width100">
		</div>
		<div class="load-img">
			<img src="images/lo.png?v=2" class="loImg">
		</div>
		<!-- <div class=""></div> -->

		<img src="images/music.png" class="music" alt="">
		<div class="la2">
			<div class="box">
				<img src="images/close.png" class="clo">
				<div class="msg">
					<img src="images/border.png" class="top">
					<img src="images/gotheme.png" class="theme">
					<h2>暂时没找到线索！</h2>
					<p class="small">还有机会，再接再厉<br/>星级大礼包马上促手可及</p>
					<img src="images/border.png" class="bottom">
					<div class="btn">
					</div>

				</div>
			</div>
		</div>
		<div class="la5">
			<div class="box">
				<img src="images/close.png" class="clo">
				<div class="msg">
					<img src="images/in.png?v=3" class="width100">
				</div>
			</div>
		</div>
		<div class="la3">
			<div class="box">
				<img src="images/close.png" class="clo">
				<div class="msg">
					<h2 class="car-title">11111</h2>
					<img class="pic" src="images/x1.png" class="width100" alt="">
					<div class="btn">
					</div>
				</div>
			</div>
		</div>
		<!-- 留资 -->
		<div class="layer">
			<div class="box">
				<img src="images/close.png" class="clo">
				<img src="images/gotheme.png" class="theme">
				<h2>出发前登记</h2>
				<div class="msg">
					<img src="images/border.png" class="top">
					<div class="width80">
						<input type="text" name="" class="name" placeholder="姓名" id="uname">
						<input type="number" name="" class="phone" placeholder="手机号" id="umobile">
					</div>
					<div class="width80">
						<div class="half fl width-3">
							<select class="input change-text" id="province">
								<option></option>
							</select>
							<div class="text">
								<span>省份</span>
							</div>
						</div>
						<div class="half fl width-3 mr-5">
							<select id="city" class="input  change-text">
								<option></option>
							</select>
							<div class="text">
								<span>城市</span>
							</div>
						</div>
						<div class="half fr width-3">
							<select id="town" class="input change-text">
								<option></option>
							</select>
							<div class="text">
								<span>地区</span>
							</div>
						</div>
						<div class="input-wrap select-wrap fl">
							<select id="dealer" class="input change-text">
								<option></option>
							</select>
							<div class="text">
								<span>经销商</span>
							</div>
						</div>
					</div>
					<img src="images/border.png" class="bottom">
					<img src="images/submit.png" class="submit-msg" id="submitdrive">
				</div>
			</div>
		</div>
		<div class="la4">
			<div class="box">
				<img src="images/close.png" class="clo">
				<div class="msg">
					<img src="images/all.png" class="width100" alt="">
					<div class="light">
						<div class="wid-3">
							<img src="images/1-1.png" class="filter <?php if(in_array(1,$hasIds)){ ?>block-cl<?php } ?>" alt="" rel='0'>
							<img src="images/2-1.png" class="filter <?php if(in_array(2,$hasIds)){ ?>block-cl<?php } ?>" alt="" rel='1'>
							<img src="images/3-1.png" class="filter <?php if(in_array(3,$hasIds)){ ?>block-cl<?php } ?>" alt="" rel='2'>
						</div>
						<div class="wid-2">
							<img src="images/4-1.png" class="filter <?php if(in_array(4,$hasIds)){ ?>block-cl<?php } ?>" alt="" rel='3'>
							<img src="images/5-1.png" class="filter <?php if(in_array(5,$hasIds)){ ?>block-cl<?php } ?>" alt="" rel='4'>
						</div>
					</div>
					<!-- 判断游戏逻辑 1.线索是否集齐 2.是否已经抽奖 3.是否参加过游戏 -->
					<div class="btn">
						<?php if($viewIsFull && $journey['raffle_time']=='' && $journey['launched']==1){ ?>
						<!--我要抽奖-->
						<img src="images/wycj.png" class="left goraffle filter block-cl">
						<img src="images/fxpy.png" class="left goshare filter block-cl">
						<?php }elseif($journey['raffle_time']!=''){ ?>
						<!--分享给朋友-->
						<img src="images/fxpy.png" class="left goshare filter block-cl">
						<?php }elseif(!$viewIsFull){ ?>
						<img src="images/and2.png" class="left list filter" style="display:none">
						<!--没有集齐 继续探索-->
						<?php if(count($hasIds)<=4){ ?>
						<img src="images/jxts.png" class="left goon filter block-cl nano-luck">
						<?php }else{ ?>
						<img src="images/and2.png" class="left list filter">
						<?php } ?>
						<!--寻求帮助-->
						<img src="images/xq.png" class="left gohelp filter block-cl">
						<img src="images/fxpy.png" class="left goshare filter block-cl" style="display:none">
						<?php }elseif($viewIsFull && $journey['launched']==0){ ?>
						<img src="images/and2.png" class="left go filter">
						<img src="images/fxpy.png" class="left goshare filter block-cl">
						<?php } ?>
					</div>
					<!-- <img src="images/submit.png" class="submit-msg"> -->
				</div>
			</div>
		</div>
		<div class="star-f">
			<div class="la1">
				<div class="box">
					<img src="images/close.png" class="clo">
					<img src="images/gotheme.png" class="theme">
					<h2>探索红蓝双星，寻找cs55线索获取星际大礼包</h2>
					<div class="msg">
						<img src="images/border.png" class="top">
						<img src="images/tips.png" class="width100">
						<img src="images/border.png" class="bottom">
					</div>
				</div>
			</div>
			<div id="container1">
				<div id="pano_container" style="width:100%;height:100%;">
					<noscript><table style="width:100%;height:100%;"><tr style="vertical-align:middle;"><td><div style="text-align:center;">ERROR:<br/><br/>Javascript not activated<br/><br/></div></td></tr></table></noscript>
				</div>
			</div>
			<!-- <div id="container2">
				<div id="pano_red" style="width:100%;height:100%;">
					<noscript><table style="width:100%;height:100%;"><tr style="vertical-align:middle;"><td><div style="text-align:center;">ERROR:<br/><br/>Javascript not activated<br/><br/></div></td></tr></table></noscript>
					<script>
						embedpano({swf:"tour.swf", xml:"red.xml", target:"pano_red", html5:"auto", mobilescale:1.0, passQueryParameters:true});
					</script>
				</div>
			</div> -->
			<div class="cont-tab">
				<div class="ser">
					<img src="images/s-1.png">
				</div>
				<div class="star">
					<img src="images/s-2.png">
				</div>
			</div>
		</div>
		<audio id="aud">
			<source src="images/load.mp3" type="audio/mpeg">
		</audio>
		<audio id="video">
			<source src="images/video.mp3" type="audio/mpeg">
		</audio>
		<audio id="all" loop="loop">
			<source src="images/all.m4a" type="audio/mpeg">
		</audio>
		<!-- loading -->

		<div class="page_bg loading_bg" style="">
			<img src="images/1px.png" class="load" style="display: block;margin: auto; height: 100%;" alt="">
			<!-- 			<div class="text_box">
				<p class="p1"></p>
				<p class="p2">&nbsp;</p>
				<p class="p3">&nbsp;</p>
				<p class="p4">&nbsp;</p>
			</div> -->
		</div>
		<!-- loading end -->
		<!--swiper start -->
		<div class="swiper-container constructor">
			<div class="swiper-wrapper posi stop-swiping">
				<!--page1-->
				<div class="swiper-slide">
					<div class="page_bg page1_bg">
						<img class="page1_title1" src="images/page1/title1.png" />
						<img class="page1_title2" src="images/page1/title2.png" />
						<div class="page1_btn_desc">
							<?php if(!empty($journey)){  ?>
							<img class="width100 toCl" src="images/page1/my.png" />
							<?php } ?>
							<img class="width100 open" src="images/page1/page1_rd.png" />
							<img class="width100 block-ms" src="images/page1/page1_desc.png" />
						</div>

						<img class="width100 page1_bottom" src="images/page1/bottom_slogan.png" />
					</div>
				</div>
				<div class="swiper-slide stop-swiping">
					<div class="page_bg page2_bg">
						<img class="width100" src="images/page2/page2_bg.gif" />
						<div class="animation-box1">
							<img width="750" height="275" title="" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAETAQMAAABTNxHTAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADBJREFUeNrtwTEBAAAAwiD7pzbEXmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdAdmDQABNPUutgAAAABJRU5ErkJggg==" style="width:100%;height:auto;" />
						</div>

						<img src="images/logo-55.png" class="lo-5">
						<img class="width100 pagegif_bottom" src="images/bottom_slogan_other.png" />
					</div>
				</div>
				<div class="swiper-slide stop-swiping">
					<div class="page_bg page2_bg">
						<img class="width100" src="images/page3/page3_bg.jpg" />
						<div class="animation-box2">
							<img width="750" height="275" title="" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAETAQMAAABTNxHTAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADBJREFUeNrtwTEBAAAAwiD7pzbEXmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdAdmDQABNPUutgAAAABJRU5ErkJggg==" style="width:100%;height:auto;" />
						</div>
						<img src="images/logo-55.png" class="lo-5">
						<img class="width100 pagegif_bottom" src="images/bottom_slogan_other.png" />
					</div>
				</div>
				<div class="swiper-slide stop-swiping">
					<div class="page_bg page2_bg">
						<img class="width100" src="images/1px.png" id="fly" />
						<div class="animation-box3">
							<img width="750" height="275" title="" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAETAQMAAABTNxHTAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADBJREFUeNrtwTEBAAAAwiD7pzbEXmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdAdmDQABNPUutgAAAABJRU5ErkJggg==" style="width:100%;height:auto;" />
						</div>
						<img src="images/logo-55.png" class="lo-5">
						<img class="width100 pagegif_bottom" src="images/bottom_slogan_other.png" />
						<img src="images/1px.png" class="lo">
					</div>
				</div>
				<div class="swiper-slide stop-swiping">
					<div class="page_bg page2_bg">
						<div class="choose">
							<img class="width100" src="images/page5/bg.jpg" />
							<img class="r" src="images/r.png">
							<img class="b" src="images/b.png">
						</div>
						<div class="animation-box4">
							<img width="750" height="275" title="" alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAETAQMAAABTNxHTAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAADBJREFUeNrtwTEBAAAAwiD7pzbEXmAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdAdmDQABNPUutgAAAABJRU5ErkJggg==" style="width:100%;height:auto;" />
						</div>
						<img src="images/logo-55.png" class="lo-5">
						<img class="width100 pagegif_bottom" src="images/bottom_slogan_other.png" />
						<!-- <img src="images/1px.png" class="lo"> -->
					</div>
				</div>
				<div class="swiper-slide stop-swiping">
					<img class="width100" src="images/page5/bg.jpg" />
					<div class="video" id="tvideo">

					</div>
				</div>
				<div class="swiper-slide stop-swiping">
					<img class="width100" src="images/last.jpg" />
					<img src="images/luck.png" class="imgt">
					<img src="images/back.png" class="imgb">
					<div class="yus">
						<div class="bor">
							<img src="images/close.png" class="clo">
							<img class="us width100" src="images/a-1.png" alt="">
							<img class="width100 click-fx click" src="images/zj.png" alt="">
						</div>
					</div>
					<div class="nus">
						<div class="bor">
							<img src="images/close.png" class="clo">
							<img class="us width100" src="images/a-2.png" alt="">
							<a href="http://e.changan.com.cn/CS552017_4"><img class="width100 click" src="images/wzj.png" alt=""></a>
						</div>
					</div>
				</div>
			</div>
			<!--====================== js_start ======================-->
			<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
			<script type="text/javascript" src="js/swiper-3.4.0.jquery.min.js"></script>
			<script type="text/javascript" src="js/dealers.js"></script>
			<script type="text/javascript" src="js/testdrive.js"></script>
			<script type="text/javascript" src="<?php echo site_url('api')?>"></script>
			<noscript>
			<p><b>Please enable Javascript!</b></p>
			</noscript>
			<script type="text/javascript" charset="utf-8">
				var isMyJourney = '<?php echo $viewIsMyselfJourney; ?>';

				var imgList = [
				'images/x1.png',
				'images/x2.png',
				'images/x3.png',
				'images/x4.png',
				'images/x5.png',
				'images/a-1.png',
				'images/a-2.png'
				];
				var loadi = 0;
				function preload(){
					if (loadi==imgList.length-1) {
						return;
					}else{
						var img = new Image();
						img.src = imgList[loadi];
						img.onload = function () {
							loadi++;
							preload();
						}
					}
				}
				preload();
				var baseurl = 'php/';
				var cs55Drive;

				function initDriveplugin() {
					cs55Config = {
						ctiurl: baseurl,
						cartype: 'jc_',
						aid: '343',
						op: 'try',
						carname: 'CS55',
						carcode: 'S201',
						from_source: 'H5',
						provinceText: '省份',
						cityText: '城市',
						townText: '地区',
						dealerText: '经销商',
						carcodeText: 'CS55',
						debug: 0, //1：不发到长安服务器，只发送到测服 0：发到长安服务器+测服
						hasRaffle: false,
						dtimeEle: $("#dtime"),
						otimeEle: '',
						carcodeEle: '',
						loadprovincechange: function(e) {
							e.prev("label").html(this.provinceText);
							this.cityEle.prev("label").html(this.cityText);
							this.townEle.prev("label").html(this.townText);
							this.dealerEle.prev("label").html(this.dealerText);
						},
						carcodechange: function(e) {
							// e.prev("label").html(e.find("option:selected").text());
						},
						provincechange: function(e) {
							e.prev("label").html(e.find("option:selected").text());
							this.cityEle.prev("label").html(this.cityText);
							this.townEle.prev("label").html(this.townText);
							this.dealerEle.prev("label").html(this.dealerText);
						},
						citychange: function(e) {
							e.prev("label").html(e.find("option").not(function() {
								return !this.selected
							}).text());
							this.townEle.prev("label").html(this.townText);
							this.dealerEle.prev("label").html(this.dealerText);
						},
						townchange: function(e) {
							e.prev("label").html(e.find("option").not(function() {
								return !this.selected
							}).text());
							this.dealerEle.prev("label").html(this.dealerText);
						},
						dealerchange: function(e) {
							e.prev("label").html(e.find("option:selected").text());
						},
						reload: function() {
							// 重置表单====
							//this.unameEle.val('');
							//this.umobileEle.val('');
							// this.dtimeEle.val('试驾时间');
							// this.dtimeEle.prev('label').text('试驾时间');
							//this.provinceEle.val('0').siblings('.text').html("选择省份<span>PROVINCE</span>");
							//this.cityEle.val('0').html("<option>选择城市CITY</option>").siblings('.text').html("选择城市<span>CITY</span>");
							//this.townEle.val('0').html("<option>选择地区TOWN</option>").siblings('.text').html("选择地区<span>TOWN</span>");
							//this.dealerEle.val('0').html("<option>选择经销商CHOOSE</option>").siblings('.text').html("选择经销商<span>CHOOSE</span>");
						},
						submitdrive: function(e) {
							this.reload();
						}
					}
					//实例化试驾插件
					cs55Drive = new Testdrive(cs55Config);
					cs55Drive.init();
				}
				initDriveplugin()

				var art;
				var windowSize = 0;
				//微信分享
				wx.ready(function() {
					wx.onMenuShareAppMessage({
						title: $('title').text(),
						desc: $('[name="description"]').attr('content'),
						link: 'http://e.changan.com.cn/CS552017_5/',
						// link: 'http://www.changan.com.cn/alsvin-v7/sell/',
						imgUrl: 'http://e.changan.com.cn/CS552017_5/images/share.jpg',
						trigger: function(res) {
							// alert('用户点击发送给朋友')
						},
						success: function(res) {
							// console.log('分享成功');
							//alert(getRootPath_web()+'images/share.jpg');
							shareok();
						},
						cancel: function(res) {
							// alert('已取消')
						},
						fail: function(res) {
							// alert(JSON.stringify(res));
						}
					})
					// 朋友圈
					wx.onMenuShareTimeline({
						title: $('title').text(),
						desc: $('[name="description"]').attr('content'),
						link: 'http://e.changan.com.cn/CS552017_5/',
						// link: 'http://www.changan.com.cn/linmax/sell',
						imgUrl: 'http://e.changan.com.cn/CS552017_5/images/share.jpg',
						trigger: function(res) {
							// alert('用户点击发送给朋友')
						},
						success: function(res) {
							// alert('已分享')
							shareok();
						},
						cancel: function(res) {
							// alert('已取消')
						},
						fail: function(res) {
							// alert(JSON.stringify(res));
						}
					})
				})

				function shareok() {
					$.ajax({
						type: "GET",
						url: "<?php echo base_url().'index.php/api/share'; ?>",
						dataType: "json",
						success: function(data) {
							// console.log(data);
							if(data.code == 200 && data.data != 0) {
								// alert(data.data);
								$('.la3 .pic').attr('src', 'images/x' + data.data + '.png');
								$('.la3 .car-title').html('恭喜！获得线索');
								$($(".la4 .light img")[data.data - 1]).addClass("block-cl");
								//判断是否达标
								ifHave();
								$('.list').show();
								$('.nano-luck').hide();
								// $('.la3 .btn').show();
								setTimeout(function() {
									$('.la3').fadeIn()
								}, 300);
							}
						}
					});
				}

				function getRootPath_web() {
					//获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
					var curWwwPath = window.document.location.href;
					//获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
					var pathName = window.document.location.pathname;
					var pos = curWwwPath.indexOf(pathName);
					//获取主机地址，如： http://localhost:8083
					var localhostPaht = curWwwPath.substring(0, pos);
					//获取带"/"的项目名，如：/uimcardprj
					var projectName = pathName.substring(0, pathName.lastIndexOf('/') + 1);
					return(localhostPaht + projectName);
				}
			</script>
			<script type="text/javascript" charset="utf-8">
				var tips = 0,
					ct = 0,
					invr = 0,
					Vr = 0,
					ord = "<?php echo empty($journey)?0:1; ?>";
				// Vr Game red
				// hide URL field on the iPhone/iPod touch
				// 关闭最后弹窗
				$('.bor .clo').click(function() {
					$('.nus').fadeOut()
					$('.yus').fadeOut()
				})
				// 开始播放
				$('.open').click(function() {
					$('.music').addClass('rotate360')
					swiper.slideNext();
					document.getElementById('all').play()
				})
				// 点击奖励
				$('.block-ms').click(function() {
					$('.la3 .pic').attr('src', 'images/tgjl.png');
					$('.la3 .car-title').html('');
					setTimeout(function() {
						$('.la3').fadeIn()
					})
				})
				// select改变
				$('.change-text').change(function() {
					$(this).siblings().children('span').text($(this).find("option").not(function() { return !this.selected }).text())
				})
				// 准备完成时释放音频
				$(document).ready(function() {
					playAudio();
					setTimeout(function() {
						marquee();
					}, 2000)
					var audio = $('#aud');
					var isPlaying = false;

					function playAudio() {
						var audio = $('#my');
						if(audio.attr('src') == undefined) {
							audio.attr('src', audio.data('src'));
						}
						// console.log(audio)
						document.getElementById('aud').play();
						isPlaying = true;
					}
					$(function() {
						document.addEventListener("WeixinJSBridgeReady", function() {
							WeixinJSBridge.invoke('getNetworkType', {}, function(e) {
								playAudio();
								setTimeout(function() {
									marquee();
									$('.load').attr('src', 'images/loading.gif');
								}, 2000)
							});
						}, false);

					})
				})
				window.onresize = function() {
					if (window.orientation == 0) {
							if (/Android/.test(navigator.userAgent)) {
									if($(window).height() < 450) {
										$('.layer').css('top', '-50%');
									} else {
										$('.layer').css('top', '0%');
									}
							} 
					}
				}

				function Controller(a, obCr) {
					var _Cti = this;
					_Cti.b = obCr;
					// opening to the outside world
					_Cti.init = function() {
						vSwiper();
					}
					// internal access
					vSwiper = function() {
						window.swiper = new Swiper(_Cti.b.swiper, {
							direction: 'vertical',
							resistanceRatio: 0,
							followFinger: false,
							speed: 2000,
							effect: 'fade',
							roundLengths: true,
							noSwiping: _Cti.b.or,
							noSwipingClass: 'stop-swiping',
							height: $(window).height(),
							onSlideChangeStart: function(swiper) {

							},
							onSlideChangeEnd: function(swiper) {
								$('#fly').attr('src', 'images/page4/page4_bg.gif?v=2');
								if(swiper.activeIndex == 0 || swiper.activeIndex == 6) {
									// console.log('chongzhi')
								} else {
									_Cti.chagImg()
								}
							}
						});
					}
				}
				Controller.prototype = {
					chagImg: function() {
						switch(parseInt(swiper.activeIndex)) {
							case 1:
								$('.animation-box1').addClass('animation-go1');
								var tt1 = document.querySelector('.animation-box1');
								tt1.addEventListener("webkitAnimationEnd", function() { //动画结束时事件 
									swiper.slideNext();
								}, false);
								break;
							case 2:
								$('.animation-box2').addClass('animation-go2');
								var tt2 = document.querySelector('.animation-box2');
								tt2.addEventListener("webkitAnimationEnd", function() { //动画结束时事件 
									swiper.slideNext();
								}, false);
								break;
							case 3:
								$('.animation-box3').addClass('animation-go3');
								var tt3 = document.querySelector('.animation-box3');
								tt3.addEventListener("webkitAnimationEnd", function() { //动画结束时事件 
									swiper.slideNext();
								}, false);
								break;
							case 4:
								$('.animation-box4').addClass('animation-go4');
								var tt4 = document.querySelector('.animation-box4');
								tt4.addEventListener("webkitAnimationEnd", function() { //动画结束时事件 
									swiper.slideNext();
								}, false);
								break;
						}
					}
				}
				//清除缓存
				clearCookie();
				// 点击分享给朋友
				$('.click-fx').click(function() {
					$('.fx').show();
				})
				$('.fx .clo').click(function() {
					$('.fx').hide();
				})
				// 暂停开始音乐
				$('.music').click(function() {
					if(document.getElementById('all').paused) {
						document.getElementById('all').play();
						$('.music').addClass('rotate360')
					} else {
						document.getElementById('all').pause()
						$('.music').removeClass('rotate360')
					}
				})
				// 直接选择星球
				$('.toCl').click(function() {
					aClue();
				})
				// 线索数组
				var clName = ['CS55外观', 'CS55内饰', 'CS55舒适性', 'CS55智能安全', 'CS55动力'];
				// 点击线索弹出详情
				$('.la4 .light div .filter').click(function() {
					if($(this).hasClass('block-cl')) {
						openMsg(parseInt($(this).attr('rel')))
					}
				})
				setInterval(function() {}, 700)
				// 关闭出发前留资
				$('.clo').click(function() {
					$('.layer').css('margin-top', '-200%')
					$('.la1').css('margin-top', '-200%')
					$('.la2').css('margin-top', '-200%')
				})
				// 综合计算
				function ifHave() {
					if($('.la4 .light .block-cl').length == 5) {
						$('.list').addClass('go');
						$('.goshare').show();
						$('.gohelp').remove();
					}
				}
				// 红蓝双星弹窗
				$('.choose .r').click(function() {
					if(!isMyJourney){
						$.ajax({
							type: "GET",
							url: "<?php echo base_url().'index.php/api/login_fans'; ?>",
							dataType: "jsonp",
							success: function(data) {
							}
						});
					}
					invr = 1;
					tips = 1;
					embedpano(config_pano);
					joinVr()
					// if(ord == 0) {
					// } else {
						setTimeout(function(){
							$('.la5').fadeIn();
							$('.tip').fadeIn();
							$('.la5').css('margin-top', '0px');
						},800)
						$('.star-f').css('margin-left', '0px')
						// $("#container2").css({"left":"0"});
						// $("#container1").hide();
						// pano2.openUrl('{node2}')
						// if(tips == 1) {}
					// }
				});
				$('.choose .b').click(function() {
					if(!isMyJourney){
						$.ajax({
							type: "GET",
							url: "<?php echo base_url().'index.php/api/login_fans'; ?>",
							dataType: "jsonp",
							success: function(data) {
							}
						});
					}
					invr = 1;
					tips = 2;
					embedpano(config_pano);
					joinVr()
					// if(ord == 0) {
					// } else {
						setTimeout(function(){
							$('.la5').fadeIn();
							$('.tip').fadeIn();
							$('.la5').css('margin-top', '0px');
						},800)
						$('.star-f').css('margin-left', '0px')
						// $("#container1").css({"left":"0"});
						// $("#container2").hide();
						// pano2.openUrl('{node1}')
						
					// }
				});

				function joinVr() {

					ct = 1;
					clearInterval(art);
					if(Vr == 1) return;

					// Vr Game
					// function hideUrlBar() {
					// 	window.scrollTo(0, 1);
					// }
					// // window.addEventListener("load", hideUrlBar);
					// window.addEventListener("resize", hideUrlBar);
					// window.addEventListener("orientationchange", hideUrlBar);
					// create the panorama player with the container
					//pano2 = new pano2vrPlayer("container1");
					//pano2.readConfigUrl("blue_out.xml");
					// hideUrlBar();
					Vr = 1;
				}
				// 切换星球
				$('.star').click(function() {
					//console.log(111);
					// $("#container1").fadeIn();
					// $("#container2").hide();
					if(tips==1) {
						krpano.call('loadscene(scene_blue);');
						//embedpano(config_pano);
						// $("#container2").css({"left":'100%'});
						// $("#container1").css({"left":"0"});
						tips=2;
						// pano2.openUrl('{node1}')
					} else {
						krpano.call('loadscene(scene_red);');
						tips=1;
						//embedpano(config_pano);
						// $("#container1").css({"left":'-100%'});
						// $("#container2").css({"left":"0"});
						// pano2.openUrl('{node2}')
					}
				});
				// 打开收集到的线索
				$('.ser').click(function() {
					//判断是否是在vr里
						$(".goon").hide();
						$(".list").show();
					aClue();
				})
				// 关闭VR游戏提示
				$('.la5 .clo').click(function() {
					$('.la5').css('margin-top', '200%')
				})
				//关闭详情弹窗
				$('.la3 .clo').click(function() {
					$('.la3').fadeOut()
					if($('.la3 .btn').css('display') == 'none') {
						$('.la4').fadeIn()
					}
				})
				// 合成碎片页关闭
				$('.la4 .clo').click(function() {
					$('.la4').fadeOut()
				})
				// 请求帮助
				$('.gohelp').click(function() {
					help()
				})
				//继续探索
				$(".goon").click(function() {
					// alert('接着找');
					$(".la4").fadeOut();
					swiper.slideTo(4);
				});
				//我要抽奖
				$(".goraffle").click(function() {
					var hasPhone = '<?php echo $journey["tel"]; ?>';
					$(".la4").hide();
					swiper.slideTo(6);
					if(hasPhone!=''){
						goLuck();
					}else{
						// if (ord) {} else {}
						$('.layer').css('margin-top', '0%');
					}
				});

				//分享给朋友
				$('.goshare').click(function() {
					alert('点击右上角分享吧');
				});
				// 清空cookie
				function clearCookie() {
					var keys = document.cookie.match(/[^ =;]+(?=\=)/g);
					if(keys) {
						for(var i = keys.length; i--;)
							document.cookie = keys[i] + '=0;expires=' + new Date(0).toUTCString()
					}
				}

				function help() {
					$('.la4').fadeOut()
					parseInt($(this).attr('rel'))
					$('.la3 h2').html('')
					$('.la3 .btn').hide()
					$('.la3 .pic').attr('src', 'images/help.png')
					setTimeout(function() {
						$('.la3').fadeIn()
					}, 300)
				}
				// 打开详细介绍
				function openMsg(ir) {
					$('.la4').fadeOut()
					parseInt($(this).attr('rel'))
					$('.la3 h2').html(clName[ir])
					$('.la3 .btn').hide()
					$('.la3 .pic').attr('src', 'images/x' + (ir + 1) + '.png')
					setTimeout(function() {
						$('.la3').fadeIn()
					}, 300)
				}
				// 关闭所有页
				function aClue() {
					$('.la4').fadeIn()
				}
				// 模拟视频
				function video() {
					document.getElementById('video').play();
					$('#tvideo').addClass('govide');
					var tt = document.querySelector('.govide');
					tt.addEventListener("webkitAnimationEnd", function() { //动画结束时事件 
						swiper.slideNext();
						document.getElementById('all').play();
						document.getElementById('video').pause();
						$('#tvideo').remove();
						$('#fir').remove();
					}, false);
				}
				// 抽奖
				$('.imgt').click(function() {
					clearInterval(art);
					$('.layer').css('margin-top', '00%');
				});
				// 抽奖
				function goLuck(){
					$.ajax({
						type: "GET",
						url: "<?php echo base_url().'index.php/api/doraffle'; ?>",
						dataType: "jsonp",
						success: function(data) {
							if(data.code == 200) {
								switch(data.data.id) {
									case -1:
										alert('您已经抽过')
										// $('.nus').fadeIn()
										break;
									case 0:
										$('.nus').fadeIn();
										// alert('很遗憾没有中奖');
										break;
									default:
										$('.yus').fadeIn();
										// alert(data.data.name)
								}
								//关闭抽奖入口
								$(".imgt").remove();
								$(".goraffle").remove();
							}
						}
					});
				}

				// 点击提示 详细信息
				$('.tip').click(function(){
					$('.la5').fadeIn();
					$('.la5').css('margin-top', '0px');
				});
				// 留资提交切换下一屏
				$('.submit-msg').click(function() {
					var uname = $('#uname').val();
					var mobile = $('#umobile').val();
					var pro = $('#province').val();
					var city = $('#city').val();
					var town = $('#town').val();
					var dealer = $('#dealer').val();
					if($.trim(uname)==''){
						alert('请填写您的姓名');
						return false;
					}else if(mobile==''){
						alert('请填写手机号');
						return false;
					}else if(mobile.length != 11 || /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(mobile) == false){
						alert('请填写正确的手机号码');
						return false;
					}else if(pro=='' || parseInt(pro)==0){
						alert('请选择省份');
						return false;
					}else if(city=='' || parseInt(city)==0){
						alert('请选择城市');
						return false;
					}else if(town=='' || parseInt(town)==0){
						alert('请选择地区');
						return false;
					}else if(dealer=='' || parseInt(dealer)==0){
						alert('请选择经销商');
						return false;
					}else{
						cs55Drive.submitdrive();
						$.ajax({
							type: "GET",
							url: "<?php echo base_url().'index.php/api/updateinfo'; ?>" + "/" + $('.name').val() + "/" + $('.phone').val() + "/" + $('#province').find("option").not(function() { return !this.selected }).text() + "/" + $('#city').find("option").not(function() { return !this.selected }).text() + "/" + $('#town').find("option").not(function() { return !this.selected }).text() + "/" + $('#dealer').find("option").not(function() { return !this.selected }).text() + "/<?php echo $from_uid; ?>",
							dataType: "json",
							success: function(data) {
								// console.log(data)
								if(data.code == 200) {
									goLuck();
									$('.layer').css('margin-top','-200%');
									if(tips == 1) {
										// pano2.openUrl('{node1}')
									} else {
										// pano2.openUrl('{node2}')
									}
								} else {
									alert(data.msg);
								}
							}
						});
					}

				})
				// 点击产生线索
				$('.test-click div').click(function() {
					clue();
				})
				// input上移
				$("input").focus(function() {
					if(/Android/.test(navigator.userAgent)) {}
				});
				// input下滑
				$("input").blur(function() {
					if(/Android/.test(navigator.userAgent)) {}

				})
				// 线索触发
				function clue(cis) {
					// alert(document.cookie)
					var haveCokb = new RegExp(cis + '=' + cis + 'b')
					var haveCokr = new RegExp(cis + '=' + cis + 'r')
					if(haveCokb.test(document.cookie) || haveCokr.test(document.cookie)) {
						alert('来过喽，看看其他的吧!')
					} else {
						$.ajax({
							type: "GET",
							url: "<?php echo base_url().'index.php/api/getpiece'; ?>",
							dataType: "json",
							success: function(data) {
								if(data.code == 200 && data.data.id != 0) {
									$('.la3 .pic').attr('src', 'images/x' + data.data.key + '.png');
									$('.la3 .car-title').html('恭喜！获得线索');
									$($(".la4 .light img")[parseInt(data.data.id) - 1]).addClass("block-cl");
									//判断是否达标
									ifHave();
									$('.la3 .btn').show();
									setTimeout(function() {
										$('.la3').fadeIn()
									}, 300)
								} else {
									$('.la3 .pic').attr('src', 'images/no.png');
									$('.la3 .car-title').html('');
									$('.la3 .btn').show();
									setTimeout(function() {
										$('.la3').fadeIn()
									}, 300)
								}

								if(cis > 7) {
									document.cookie = "" + cis + "=" + cis + "b";
								} else {
									document.cookie = "" + cis + "=" + cis + "r";
								}
							}
						});

					}
				}
				// 线索列表触发
				function allClue() {
					$.ajax({
						type: "GET",
						url: "<?php echo base_url().'index.php/api/mypieceslist'; ?>",
						dataType: "json",
						success: function(data) {
							console.log(data.data)
						}
					});
				}
				// 末尾点击返回
				$('.imgb').click(function() {
					reInit()
					$('.animation-box1').removeClass('animation-go1');
					$('.animation-box2').removeClass('animation-go2');
					$('.animation-box3').removeClass('animation-go3');
					$('.animation-box4').removeClass('animation-go4');
				})
				// 重置回到第一屏
				function reInit() {
					clearInterval(art)
					location.replace(location.href)
					ct = 1;
					ord = 1;
				}
				// 进入视频
				$('.list,.go').click(function() {
					if($(this).hasClass("go")) {
						$('.tip').hide();
						$.ajax({
							type: "GET",
							url: "<?php echo base_url().'index.php/api/launched'; ?>",
							dataType: "json",
							success: function(data) {
							}
						});
						swiper.slideTo(5);
						$('.la4').fadeOut()
						$('.star-f').css('margin-left', '-200%')
						video();
						document.getElementById('video').play()
						document.getElementById('all').pause()
					}

				})
				// 监听绘制canvas
			</script>
			<script type="text/javascript" charset="utf-8">
				var i = 0;
				var showString = '2017年7月，中国FAST天文望远镜捕获到一段奇怪电波科学家通过分析怀疑是来自天英座附近两颗红蓝双星';
				$(function() {});

				function marquee() {
					var stringLength = showString.length
					var char = showString.charAt(i);
					var newstr = $(".text_box").html() + char;
					if(i <= 18) $(".text_box .p1").html($(".text_box .p1").html() + char);
					if(i > 18 && i <= 27) $(".text_box .p2").html($(".text_box .p2").html() + char);
					if(i > 27 && i <= 34) $(".text_box .p3").html($(".text_box .p3").html() + char);
					if(i > 34 && i <= 51) $(".text_box .p4").html($(".text_box .p4").html() + char);
					i++;
					var timeID = setTimeout("marquee()", 140);
					if(i >= stringLength + 10) {
						// init
						var ar = new Controller(1, {
							loop: true,
							queue: ['.gif1', '.gif1', '.gif2', '.gif3', '.gif4'],
							swiper: '.constructor',
							speed: 100,
							or: true
						});
									$('.loading_bg').hide()
									$('.loImg').hide();
									$('.load-img').fadeOut();

						ar.init()
						clearTimeout(timeID);
						$(".text_box").html('<p class="p1">@%#@……￥……@……￥@# </p><p class="p2">注意：信息屏蔽封锁开启</p>');
						setTimeout(function() { $('.loading_bg').hide(); }, 1000);
					}
				}
			</script>
			<script type="text/javascript" charset="utf-8">
				var krpano;
				var krpanoReady = function(krpano){
					// console.log(window.tips);
					if(window.tips==1){
						krpano.call('loadscene(scene_red);');
					}
					window.krpano = krpano;
				};
				var config_pano = {swf:"tour.swf", xml:"blue_red.xml", target:"pano_container", html5:"prefer", mobilescale:1.0, passQueryParameters:true,onready:krpanoReady};
				// var config_red = {swf:"tour.swf", xml:"red.xml", target:"pano_blue", html5:"auto", mobilescale:1.0, passQueryParameters:true}
			</script>
			<!-- 监测代码 -->
			<script>
			var _hmt = _hmt || [];
			(function() {
			  var hm = document.createElement("script");
			  hm.src = "https://hm.baidu.com/hm.js?fc431c37341480c51571f9e4809cf526";
			  var s = document.getElementsByTagName("script")[0]; 
			  s.parentNode.insertBefore(hm, s);
			})();
			</script>
	</body>

</html>