$(function(){
	var imgS = 583/91;
	$('.m-form input,#cti_form_sex_select').height($(window).width()*0.77/imgS);  
	$('.m-form input,#cti_form_sex_select').css("lineHeight",$(window).width()*0.77/imgS + "px");
	$('#cti_form_sex_select').on('touchstart',function(){
		var sexselect = $(this).find("option:selected").val(); 
		$('#cti_form_sex').val(sexselect);
	})
	$('#cti_form_sex_select').change(function(){
		var sexselect = $(this).find("option:selected").val(); 
		$('#cti_form_sex').val(sexselect);
	})
	//判断url
	function checkurl(){
		var i = window.location.hash.replace("#","");
		var ii = $.trim(i);
		if (ii=='allcar') {
			mainSwiper.slideTo(2, 1000, false);
		}else{
			return;
		}
	}; 

	//背景
	if($(window).width()/$(window).height()<0.68){ 
	}else if($(window).width()/$(window).height()>0.6){
		//宽矮 短 
	}
	//操作池
	// var $page1plum = $('.plum'),
		// $page1lantern = $('.lantern'),
		// $page1lantern2 = $('.lantern2'),
		$page1tit = $('.tit'),
		// $page1lantern3 = $('.lantern3'),
		$page1join = $('.join'),
		$page1cloud = $('.cloud'),

		// $page8plum2 = $('.plum2'),
		$page8tit2 = $('.tit2'),
		$page8content = $('.content'),
		$page8contentform = $('.content .m-form'),
		$page8submit = $('.submit img');

		// $page1plum.addClass('fadeInRight' + ' animated').hide();
		// $page1lantern.addClass('fadeInRight' + ' animated2').hide();
		// $page1lantern2.addClass('fadeInRight' + ' animated2').hide();
		$page1tit.addClass('zoomIn' + ' animated').hide();
		// $page1lantern3.addClass('fadeIn' + ' animated2').hide();
		$page1join.addClass('fadeInLeft' + ' animated2').hide();
		$page1cloud.addClass('fadeIn' + ' animated3').hide();

		// $page8plum2.addClass('fadeInRight'+' animated').hide();
		$page8tit2.addClass('zoomIn'+' animated').hide();
		$page8content.addClass('fadeInRight'+' animated').hide();
		$page8submit.addClass('fadeInUpBig'+' animated2').hide();
	//此变量用来存储判断动画是否停止的数据
	var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
	var flower1=true,flower2=true; 
	pageModes={
		init:function(a){
			switch(a){
				case 0:
					// $page1plum.addClass('fadeInRight' + ' animated').hide();
					// $page1lantern.addClass('fadeInRight' + ' animated2').removeClass('swing').hide();
					// $page1lantern2.addClass('fadeInRight' + ' animated2').removeClass('swing').hide();
					$page1tit.addClass('zoomIn' + ' animated').hide();
					$page1join.addClass('fadeInLeft' + ' animated2').hide(); 
					$page1cloud.addClass('fadeIn' + ' animated3').hide();
					// $page1lantern3.addClass('fadeIn' + ' animated2').removeClass('swing2').hide();
				break;
				case 2:
					$(".page3 .box").addClass('bounceIn').hide();
					$(".page3 .box").removeClass('ani-box').hide();
				break;
				case 3:
					$(".page4 .theTwoWrap-text").addClass('theTwoWrap-left').hide();
					$(".page4 .theTwoWrap-img").addClass('theTwoWrap-right').hide();
				break;
				case 4:
					$(".page5 .theTwoWrap-text").addClass('theTwoWrap-left').hide();
					$(".page5 .theTwoWrap-img").addClass('theTwoWrap-right').hide();
				break;
				case 5:
					$(".page6 .theTwoWrap-text").addClass('theTwoWrap-left').hide();
					$(".page6 .theTwoWrap-img").addClass('theTwoWrap-right').hide();
				break;
				case 6:
					$(".page7 .page7-img1").addClass('theTwoWrap-right'+" animate0").hide();
					$(".page7 .page7-img2").addClass('theTwoWrap-left'+" animate1").hide();
					$(".page7 .page7-img3").addClass('theTwoWrap-right'+" animate2").hide();
					$(".page7 .page7-img4").addClass('theTwoWrap-left'+" animate3").hide();
				break;
				case 7:
					// $page8plum2.addClass('fadeInRight'+' animated').hide();
					$page8tit2.addClass('zoomIn'+' animated').hide();
					$page8content.addClass('fadeInRight'+' animated').hide();
					$page8submit.addClass('fadeInUpBig'+' animated2').hide(); 
				break;
			}
		},
		enter:function(a){
			switch(a){
				case 0: 
					// $page1lantern.show();
					// $page1lantern2.show();
					// $page1plum.show().on(animationEnd, function() {
						// $page1lantern.addClass('swing').removeClass('animated2 fadeInRight');
						// $page1lantern2.addClass('swing').removeClass('animated2 fadeInRight');
						$page1tit.show().on(animationEnd, function() {
							// $page1lantern3.addClass('swing2').removeClass('animated2 fadeIn');
							$page1join.show();
							$page1cloud.show();
							if(flower1){
								// leaveinit('cti_page1_flower');
								flower1=false;
							}
						});
					// });
				break;
				case 2:
					 $(".page3 .box").show().on(animationEnd,function() { 
						$(".page3 .box").removeClass('bounceIn').addClass('ani-box');
					 });
				break;
				case 3:
					 $(".page4 .theTwoWrap-text").show().on(animationEnd,function() { 
						$(".page4 .theTwoWrap-img").show();
					 });
				break;
				case 4:
				 $(".page5 .theTwoWrap-text").show().on(animationEnd,function() { 
					$(".page5 .theTwoWrap-img").show();
				 });
				break;
				case 5:
				 $(".page6 .theTwoWrap-text").show().on(animationEnd,function() { 
					$(".page6 .theTwoWrap-img").show();
				 });
				break;
				case 6:
				 // $(".page7 .page7-img1").show().on(animationEnd,function() { 
					// $(".page7 .page7-img2").show().on(animationEnd,function() { 
					// 	$(".page7 .page7-img3").show().on(animationEnd,function() { 
					// 		$(".page7 .page7-img4").show()
					// 	 });
					//  });
				 // });
					$(".page7 .page7-img1").show();
					$(".page7 .page7-img2").show();
					$(".page7 .page7-img3").show();
					$(".page7 .page7-img4").show();
				break;
				case 7:
					$page8tit2.show().on(animationEnd, function() { 
						$page8content.show();
						$page8submit.show(); 
						if(flower2){ 
							// leaveinit2('cti_page8_flower');
							flower2=false;
						}
					});  
				break; 
			}
		}
	}       
	 
	//主框架
	var mainSwiper = new Swiper('.main-container', {
		direction : 'vertical',
		pagination : '.main-pagination', 
		// noSwiping : true,
		onInit: function(swiper){
			var i = swiper.activeIndex; 
				pageModes.enter(i); 
		},
		onSlideChangeStart: function(swiper) {
			//调用事件处理相应方法 
			var i = swiper.activeIndex;
			pageModes.init(i); 
		},
		onSlideChangeEnd : function(swiper){
			var i = swiper.activeIndex;
			pageModes.init(i-1);
			pageModes.enter(i);
			if (i == $(".main-container .swiper-slide").length-1) {
				$('.bottom').hide()
			}else{
				$('.bottom').fadeIn()
			}
		}   
	})
	//点击参与报名
	$('.join,.cloud').on('touchstart',function(e){
		e.preventDefault();  
		mainSwiper.slideTo(1,1000);
	})  
	//弹出地图
	$('.plan').on('touchstart',function(){ 
		$('.map-wrap').fadeIn(300);
	})
	//关闭地图
	$('.close').on('touchstart',function(){ 
		$('.map-wrap').fadeOut(300);
	})
	//关闭弹窗
	$('.popup').on('touchstart',function(){ 
		$('.popup').fadeOut(1000);
	})
	//预约试驾表单验证提交
	var _able = false;
	checkurl();   
	myBrowser();
	musicPlay();
	wx.config({
      // 配置信息, 即使不正确也能使用 wx.ready
      debug: false,
      appId: '',
      timestamp: 1,
      nonceStr: '',
      signature: '',
      jsApiList: []
    });
    wx.ready(function() {
		musicPlay();
    });
}) 	
//音频
var audio = document.createElement("audio");
function musicPlay(){ 
	audio.src = "audio/bgm.mp3";
	audio.load();
	audio.loop = true;
	audio.addEventListener("canplaythrough", function(){
		setTimeout(function(){
			audio.play(); 
		},100)
		
	},false);
	$("body").append(audio);
}  
var _first = true;
var vv = true;//音频
$("#audio_btn").click(function(){ 
	if(vv){
		audio.pause(); 
		$('#audio_btn').removeClass('rotate');
		$('#audio_btn .audio').attr('src','img/music1.png');
		vv = false; 
	}else{    
		audio.play(); 
		$('#audio_btn').addClass('rotate');
		$('#audio_btn .audio').attr('src','img/music.png');
		vv = true;  
	} 
})
//判断浏览器
var ad=0;
function myBrowser(){
     var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串  
	 if (userAgent.indexOf("Safari") > -1) {
		vv = false;  
		$('body').on('touchstart',function(){
			if(ad==0){
				audio.play(); 
				vv = true;
				ad=1;
			}
		})
     }
} 