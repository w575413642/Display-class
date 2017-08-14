var acr;

window.onload = function() {
		$('.btn-other .btn').click(function(){
			$('.other').removeClass('hide')
			$('.btn-other .btn').removeClass('btn-active')
			if ($(this).index() == 0) {
			$('.btn-other .btn').eq(0).addClass('btn-active')
			$('.other').eq(1).addClass('hide')
			} else {
			$('.btn-other .btn').eq(1).addClass('btn-active')
			$('.other').eq(0).addClass('hide')
			}
	});
	$('.btn span').click(function() {
		$('.btn span').removeClass('arc');
		switch($(this).index()) {
			case 0:
				$('.btn span').eq(0).addClass('arc');
				$('.sky').attr('src', 'images/page4-sk2.png');
				break;
			case 1:
				$('.btn span').eq(1).addClass('arc');
				$('.sky').attr('src', 'images/page4-sk3.png');
				break;
			case 2:
				$('.btn span').eq(2).addClass('arc');
				$('.sky').attr('src', 'images/page4-sk1.png');
				break;
		}
	})
	//	$('.page4 .crt-lx').css({
	//		'bottom': -($('.text-box').height() +30 - parseInt($('.text-box').css('bottom').substr(0, $('.text-box').css('bottom').length - 2)))
	//	})
	//	$('.page3 .crt-lx').css({
	//		'bottom': -($('.text-box').height()  + 30 - parseInt($('.text-box').css('bottom').substr(0, $('.text-box').css('bottom').length - 2)))
	//	})
	//	$('.ca').click(function() {
	//		swiper.slideTo(2, 1000, false);
	//		setTimeout(function() {
	//			$('.crt-lx').addClass('anima-b');
	//		}, 400)
	//		$('.crt').addClass('anima');
	//	})
	//page constructor

	setInterval(function() {
		$('.mouse').addClass('mouse-top');
		setTimeout(function() {
			$('.mouse').removeClass('mouse-top');
			$('.mouse').fadeOut(0)
			$('.mouse').fadeIn(300)
		}, 1000)
	}, 1200)
	var swiper = new Swiper('.constructor', {
		direction: 'vertical',
		resistanceRatio: 0,
		followFinger : false,
		onSlideChangeStart: function(swiper) {
			$('.text-box').removeClass('text-ani');
			$('.crt').removeClass('anima');
			$('.crt-lx').removeClass('anima-b');
			if(swiper.activeIndex > 0) {
				$('.logo').hide('');
			} else {
				$('.logo').show();
			}
			if(swiper.activeIndex > 4 || swiper.activeIndex == 0) {
				$('.text-box').css('z-index','-1')
			} else {
				$('.text-box').css('z-index','9999')
			}
		},
		onSlideChangeEnd: function(swiper) {
			$('.text-box').addClass('text-ani');
			setTimeout(function() {
				$('.crt-lx').addClass('anima-b');
			}, 400)
			$('.crt').addClass('anima');
			if(swiper.activeIndex > 4 || swiper.activeIndex == 0) {
				$('.text-box').css('z-index','-1')
			} else {
				$('.text-box').css('z-index','9999')
			}
			if(swiper.activeIndex == 3) {
				acr = 1;
			} else {
				acr = 0;
			}
		}
	});
	$('.text-box .left').click(function() {
		swiper.slideTo(0, 1000, false);
		$('.text-box').removeClass('text-ani');
		acr = 1;
	});
	$('.go-home').click(function() {
		swiper.slideTo(0, 1000, false);
		$('.page8').removeClass('swiper-no-swiping')
		$('.constructor').css({
			'margin-top': '0px'
		})
	})
	//browse images
	var browse = new Swiper('.swiper-browse', {
		direction: 'horizontal',
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
	});
	// document.getElementById('aca').removeEventListener("touchstart",function(){});
	//滑出底部
	document.getElementById('constructor').addEventListener("touchstart", function(e) {
		// e.stopPropagation();
		var _x = e.touches[0].pageX;
		S_y = e.touches[0].pageY;
	})
	document.getElementById('constructor').addEventListener("touchmove", function(e) {
		// e.stopPropagation();
		var _x = e.touches[0].pageX;
		var _y = e.touches[0].pageY;
	})
	document.getElementById('constructor').addEventListener("touchend", function(e) {
		// e.stopPropagation();
		// alert('x')
		var _x = e.changedTouches[0].pageX;
		var E_y = e.changedTouches[0].pageY;
		if(E_y > S_y) {
			if (parseInt($('.constructor').css('margin-top')) < 0) {
			swiper.slideTo(3,1000, false);
			// setTimeout(function(){
				$('.crt').css({
					"margin-top":'0px',
					"margin-bottom":'0px',
					"opacity": "1"
				});
				// setTimeout(function() {
					$('.crt-lx').css({
					"margin-top":'0px',
					"margin-bottom":'0px',
					"opacity": "1"
				});
				// }, 400)
			// },600)
			} else{
				$('.crt').css({
					"margin-top":'10.5%',
					"margin-bottom":'0px',
					"opacity": "0"
				});
				// setTimeout(function() {
					$('.crt-lx').css({
					"margin-top":'0px',
					"margin-bottom":'-15.5%',
					"opacity": "0"
				});
			}

						// $('.page4').removeClass('swiper-no-swiping')
			$('.constructor').css({
				'margin-top': '0px'
			})
			// alert()
			if (swiper.activeIndex == 3) {
			$('.text-box').addClass('text-ani');
			} 
			$('.mouse').width('8%')
			//				$('.text-box').addClass('text-ani');
		} else {
			//				$('.text-box').addClass('text-ani');
			$('.mouse').width('8%')
			if(E_y != S_y) {
				// $('.page4').addClass('swiper-no-swiping')
				if(swiper.activeIndex == 3 && acr == 1) {
					$('.text-box').removeClass('text-ani');
					$('.constructor').css({
						'margin-top': -($('.footer').height())
					})
					$('.mouse').width('0px')
				}
			}
		}
	});
	//img center
	var arr_img = ['.bg-img1', '.bg-img2', '.bg-img3', '.bg-img4', '.bg-img5', '.bg-img6', '.bg-img7', '.bg-img8'];
	for(var i = 0; i < arr_img.length; i++) {
		$(arr_img[i]).css({
			'margin-top': ($(arr_img[i]).parent().height() - $(arr_img[i]).height()) / 2
		})
	}
}
window.baseurl = 'php/';
initDriveplugin();
// 表单提交
function initDriveplugin() {
	cs55Config = {
		ctiurl: baseurl,
		cartype: 'jc_',
		aid: '324',
		op: 'try',
		carname: '悦翔V7',
		carcode: 'B211',
		from_source: 'PC',
		provinceText: '省份',
		cityText: '城市',
		townText: '地区',
		dealerText: '选择经销商',
		carcodeText: '悦翔V7',
		debug: 0, //1：不发到长安服务器，只发送到测服 0：发到长安服务器+测服
		hasRaffle: false,
		dtimeEle: $("#dtime"),
		otimeEle: '',
		carcodeEle: $('.carType-box li'),
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
			$('#submitdrive').css({
				'background': '#737373'
			});
						document.getElementById('province').options[0].selected = true;
			$('#city').val('0').html("<option value=0>请选择</option>");
			$('#dealer').val('0').html("<option value=0>请选择</option>");
			$('#uname').val('');
			$('#umobile').val('');
			$('#uname').css('background', 'none');
			$('#umobile').css('background', 'none');
			$('.ni').html('姓名<b>name</b>')
			$('.ti').html('电话<b>mobile</b>');
			$('.ui').html('选择省份<b>province</b>');
			$('.ai').html('选择城市<b>city</b>');
			$('.bi').html('选择4S店<b>choose</b>');
		},
		submitdrive: function(e) {
			this.reload();
		}
	}
	//实例化试驾插件
	cs55Drive = new Testdrive(cs55Config);
	cs55Drive.init();
}
//
//	$('.constructor .swiper-slide').css({
//		'min-height':$('.constructor .swiper-slide').height()
//	})