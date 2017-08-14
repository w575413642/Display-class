var vw,
	vh;
var swiperI=0;
var isForm=false;
// var isPlay=false;
// var testSlide = $(".swiper-test>.swiper-wrapper>.swiper-slide");
var pageSlide = $(".swiper-page>.swiper-wrapper>.swiper-slide");
var realPageSlidLen = pageSlide.length;
// 存储绑定在 swiper 上的navIndex 避免loop影响
var navIndexArr = [];
for (var i = 0; i < realPageSlidLen; i++) {
	pageSlide[i]
	navIndexArr.push(pageSlide.eq(i).attr("navIndex"))
}
var bgImg = $(".bgImg-center");
var cssDoChange = true;//body可以被设置css
$(window).resize(function() {
	vw = $(window).width()
	vh = $(window).height()
	// 旋转时 视频层提示
	// if (swiperI==3) {
	// 	controlGuan()
	// }
	// if (swiperI==4) {
	// 	controlDouyu()
	// }
	// 横竖屏切换
	// 如果竖屏
	if (vw<vh) {
		$(".rotate-container").addClass('show');
		// .box,
		$(".load-container").css({
			"width":vh,
			"height": vw,
			"marginTop":(vh-vw)/2,
			"marginLeft":(vw-vh)/2
		}).addClass('rotate90')
	}else{
	// 如果横屏
		$(".rotate-container").removeClass('show');
		// .box,
		$(".load-container").css({
			"width":vw,
			"height": vh,
			"marginTop":0,
			"marginLeft":0
		}).removeClass('rotate90')
		if (cssDoChange) {
			realHorCss()
		}
		// 尝试重置右侧导航
		if(typeof swiper_nav != 'undefined') {swiper_nav.init();}
	}
	// 如果是 表单 页面时
	if (swiperI && swiperI == 11) {
		//  1 横屏 宽度始终大于高度
		//  2 竖屏 不考虑
		// if (vw>vh) {
		// 	$(".box").css({
		// 		"width":1206,
		// 		"height":750,
		// 		"marginTop":-750*(1-vw/1206)/2,
		// 		"marginLeft":-1206*(1-vw/1206)/2,
		// 		"transform":"scale("+vw/1206+")"
		// 	})
		// 	$(".form").addClass('scaleSize')
		// }else{
		// 	$(".box").css({
		// 		"width":vh,
		// 		"height": vw,
		// 		"marginTop":(vh-vw)/2,
		// 		"marginLeft":(vw-vh)/2,
		// 		"transform":"rotate(90deg)"
		// 	})
		// 	$(".form").removeClass('scaleSize')
		// 	isForm=false;
		// 	// 键盘隐藏之后 仍会获取焦点 点击其他不会blur
		// 	// $(".form input").blur()
		// }
			// isForm=true;
		// }
	}
	if (vh>150) {
		$("#msginput").blur()
		isForm=false;
	}else{
		isForm=true;
	}
	// 弹幕列表 高度设置
}).resize();
function controlGuan () {
	$("#dy-video-player").show();
	$("#dy-video-player")[0].play()
	// if (vw<vh) {
	// 	if (!isPlay) {
	// 		$(".rotate-container").addClass('show');
	// 	}
	// 	// alert(1)
	// 	// teacherPlayer.playAVClose();
	// 	$("#website-live-play").show();
	// }else{
	// 	$(".live_player video").show();
	// 	// teacherPlayer.playAV(
	// 	// 	store.get('teacher.videoOn')
	// 	// );
	// 	// $(".live_player video").show();
	// }
}
function controlDouyu () {
	$("#website-live-play").show();
	// teacherPlayer.playAVClose();

	$("#dy-video-player")[0].play()
	// $(".live_player video").hide();
	// $(".live_player video")[0].pause()
	// if (vw<vh) {
	// 	if (!isPlay) {
	// 		$(".rotate-container").addClass('show');
	// 	}
	// 	$("#dy-video-player").hide();
	// 	$("#dy-video-player")[0].pause()
	// }else{
	// 	$("#dy-video-player").show();
	// 	$("#dy-video-player")[0].play()
	// }
}
// 横屏时的css 仅设置一次
function realHorCss () {
	//cssDoChange=false;
	$(".box").css({
		"width":vw,
		"height":vh,
		"marginTop":0,
		"marginLeft":0
	})
	for (var i = 0; i < bgImg.length; i++) {
		if (i!=0 && i!=6 && i!=11) {
			bgImg.eq(i).css("marginTop",-(bgImg.eq(i).height()-$(window).height())/2);
			bgImg.eq(i).one('load', function(event) {
				var _t = $(this);
				_t.css("marginTop",-(_t.height()-$(window).height())/2);
			});
		}
	} 
	setTimeout(function () {
		// $(".textList").height($("#website-live-play").outerHeight())
		$(".textList-content-container").height($(".textList").outerHeight()-$(".textList-title").outerHeight()-$(".textList-input-wrap").outerHeight())
	},300)
}	
$(window).load(function () {
	// play 状态切换 决定是否显示 提示旋转
	// $("#dy-video-player")[0].onpause = function () {
	// 	// isPlay = false;
	// }
	// $("#dy-video-player")[0].onplay = function () {
	// 	// isPlay = true;
	// }
	if (vw>vh) {
		// 设置一次body css
		realHorCss();
	}
	// 主体swiper
	var swiper_page = new Swiper(".swiper-page",{
		// calculateHeight:true,
		direction : 'vertical',
		followFinger:false,
		// loop : true,
		onSlideChangeStart:function(swiper){
			swiperI = swiper.realIndex;
			// 滑动后改变 swiperI值
			var navIndex = navIndexArr[swiperI];
			pageSlide.find(".animated").hide()
			pageSlide.find(".text-index1").hide()
			$(".carframes-wrap .rotateBtn").hide()
			if (navIndex) {
				$(".swiper-nav li.act").removeClass("act")
				$(".swiper-nav li").eq(navIndex).addClass("act")
				swiper_nav.slideTo(navIndex)
			}
			// 切换开始 负责 隐藏其它弹层 移除class
			if (swiperI==5) {
			// 360
				$(".popup").addClass('show');
				$("#vr-box").removeClass("show");
			}else if (swiperI==6) {
			// 内饰全景
				$(".popup").addClass('show');
				$(".carframes-wrap").removeClass("show");
			}else{
				$(".popup").removeClass('show');
				$(".carframes-wrap").removeClass("show");
				$("#vr-box").removeClass("show");
			}

			// 调整背景
			for (var i = 0; i < bgImg.length; i++) {
				if (i!=0 && i!=6 && i!=12) {
					bgImg.eq(i).css("marginTop",-(bgImg.eq(i).height()-$(window).height())/2);
				}
			} 
		},
		onSlideChangeEnd:function(swiper){
			pageSlide.eq(swiperI).find(".animated").show()
			pageSlide.eq(swiperI).find(".text-index1").show()
			$(".carframes-wrap .rotateBtn").show()
			if (swiperI== 5) {
				setTimeout(function () {
					$(".carframes-wrap .rotateBtn").fadeOut(function () {
						$(".carframes-wrap .rotateBtn").remove()
					});
				},4000)
			}
			// 切换结束 负责 显示对应弹层
			if (swiperI==5) {
			// 360
				$(".carframes-wrap").addClass('show');
			}else if (swiperI==6) {
			// 内饰全景
				$("#vr-box").addClass('show');
			}
			// 切换slide 视频提示层
			if (swiperI==3) {
				playlive();
			}
			if (swiperI==11) {
				$(".todown").hide()
			}else{
				$(".todown").show()
			}
		}
	});

	// 控制
	//************************ 右边导航swiper  ********************************
	window.swiper_nav = new Swiper(".swiper-nav",{
		direction : 'vertical',
		slidesPerView:6,
		initialSlide:0,
		nextButton:".half-right .down",
		prevButton:".half-right .top",
	});
	$(".right-nav .jump").click(function() {
		if (!isForm) {
			swiper_page.slideTo($(this).attr("pageIndex"))
			swiper_nav.slideTo($(this).index())
		}
		if ($(this).index() == 3) {
			$("#dy-video-player")[0].play()
		}
	});

	//************************ 直播js********************************
	$(".guanzhu .guanzhu-btn").click(function () {
		$(this).siblings(".qrcode").fadeToggle()
	})
	// 倒计时
	//initLive();
	downCount = true;
	//$(".bjy-send-message").removeAttr('disabled');
	//$(".tools_live,.d-num,.zanlayout").show();
	$('.d-time').hide();
	$('.d-time').downCount({
		date: '07/26/2017 20:00:00',
		offset: +8
	}, function () {
		// $('.d-time').hide();
		// $('.live_player,.live-container_box_danmu').show();
		//$(".live_player video").attr("controls","controls").addClass("show");
	});
	// 斗鱼直播
	var dySrc = "http://e.changan.com.cn/CS552017_4/php/index.php?c=live&roomid="
	$(".changeBtn.man").click(function() {
		getSrc("http://vodhls1.douyucdn.cn/live/normal_live-431972rXhxcv9Bk1--20170726202659/playlist.m3u8?k=1da9617d8114fa7ed6572e43b011cade&t=5979925c&u=0&ct=h5&vid=1074861&d=")
	});
	$(".changeBtn.wo").click(function() {
		getSrc("http://vodhls1.douyucdn.cn/live/normal_live-431972rXhxcv9Bk1--20170726182657/playlist.m3u8?k=c2ea93d7a2c80e20141660be2b78bfec&t=597994eb&u=0&ct=h5&vid=1074863&d=")
	});
	function getSrc(roomid) {
		/*$.ajax({
			url: dySrc+roomid,
			type: 'GET',
			dataType: 'jsonp',
			success:function (data) {
				// console.log(data)
				if (data.error == 0) {
				// console.log(data.data.hls_url)*/
					$("#dy-video-player").attr("src",roomid)
				/*}
			}
		})*/
	}
	getSrc("http://vodhls1.douyucdn.cn/live/normal_live-431972rXhxcv9Bk1--20170726182657/playlist.m3u8?k=c2ea93d7a2c80e20141660be2b78bfec&t=597994eb&u=0&ct=h5&vid=1074863&d=")
	//************************ 弹层按钮控制 ********************************
	// 弹层按钮控制
	$(".fixed-btn-wrap .popup-next").on('touchend', function(event) {
		swiper_page.slideNext()
	});
	$(".fixed-btn-wrap .popup-prev").on('touchend', function(event) {
		swiper_page.slidePrev()
	});
	// **********************360js开始********************************
	// 初始化360
	var initframe = 26;
	function creat360(cartype,num,w,h,sense,direction) {
		// 角度控件
		var frames = SpriteSpin.sourceArray('h5/images/exterior/' + cartype + '/{frame}.png', {
			frame: [1, num],
			digits: 1  
		});
		$('#carframes').spritespin({
			renderer: 'image',
			width: w,
			height: h,
			frame: initframe,
			frames: num, //图片数
			animate: false, //初始是否动作
			loop: false, //是否循环
			reverse:true,
			sense: sense, // 手势反向
		    orientation : direction, //
			onLoad: function() {
				var api = $('#carframes').spritespin('api'); 
				if (vw>vh) {
					var img360s = $(".carframes-wrap #carframes img");
					img360s.css("marginTop",(vh-img360s.height())/2)
				}
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
	var color = "red";
	$(window).resize(function() {
		// if(carii){
		// 	carii=false;
		// }else{
		// 	creat360('red',36);
		// }

		// 竖屏 
		reInit360(color)
	}).resize()
	$('.changeColorBtn-wrap .colorBtn').click(function(){
		$(this).addClass("act").siblings().removeClass('act');
		color = $(this).attr('data-color');
		reInit360(color)
	}) 
	function reInit360(color) {
		// 颜色 数量 宽度 高度 手势 屏幕方式
		if (vw<vh) {
			creat360(color,36,410,vh*0.9,1,"vertical");
		}else{
			creat360(color,36,vw*0.9*0.683,vh,-1,"horizontal");
		}
	}
	// **********************360js结束******************************** 
	
	var swiper_media = new Swiper(".swiper-media",{
		// calculateHeight:true,
		slidesPerView:2,
		spaceBetween:20,
		nextButton:".page-media .content .next",
		prevButton:".page-media .content .prev",
		pagination:".pagination-media"
	});
	
	$(".page-media .content .next").on('touchend', function(event) {
		swiper_media.slideNext()
	});
	$(".page-media .content .prev").on('touchend', function(event) {
		swiper_media.slidePrev()
	});
	// **********************精彩评论js******************************** 
	function LoadForumData(){
		$.get('api.php?action=forum',function(data){
			var rsp = eval('('+data+')');
			ForumData(rsp); 
		}); 
	}
	var getLocalTime = function(nS) {
		return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
	}
	function ForumData(data){
		for(var i=0;i<data.posts.length;i++){ 
			var str = '<li><p>'+data.posts[i].message+'</p>'+
							'<div class="d-info">'+
								'发布人：<span>'+data.posts[i].author+'</span>　发布时间：<span>'+ getLocalTime(data.posts[i].dateline)+'</span>'+
							'</div>'+
						'</li>';
			//console.log(str);
			$(".replay-wrap .replay-box ul").append(str); 
			$(".page-replay .nano").nanoScroller();
		} 
		// $(".message-txt-box .nano").nanoScroller({ scroll: 'top' }); 
	};
	LoadForumData();
	// **********************手势滑动******************************** 
	var loopPageSlide = $(".swiper-page>.swiper-wrapper>.swiper-slide");
	$("#swiper-page-box").swipe({
		swipeUp:function(event,direction, distance, duration, fingerCount) {
			if (vw>vh && !isForm) {
				// event.preventDefault()
				// swiperI++;
				// 滚至最后一屏
				// if (swiperI>realPageSlidLen-1) {
				// 	swiperI=0;
				// 	if (loopPageSlide.eq(swiperI)) {}
				// }
				// swiper_page.slideTo(swiperI)
				swiper_page.slideNext()
			}
		},
		swipeDown:function(event,direction, distance, duration, fingerCount) {
			if (vw>vh && !isForm) {
				// event.preventDefault()
				// swiperI--;
				// if (swiperI<0) {
				// 	swiperI=0;
				// }
				// swiper_page.slideTo(swiperI)
				swiper_page.slidePrev()

			}
		},
		swipeLeft:function(event,direction, distance, duration, fingerCount) {
			if (vw<vh && !isForm) {
				// // event.preventDefault()
				// swiperI--;
				// if (swiperI<0) {
				// 	swiperI=0;
				// }
				// swiper_page.slideTo(swiperI)
				swiper_page.slidePrev()
			}
		},
		swipeRight:function(event,direction, distance, duration, fingerCount) {
			if (vw<vh && !isForm) {
				// event.preventDefault()
				// swiperI++;
				// if (swiperI>realPageSlidLen-1) {
				// 	swiperI=0;
				// }
				// swiper_page.slideTo(swiperI)
				swiper_page.slideNext()
			}
		}
		//  不会被阻止事件的dom
		// excludedElements:$.fn.swipe.defaults.excludedElements+", #bar_nav , #banner ,#my_nav"
	});
	$("input.input").focus(function () {
		$(this).addClass('act')
	}).blur(function () {
		if (!$(this).val()) {
			$(this).removeClass('act')
		}
	})
	$("select.input").change(function () {
		if (this.selectedIndex!=0) {
			var optHtml = $(this).find("option").eq(this.selectedIndex).html();
			$(this).siblings('.text').html(optHtml)
		}else{
			$(this).siblings('.text').html("选择经销商<span>CHOOSE</span>")
		}
	})
	//关联CRM的试驾
	// 表单提交
	var baseurl = 'php/';
	function initDriveplugin() {
		cs55Config = {
			ctiurl: baseurl,
			cartype: 'jc_',
			aid: '342',
			op: 'try',
			carname: 'CS55',
			carcode: 'S201',
			from_source: 'H5',
			provinceText: '请选择省份',
			cityText: '请选择城市',
			townText: '请选择地区',
			dealerText: '请选择经销商',
			carcodeText: 'CS55',
			debug: 1, //1：不发到长安服务器，只发送到测服 0：发到长安服务器+测服
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
				// 仅此次项目使用
				this.cityEle.siblings('.text').html("选择城市<span>CITY</span>");
				this.townEle.siblings('.text').html("选择地区<span>TOWN</span>");
				this.dealerEle.siblings('.text').html("选择经销商<span>CHOOSE</span>");
			},
			citychange: function(e) {
				e.prev("label").html(e.find("option").not(function() {
					return !this.selected
				}).text());
				this.townEle.prev("label").html(this.townText);
				this.dealerEle.prev("label").html(this.dealerText);
				// 仅此次项目使用
				this.townEle.siblings('.text').html("选择地区<span>TOWN</span>");
				this.dealerEle.siblings('.text').html("选择经销商<span>CHOOSE</span>");
			},
			townchange: function(e) {
				e.prev("label").html(e.find("option").not(function() {
					return !this.selected
				}).text());
				this.dealerEle.prev("label").html(this.dealerText);
				// 仅此次项目使用
				this.dealerEle.siblings('.text').html("选择经销商<span>CHOOSE</span>");
			},
			dealerchange: function(e) {
				e.prev("label").html(e.find("option:selected").text());
			},
			reload: function() {
				// 重置表单====
				this.unameEle.val('').removeClass('act').siblings('.text').html("姓名<span>NAME</span>");
				this.umobileEle.val('').removeClass('act').siblings('.text').html("姓名<span>NAME</span>");
				// this.dtimeEle.val('试驾时间');
				// this.dtimeEle.prev('label').text('试驾时间');
				this.provinceEle.val('0').siblings('.text').html("选择省份<span>PROVINCE</span>");
				this.cityEle.val('0').html("<option>选择城市CITY</option>").siblings('.text').html("选择城市<span>CITY</span>");
				this.townEle.val('0').html("<option>选择地区TOWN</option>").siblings('.text').html("选择地区<span>TOWN</span>");
				this.dealerEle.val('0').html("<option>选择经销商CHOOSE</option>").siblings('.text').html("选择经销商<span>CHOOSE</span>");
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
})
