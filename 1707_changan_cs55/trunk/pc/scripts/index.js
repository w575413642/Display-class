var baseurl = 'php/';
//右导航
var $navspan = $('.pagination span');
var currNav = 'home'; 
//////////////////////////////////////////////////以下为预加载////////////////////////////////////////////////// 
// 预加载
$(function(){ 
	$(".nav-item").click(function(){
		swipeTo($(this).attr("data-index"));
	});
	$(".nav-item:first").addClass("act");
	swiperInit();
	$('.d-fish-img').hide();
	$('.live_player,.live-container_box_danmu').show();

	//initLive();
	//$(".bjy-send-message").removeAttr('disabled');
	$(".tools_live,.d-num,.zanlayout").show();
	//testdrive();
	initDriveplugin(); 
	$('.d-red-blue .d-bg').attr({'src':'pc/images/bg_red_blue.gif'}); 
}); 
var imgNum = 0;
var images = []; 
function preLoadImg() {
    var imgs = document.images;
    // console.log(imgs);
    for (var i = 0; i < 100; i++) {
        var src = $(imgs[i]).attr("src");
        if (src != undefined && src != "") {
            images.push(src);
        }
    }
    // console.log(images);
    $.imgpreload(images, {
        each: function() {
                var v = (parseFloat(++imgNum) / images.length).toFixed(2);
                $(".loading-num").html(Math.round(v * 100));
        },
        all: function() {
            // scale();
            $("#percentShow ").html("100<sup>%</sup>");
            $('.loadings').fadeOut(); 
        }
    });
} 

//预加载结束
$(function(){
    //变量定义区域
    var WinH            = $(window).height()
        ,WinW           = $(window).width()
        ,$pages         = $('.swiper-slide') //屏幕
        ,$pageStages    = $('.d-bg') //各个屏幕的舞台（绘图区域） 
        ;
    //重置全局变量
    var fixWinHW = function(){
        WinH = $(window).height();
        WinW = $(window).width();
    }
    //自适应每一屏幕的高度
    var fixPageHeight = function(){
        $pages.height(WinH);
        // alert(WinH);
    }
    //自适应每一屏幕的舞台
    var fixPageBg = function(){
        $pageStages.each(function(){
            var _t           = $(this)
                ,_t2    = $('.d-bg2')
                ,naturalW    = _t.data('natW')
                ,naturalH    = _t.data('natH')
                ,natQuotient = 1920/1080//naturalW/naturalH
                ,winQuotient = WinW/WinH;
            if(winQuotient > natQuotient){
                //屏幕宽高比大于img宽高比
                _t.css({'width':WinW,'height':WinW / natQuotient }); 
                _t2.css({'width':WinW,'height':WinW / natQuotient }); 
                var fixTop = Math.round( WinH - _t.height() >> 1);
                // _t.css({'top' : fixTop*1.8, 'left' : 0}); 
                // _t.css({'top' : fixTop, 'left' : 0}); 
                _t.css({'top' : fixTop, 'left' : 0}); 
                _t2.css({'top' : 0, 'left' : 0}); 
                 // _t.css({'top' : 0, 'left' : 0}); 
            }else if(winQuotient < natQuotient){
                _t.css({'width':WinH * natQuotient,'height': WinH}); 
                _t2.css({'width':WinH * natQuotient,'height': WinH}); 
                var fixLeft = Math.round( WinW - _t.width() >> 1);
                _t.css({'left' : fixLeft, 'top' : 0}); 
                _t2.css({'left' : fixLeft, 'top' : 0}); 
            }else{
                _t.css({'width':WinW ,'height': WinH, 'left' : 0, 'top' : 0}); 
                _t2.css({'width':WinW ,'height': WinH, 'left' : 0, 'top' : 0}); 
            } 
        }); 
        var fixLeft = Math.round( WinW - $pageStages.eq(1).width() >> 1); 

    }
    $(window).on('resize', function() {
        fixWinHW();
        fixPageHeight();
        fixPageBg();
    }).resize();
	fixWinHW();
    fixPageHeight();
    fixPageBg();
	/*预约试驾*/
	$(".h-sel_wrap").on("change", function() {
        var o;
        var opt = $(this).find('option');
        opt.each(function(i) {
            if (opt[i].selected == true) {
                o = opt[i].innerHTML;
            }
        })
       $(this).find('span').hide();
        $(this).find('label').html(o); 
    });
	 $(".h-sel_wrap").on("change", function() {
        var opt = $(this).find('input');
        $(this).find('label').html(opt.val());
    }); 
	$(".h-input_cti").focus(function(){
		 _v = $(this).val(); 
		 if(_v==''){ 
			$(this).prev('span').hide(); 
		 }
	}).blur(function(){
		 _v = $(this).val(); 
		 if(_v==''){ 
			$(this).prev('span').show(); 
		 }
	});
})

//此变量用来存储判断动画是否停止的数据
var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend"; 
//////////////////////////////////////////////////以下为模块内容//////////////////////////////////////////////////
var pageModes={
	init:function(a){
		switch(a){
			case 0: 
				$('.d-logo').hide(); 
				$('.d-kv .d-txt').hide();
			break;  
			case 2: 
				$('.d-price .d-txt').removeClass('d-light').hide();
				$('.d-price .d-price-box').removeClass('bounceInUp'+' animated animated2').hide();				
            break; 
			case 3: 
				// $('.d-live .d-txt').removeClass('d-light').hide();
				if(!isLiveing){}else{changeVolume(0);}
				$('.toolbar-voice').attr({'data-val':'close','src':'pc/live_plugin/images/icon-voice2.png'});
            break; 
			case 4: 
				// $('.d-fish .d-txt').removeClass('d-light').hide();
                // $('.d-fish .live-container').removeClass('fadeInUp'+' animated animated2').hide(); 	
				$('#fish-box').attr({'src':''});					
            break; 
			case 1: 
				$('.d-red-blue .d-txt').removeClass(' d-light').hide(); 
                $('.d-red-blue .d-car').hide();
				
            break; 
			case 5: 
				$('.d-exterior .d-txt').removeClass('fadeInUp' + ' animated').hide();
                $('.d-exterior .d-car').removeClass('fadeInLeft'+' animated animated2').hide();			
            break; 
			case 6: 
				$('.d-interior .d-txt').removeClass('fadeInUp' + ' animated').hide();			
            break;  
			case 7: 
				$('.d-comfortable .d-txt').removeClass('fadeInRight' + ' animated').hide(); 		
            break;  
			case 8: 
				$('.d-safety .d-txt').removeClass('fadeInRight' + ' animated animated2').hide(); 		
				$('.d-safety .d-car').removeClass('leftCenter' + ' animated').hide(); 		
            break;  
			case 9: 
				$('.d-power .d-txt').removeClass('fadeInLeft' + ' animated animated2').hide(); 		
				$('.d-power .d-car').removeClass('rightBottom' + ' animated').hide(); 		
            break;  
			case 10:  
				$('.d-news .d-txt').removeClass('d-light').hide(); 		
				$('.d-news .d-news-wrap').removeClass('zoomIn' + ' animated animated2').hide(); 		
            break;  
			case 11:  
				$('.d-message .d-txt').removeClass('d-light').hide(); 		
				$('.d-message .message-box').removeClass('fadeInUp' + ' animated animated2').hide();  
            break; 
			case 12:  
				$('.d-testdrive .d-txt').removeClass('d-light').hide(); 		
				$('.d-testdrive .main-box').removeClass('fadeInUp' + ' animated animated2').hide(); 		
				$('.d-testdrive .footer').removeClass('fadeInUp' + ' animated animated4').hide(); 		
            break;   
		}
	},
	enter:function(a){
		switch(a){
			case 0:
				currNav = 'home'; 
				$('.d-logo').addClass('bounceInRight' + ' animated').show(); 
				$('.d-kv .d-txt').addClass('bounceRightBottom'+' animated animated2').show();
				//$('.d-slide1 .d-tip').addClass('bounceInLeft'+' animated').show();
			break;  
			case 2: 
				currNav = 'price';
				$('.d-price .d-txt').show('slow',function(){
					setTimeout(function(){
						$('.d-price .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});			
				$('.d-price .d-price-box').addClass('bounceInUp' + ' animated animated2').show();			
            break; 
			case 3: 
				currNav = 'live';
				$('.d-live .d-txt').show('slow',function(){
					setTimeout(function(){
						$('.d-live .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});	
                $('.d-live .live-container').addClass('zoomIn'+' animated animated2').show();		
				$(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' }); 
				if(!isLiveing){}else{changeVolume(parseInt($("#slider").slider("value")));}
				$('.toolbar-voice').attr({'data-val':'open','src':'pc/live_plugin/images/icon-voice.png'});
            break; 
			case 4: 
				currNav = 'fish';
				$('.d-fish .d-txt').show('slow',function(){
					setTimeout(function(){
						$('.d-fish .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});	
                $('.d-fish .live-container').addClass('fadeInUp'+' animated animated2').show();	
				$('#fish-box').attr({'src':'pc/woman.html'}).show();					
            break; 
			case 1: 
				currNav = 'home';
				$('.d-red-blue .d-txt.animated2').show('slow',function(){
					setTimeout(function(){
						$('.d-red-blue .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});
				$('.d-red-blue .d-txt').show() 
                $('.d-red-blue .d-car').show(); 				
            break; 
			case 5: 
				currNav = 'car';
				$('.d-exterior .d-txt').addClass('fadeInUp' + ' animated').show();
                $('.d-exterior .d-car').addClass('fadeInLeft'+' animated animated2').show(); 		
				creat360('red',36);
            break;  
			case 6: 
				currNav = 'car';
				$('.d-interior .d-txt').addClass('fadeInUp' + ' animated').show();				
            break;  
			case 7: 
				currNav = 'point';
				$('.d-comfortable .d-txt').addClass('fadeInRight' + ' animated').show(); 		
            break; 
			case 8: 
				currNav = 'point';
				$('.d-safety .d-txt').addClass('fadeInRight' + ' animated animated2').show(); 		
				$('.d-safety .d-car').addClass('leftCenter' + ' animated').show(); 		
            break;  
			case 9: 
				currNav = 'point';
				$('.d-power .d-txt').addClass('fadeInLeft' + ' animated animated2').show(); 		
				$('.d-power .d-car').addClass('rightBottom' + ' animated').show(); 		
            break; 
			case 10: 
				currNav = 'news';
				$('.d-news .d-txt').show('slow',function(){
					setTimeout(function(){
						$('.d-news .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});	
				$('.d-news .d-news-wrap').addClass('zoomIn' + ' animated animated2').show(); 		
				newsSwiper.reInit();
            break;  
			case 11: 
				currNav = 'message';
				$('.d-message .d-txt').show('slow',function(){
					setTimeout(function(){
						$('.d-message .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});		
				$('.d-message .message-box').addClass('fadeInUp' + ' animated animated2').show(); 
				$(".nano").nanoScroller({ scroll: 'top' }); 				
            break; 
			case 12: 
				currNav = 'testdrive';
				$('.d-testdrive .d-txt').show('slow',function(){
					setTimeout(function(){
						$('.d-testdrive .d-txt').eq(1).addClass(' d-light').show();
					},1000)
				});		
				$('.d-testdrive .main-box').addClass('fadeInUp' + ' animated animated2').show(); 		
				$('.d-testdrive .footer').addClass('fadeInUp' + ' animated animated4').show(); 		
            break; 
		}
		$(".nav-item").removeClass("act");
		$(".nav-item."+currNav).addClass("act");
		$(".nav-item."+currNav).find("span").fadeIn();
	}
} 
//引用第三方滚动框架，当前对象为全局的滚动对象可从里面获取相应的api，具体说明请访问 http://www.swiper.com.cn 查看相关api文档
function swiperInit(){
	window.mySwiper = new Swiper('.main-container',{
		//pagination: '.pagination',
		paginationClickable: true,
		mousewheelControl: true,
		mode: 'vertical', 
        simulateTouch: false,
        speed:900,
        //禁止手指拖动   swiper-no-swiping
        noSwiping: true,
		onSwiperCreated: function(swiper){
			//执行检查url   
			checkurl(swiper); 
		},
		onFirstInit: function(swiper){  
			var i = swiper.activeIndex;  
			// pageModes.init(i);  
			var  carii = true;
			if(carii){
				creat360('red',36);
				carii=false;
			}
		},
		onSlideChangeStart:function(swiper){ 
			$('.livebox').hide();
			$('#myVideo').hide();
			$('.video-mask').hide();
			myPlayer.pause();
			myPlayer2.pause();
			$(".d-poster,.d-player-icon").show();
		},
		onSlideChangeEnd:function(swiper){
			var i = swiper.activeIndex;  
			pageModes.init(i-1);
			pageModes.init(i+1);
			pageModes.enter(i);
		}
	})
	window.newsSwiper = new Swiper('.news-container',{
		//pagination: '.pagination',
		paginationClickable: true,  
		calculateHeight : true,
		pagination : '.pagination',
		paginationClickable :true,
		roundLengths : true,
        speed:900
	})
	$('.d-news .d-arrowL').click(function(){
		newsSwiper.swipePrev(); 
	})
	$('.d-news .d-arrowR').click(function(){
		newsSwiper.swipeNext(); 
	})
}

//判断url进行跳转页面
function checkurl(swiper){
   var i = window.location.hash.replace("#page","");
   var ii = $.trim(i);
   // var i = window.location.hash = hash.replace(/#/g, '');
   swiper.swipeTo(ii,100);
   pageModes.enter(i);
   // console.log(i);
};
 
////////////////////////////////////////////////// ////////////////////////////////////////////////// 
//当全局滑块滑动的时候触发当前事件
//跳转屏幕   
function swipeTo(i) {
	mySwiper.swipeTo(i);  
};   
var testdrivetime = true; 

//关联CRM的试驾
// 表单提交
function initDriveplugin() {
	cs55Config = {
			ctiurl: baseurl,
			cartype: 'jc_',
			aid: '342',
			op: 'try',
			carname: 'CS55',
			carcode: 'S201',
			from_source: 'PC',
			provinceText: '省份',
			cityText: '城市',
			townText: '地区',
			dealerText: '选择经销商',
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
				this.unameEle.val('姓名').hide().siblings('span').show();
				this.umobileEle.val('手机号码').hide().siblings('span').show();
				this.dtimeEle.val('试驾时间');
				this.dtimeEle.prev('label').text('试驾时间');
				this.provinceEle.val('0').siblings("label").html(this.provinceText).hide().siblings('span').show();
				this.cityEle.val('0').html("<option value=0>" + this.cityText + "</option>").siblings("label").html(this.cityText).hide().siblings('span').show();
				this.townEle.val('0').html("<option value=0>" + this.cityText + "</option>").siblings("label").html(this.cityText).hide().siblings('span').show();
				this.dealerEle.val('0').html("<option value=0>" + this.dealerText + "</option>").siblings("label").html(this.dealerText).hide().siblings('span').show();
			},
			submitdrive: function(e) {
				this.reload();
			}
		}
		//实例化试驾插件
	cs55Drive = new Testdrive(cs55Config);
	cs55Drive.init();
}
// **********************360js开始********************************
var carframesS=1100/619;
// 初始化360
function creat360(cartype,num) {
	var imgW = $(window).width()*0.58;
	var imgS = 1100/619;
	var imgH = imgW / imgS;
	$(".d-carframes").height(imgH);
	var initframe = 26;
	// 角度控件
	var pot = $('#d_page1_rulerpot');
	var start360 = function(carname, num, w, h, initnum) {
		var frames = SpriteSpin.sourceArray('pc/images/exterior/' + carname + '/{frame}.png', {
			frame: [1, num],
			digits: 1  
		});
		$('#carframes').spritespin({
			renderer: 'image',
			width: w,
			height: h,
			frame: initnum,
			frames: num, //图片数
			animate: false, //初始是否动作
			loop: false, //是否循环
			reverse:true,
			sense: -1, // 手势反向
			onLoad: function() {
				var api = $('#carframes').spritespin('api'); 
			},
			onFrame: function(e, data) { 
				initframe = data.frame;
			},
			onInit: function() {
				$(".index-loading").find('em').html("0");
				$(".index-loading").show();
				$(".car-360-loading").show();
			},
			onProgress: function(e, data) {
				if(data.percent >= 100) {
					$(".index-loading").hide();
					$(".car-360-loading").hide();
				};
				$(".index-loading").find('em').html(data.percent);
				// $('#d_preload_txt_out').html(data.percent + '%');
			},
			source: frames
		});
		newSpin1data = $('#carframes').data('spritespin');
	}
	start360(cartype, num, imgW, imgH, initframe); 
}
$(window).resize(function() {
	$('.d-carframes').css({'height':$(window).width()*0.58/carframesS}); 
	//var sizeS=16/9;
	//$('.live-container_box object').height($('.live-container_box').height()*sizeS);
	//var videoS = 16/9;
    //pageW = $(window).width()*.8;     
	//$('.live_player').height(pageW/videoS-40);
	//console.log(pageW/videoS)
}).resize()
$('.d-btn-item div').click(function(){
	var color = $(this).attr('data-color');
	creat360(color,36);
}) 
// **********************360js结束******************************** 
//播放器尺寸
var size = 800/400;
var Vsize = 1344/605;
//播放器宽度
var width = $(window).width() * .6;
//播放器高度
var height = width/size;
var Vheight = width/Vsize;
$('.live-container').height(height); 
$('.d-fish-box,.video-mask').height(Vheight); 
$('.d-time').downCount({
	date: '07/26/2017 20:00:00',
	offset: +8
}, function () {
	$('.d-time').hide();
	
});
$('.nano-content').hover(function(){
	mySwiper.disableMousewheelControl(); 
},function(){
	mySwiper.enableMousewheelControl(); 
})
$('.moni').on('click', function() {
	$('.d-qrcode').slideToggle();
})
var isBarOpen = 0; 
//官网视频
var guanwangVideo = 0;
var myPlayer = videojs('myVideo');
$(".d-live .d-player-icon").click(function(event) { 
	if(guanwangVideo == $(this).attr('data-link')){
		setTimeout(function(){
			myPlayer.play();
		},1500);
	}else{
		myPlayer.src([
        { type: "video/mp4", src: "pc/video/video_pc.mp4" }
    	]);
		$('#myVideo').show().css({'height':$('.live-container_box').height()-50+'px'});
		myPlayer.poster('pc/images/poster.jpg');
	    $(".d-poster,.d-player-icon").fadeOut();
		setTimeout(function(){
			myPlayer.play();
		},1500);
	}
});
//斗鱼视频
var douyuVideo;
var myPlayer2 = videojs('myVideo2');
$(".d-fish .d-player-icon,.d-btn-switch").click(function(event) {  
	var  vlink = $(this).attr('data-link'); 
	if(douyuVideo == vlink){
		setTimeout(function(){
			myPlayer2.play();
		},1500);
	}else{
		myPlayer2.src([
			{ type: "video/mp4", src: "pc/video/"+vlink }
		]);
		setTimeout(function(){
			myPlayer2.play();
		},1500);
		douyuVideo = vlink;
	} 
	myPlayer.poster('pc/images/poster.jpg');	
	$('.video-mask').show();
});
var lock = false;
$('.vjs-fullscreen-control').on('click',function(){
	$('#myVideo').toggleClass('video-box');
	$(this).blur()
	lock = true;
	return;
});
$(window).keydown(function(e){
	if(e.keyCode == 32 || e.keyCode == 13){
		e.preventDefault()	
		return false;
	}
}) 
$(window).keyup(function(e){
	if (lock) {
		if(e.keyCode == 27 ){
			//e.preventDe
			$('#myVideo').removeClass('video-box'); 
			lock = false
		}
	}
})