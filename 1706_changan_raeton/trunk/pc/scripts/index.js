//右导航
var $navspan = $('.pagination span');
var baseurl = 'php/';
//////////////////////////////////////////////////以下为预加载////////////////////////////////////////////////// 
// 预加载
$(function(){
	preLoadImg();
	initDriveplugin();
	$('.footer').css({'margin-top':$(window).height()}) 
	$('.backtop').on('click',function(){
		$('.footer').fadeOut();
		mySwiper.swipeTo(0);
	})
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
			swiperInit();
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
                ,naturalW    = _t.data('natW')
                ,naturalH    = _t.data('natH')
                ,natQuotient = 1920/1080//naturalW/naturalH
                ,winQuotient = WinW/WinH;
            if(winQuotient > natQuotient){
                //屏幕宽高比大于img宽高比
                _t.css({'width':WinW,'height':WinW / natQuotient }); 
                var fixTop = Math.round( WinH - _t.height() >> 1);
                _t.css({'top' : fixTop, 'left' : 0}); 
				$('.d-slide1 .d-bg').css({'top' : fixTop*1.5, 'left' : 0}); 
                // _t.css({'top' : fixTop, 'left' : 0}); 
            }else if(winQuotient < natQuotient){
                _t.css({'width':WinH * natQuotient,'height': WinH}); 
                var fixLeft = Math.round( WinW - _t.width() >> 1);
                _t.css({'left' : fixLeft, 'top' : 0}); 
            }else{
                _t.css({'width':WinW ,'height': WinH, 'left' : 0, 'top' : 0}); 
            } 
        }); 
        var fixLeft = Math.round( WinW - $pageStages.eq(1).width() >> 1); 

    }
    $(window).on('resize', function() {
        fixWinHW();
        fixPageHeight();
        fixPageBg();
		$('.footer').css({'margin-top':$(window).height()})
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
		judge();
    });
	 $(".h-sel_wrap").on("change", function() {
        var opt = $(this).find('input');
        $(this).find('label').html(opt.val());
    }); 
	//第四屏发动机切换
	$('.d-motor div').on('click',function(){
		var _index = $(this).index();
		$(this).addClass('active').siblings('div').removeClass('active');
		$('.d-motor-txt').eq(_index).addClass('active').siblings('.d-motor-txt').removeClass('active');
		$('.d-motor-pic img').eq(_index).addClass('active').siblings('img').removeClass('active');
	})
})
function judge(){
	/*
	var umobileval = $('#umobile').val();
	if($('#uname').val() !== '' && $('#dealer').siblings('label').text()!==''&&umobileval.length == 11){
		$('.submit').css({'background':'#04a74b'})
	}else{
		$('.submit').css({'background':'#3a3a3a'}) 
	}*/
}


//此变量用来存储判断动画是否停止的数据
var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend"; 
//////////////////////////////////////////////////以下为模块内容//////////////////////////////////////////////////
var pageModes={
	init:function(a){
		switch(a){
			case 0: 
				// $('.d-slide1 .d-logo').removeClass('bounceInLeft' + ' animated').hide(); 
				$('.d-slide1 .d-tip').removeClass('bounceInRight'+' animated').hide();
			break;   
			case 1: 
				// $('.d-slide2 .d-logo').removeClass('bounceInLeft' + ' animated').hide(); 
				$('.d-slide2 .d-tit-wrap').removeClass('bounceInRight' + ' animated').hide();
                $('.d-slide2 .d-bg').removeClass('zoomInBig'+' animated').show(); 
				$('.d-slide2 .d-tip').removeClass('bounceInRight'+' animated').hide();				
				$('.d-slide2 .d-tit').removeClass('bounceInRight'+' animated').hide();				
            break; 
			case 2: 
				// $('.d-slide3 .d-logo').removeClass('bounceInLeft' + ' animated').hide(); 
				$('.d-slide3 .d-tit-wrap.d-top').removeClass('bounceInLeft' + ' animated').hide();
				$('.d-slide3 .d-tit-wrap.d-bottom').removeClass('bounceInRight' + ' animated').hide();
                $('.d-slide3 .d-bg').removeClass('zoomInBig'+' animated').show(); 	
				$('.d-slide3 .d-tip').removeClass('bounceInRight'+' animated').hide();				
            break; 
			case 3: 
				// $('.d-slide4 .d-logo').removeClass('bounceInLeft' + ' animated').hide(); 
				$('.d-slide4 .d-tit-wrap.d-top').removeClass('bounceInLeft' + ' animated').hide();
				$('.d-slide4 .d-tit-wrap.d-bottom').removeClass('bounceInRight' + ' animated').hide();
                $('.d-slide4 .d-bg').removeClass('zoomInBig'+' animated').show(); 	
				$('.d-slide4 .d-tip').removeClass('bounceInRight'+' animated').hide();			 		
				$('.d-slide4 .d-motor-box').removeClass('bounceInRight'+' animated').hide();				
            break; 
		}
	},
	enter:function(a){
		switch(a){
			case 0: 
				// $('.d-slide1 .d-logo').addClass('bounceInLeft' + ' animated').show(); 
				$('.d-slide1 .d-tip').addClass('bounceInRight'+' animated').show();
			break;   
			case 1: 
				// $('.d-slide2 .d-logo').addClass('bounceInLeft' + ' animated').show(); 
				$('.d-slide2 .d-tit-wrap').addClass('bounceInRight' + ' animated').show();
                $('.d-slide2 .d-bg').addClass('zoomInBig'+' animated').show(); 
				$('.d-slide2 .d-tip').addClass('bounceInRight'+' animated').show();	
				$('.d-slide2 .d-tit').addClass('bounceInRight'+' animated').show();					
            break; 
			case 2: 
				// $('.d-slide3 .d-logo').addClass('bounceInLeft' + ' animated').show(); 
				$('.d-slide3 .d-tit-wrap.d-top').addClass('bounceInLeft' + ' animated').show();
				$('.d-slide3 .d-tit-wrap.d-bottom').addClass('bounceInRight' + ' animated').show();
                $('.d-slide3 .d-bg').addClass('zoomInBig'+' animated').show();
				$('.d-slide3 .d-tip').addClass('bounceInRight'+' animated').show();				
            break; 
			case 3: 
				// $('.d-slide4 .d-logo').addClass('bounceInLeft' + ' animated').show(); 
				$('.d-slide4 .d-tit-wrap.d-top').addClass('bounceInLeft' + ' animated').show();
				$('.d-slide4 .d-tit-wrap.d-bottom').addClass('bounceInRight' + ' animated').show();
                $('.d-slide4 .d-bg').addClass('zoomInBig'+' animated').show(); 		
				$('.d-slide4 .d-tip').addClass('bounceInRight'+' animated').show();					
				$('.d-slide4 .d-motor-box').addClass('bounceInRight'+' animated').show();	 				
            break; 
			 
		}
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
		// noSwipingClass : 'swiper-no-swiping',
		onSwiperCreated: function(swiper){
			//执行检查url   
			checkurl(swiper); 
		},
		onFirstInit: function(swiper){  
			var i = swiper.activeIndex; 
			pageModes.init(i); 
			// $('.d-slide1 .d-logo').addClass('bounceInLeft' + ' animated').show(); 
			$('.d-slide1 .d-tip').addClass('bounceInRight'+' animated').show();
		},
		onSlideChangeStart:function(swiper){ 
			$('.livebox').hide();
		},
		onSlideChangeEnd:function(swiper){
			var i = swiper.activeIndex;  
			pageModes.init(i-1);
			pageModes.init(i+1);
			pageModes.enter(i);
			if(i==3){ 
				mySwiper.disableMousewheelControl(); 
				$('body').css({'overflow-y':'auto'})
				$('.footer').fadeIn()
			}else{
				mySwiper.enableMousewheelControl(); 
				$('.footer').fadeOut() 
			}
		}
	}) 
	/*向下滑动*/
	$('.d-scrollDown').on('click',function (){
		mySwiper.swipeNext()
	})
}
var windowTop=0;
$(window).scroll(function(){
	var dd= $(window).scrollTop();
	windowTop=dd;
	if(windowTop==0){
		$('.d-scrollDown').fadeIn();
	}else{
		$('.d-scrollDown').fadeOut();
	}
}) 
$(document).mousewheel(function(event, delta) {  
	if(delta>0 && windowTop==0){
		mySwiper.enableMousewheelControl(); 
		$('body').css({'overflow-y':'hidden'})
		$('.footer').fadeOut()
	}
}); 
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
//placeholder
$(".h-input_cti").on("input", function() {
	 judge();
})
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
	 judge()
});
var testdrivetime = true;
//关联CRM的试驾
// 表单提交
function initDriveplugin() {
	linmaxConfig = {
			ctiurl: baseurl,
			cartype: 'jc_',
			aid: '326',
			op: 'try',
			carname: '睿骋',
			carcode: 'CD101',
			from_source: 'PC',
			provinceText: '省份',
			cityText: '城市',
			townText: '地区',
			dealerText: '选择经销商',
			carcodeText: '睿骋',
			debug: 0, //1：不发到长安服务器，只发送到测服 0：发到长安服务器+测服
			hasRaffle: false,
			dtimeEle: $("#dtime"),
			otimeEle: '',
			carcodeEle: '',
			loadprovincechange: function(e) {
				//e.prev("label").html(this.provinceText);
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
				this.cityEle.prev("label").text('');
				this.cityEle.prev("span").show();
				this.townEle.prev("label").html(this.townText);
				this.townEle.prev("label").text('');
				this.townEle.prev("span").show();
				this.dealerEle.prev("label").html(this.dealerText);
				this.dealerEle.prev("label").text('');
				this.dealerEle.prev("span").show();
			},
			citychange: function(e) {
				e.prev("label").html(e.find("option").not(function() {
					return !this.selected
				}).text());
				this.townEle.prev("label").html(this.townText);
				this.townEle.prev("label").text('');
				this.townEle.prev("span").show();
				this.dealerEle.prev("label").html(this.dealerText);
				this.dealerEle.prev("label").text('');
				this.dealerEle.prev("span").show();
			},
			townchange: function(e) {
				e.prev("label").html(e.find("option").not(function() {
					return !this.selected
				}).text());
				this.dealerEle.prev("label").html(this.dealerText);
				this.dealerEle.prev("label").text('');
				this.dealerEle.prev("span").show();
			},
			dealerchange: function(e) {
				e.prev("label").html(e.find("option:selected").text());
			},
			reload: function() {
				// 重置表单====
				this.unameEle.val('姓名');
				this.umobileEle.val('手机号码');
				this.dtimeEle.val('试驾时间');
				this.dtimeEle.prev('label').text('试驾时间');
				this.provinceEle.val('0').prev("label").html(this.provinceText);
				this.cityEle.val('0').html("<option value=0>" + this.cityText + "</option>");
				this.dealerEle.val('0').html("<option value=0>" + this.dealerText + "</option>");
				$('.float-select span').show();
				$('.float-select input').val('');
				$('.h-sel_wrap label').text('');
				$('.h-sel_wrap span').show(); 
			},
			submitdrive: function(e) {
				this.reload();
			}
		}
		//实例化试驾插件
	linmaxDrive = new Testdrive(linmaxConfig);
	linmaxDrive.init();
}
 