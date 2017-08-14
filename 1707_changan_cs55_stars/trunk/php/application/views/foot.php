<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</div><!-- bdwrap -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<!--<script type="text/javascript" src="js/vconsole.min.js"></script>-->
    <script type="text/javascript" src="js/idangerous.swiper.min.js"></script>
    <script type="text/javascript" src="js/jquery.imgpreload.min.js"></script>
    <script type="text/javascript">
    	// 共用页面切换函数
    	function swipe(id,time,type,callback){//type  page pop 两种选项
    		var time=time||1000;
    		var type=type||'page';

    		if($('#'+id).length == 0){
        		return;
        	}
    		if (type=="page") {
    			$('.page').removeClass('hide').removeClass('show').addClass('hide');
    		}
    		$('#'+id).removeClass('hide').addClass("show");
    		if (callback!="" && typeof callback!='undefined' && typeof callback =="function") {
    			callback();
    		}
    	}
    	// 仅操作单个弹层
    	function operate(dom,i){//i=0,关闭;i=1,弹出。
    		var i=i||0;
    		if (i==0) {
    			$("#"+dom).removeClass('show').addClass('hide');
    		}else{
    			$("#"+dom).removeClass('hide').addClass('show');
    		}
    	}
    </script>
    <script type="text/javascript">
    	$(function(){
    		// 图片加载操作池
    		var imgNum = 0;
    		var images = [];
    		$(function() {
    		    // 加载图片
    		    preLoadImg();
    		});
    		// 加载动画适配屏幕函数
    		function preLoadImg() {
    		    var imgs = document.images;
    		    for (var i = 0; i < 100; i++) {
    		        var src = $(imgs[i]).data("src");
    		        if (src != undefined && src != "") {
    		            images.push(src);
    		        }
    		    }
    		    $.imgpreload(images, {
    		        each: function() {
    		        	imgNum++;
    		        	$('.loader-inner p').html(Math.floor(imgNum/images.length*100));
    		        },
    		        all: function() {
        		        $('img[data-src]').each(function(){
            		        var _t = $(this);
            		        _t.prop('src', _t.data('src'));
            		    });
    		        	swipe('index');
    		            $('.loading').fadeOut(function(){
  		            	  $('.loading').remove();
  		            	  window.clearInterval(window.loadingTimer);
        		        });
    		        }
    		    });
    		}
    	});
    </script>
    <script type="text/javascript">
    	$(function(){
    		// 加載頁面
    		var loading=$('#loading-car');
    		window.loadingTimer = setInterval(function(){
    			loading.toggle();
    		},150);
    		// 首页
    		$('.index-btn').on('click',function(){
    			swipe('index-explain',200,'pop');
    		});
    		// 活动说明页面
    		$('.explain-btn').on('click',function(){
    			swipe('trip-page',200);
    		});
    		// 旅程页面
    		trip = new Swiper('.swiper-container',{
    			noSwiping : true,
    			loop : true,//可选选项，开启循环
    			onSlideChangeEnd: function(swiper){
                  var imgPath=$(trip.activeSlide()).find('.look-big').attr('data-detail');
    			  $('#detail-pic').attr('src',imgPath);
  			    }
    		});
    		$('#trip-prev').click(function(){
    			 trip.swipePrev();
    		});
    		$('#trip-next').click(function(){
    			 trip.swipeNext();
    		});
    		// 旅程页面
    		var detailContainer=$('#detail-pic');
    		$('.trip-page .look-big').on('click',function(){
    			var imgPath=$(this).attr('data-detail');
    			detailContainer.attr('src',imgPath);
    			swipe('trip-detail',200,'pop');
    		});
    		$('.trip-page .start').on('click',function(){
        		var num = $(this).data('num');
        		$('#jnum').val(num);
    			swipe('testdrive',200,'pop');
    			$('.vertical-screen').remove();
    		});
    		// 旅途内容详情
    		$('#trip-pop-close').on('click',function(){
    			$(this).parents('.trip-detail').addClass('hide');
    		});
    		// 预览旅程页-留资
    		var _able = false;
    		$('.submit').click(function() {
    	        var name = $.trim($('#name').val());
    	        var phone = $.trim($('#tel').val());
    	        var city = $.trim($('#city').val());
    	        if (name == '' || name == '姓名') {
    	            alert('请填写您的姓名');
    	            return false;
    	        } else if (phone == '' || phone == '手机号码') {
    	            alert('请填写您的电话');
    	            return false;
    	        } else if (phone.length != 11 || /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(phone) == false) {
    	            alert('请填写有效的手机号码');
    	            return false;
    	        } else if(city == '' || city == '居住城市'){
    				alert('请填写您居住的城市');
    	            return false;
    	        }else{
    	        	 if (!_able) {
                    	_able = true;
                    	// 填写逻辑
                    	//swipe('activity',200,'page',start);//test  可删除
                	}
    	        }

    	        $(this).parents('form')[0].submit();
    	    });
    	    // 留资弹窗关闭
    	    $('#testdrive').on('click',function(e){
    	    	if ($(e.target).hasClass("drive-container")||$(e.target).parents("drive-container").length>0) {
    	    		operate('testdrive');
    	    	}
    	    });
    	    // 横屏提示页面
    	    function start(){
    	    	var phone=$('.screen .phone');
    	    	var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
    	    	phone.addClass('phone-rotate').on(animationEnd, function() {
    				setTimeout(function(){phone.removeClass('phone-rotate');},500);
    			});
    		    setInterval(function(){
    				phone.addClass('phone-rotate').on(animationEnd, function() {
    					setTimeout(function(){phone.removeClass('phone-rotate');},500);
    				});
    			},2000);
    	    }
    	    function veistart(){
    	    	var phone=$('.vertical-screen .phone, .screen .phone');
    	    	var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
    	    	phone.on(animationEnd, function() {
    				phone.removeClass('ver-phone-rotate');
    			});
    		    setInterval(function(){
    				phone.addClass('ver-phone-rotate').on(animationEnd, function() {
    					phone.removeClass('ver-phone-rotate');
    				});
    			},2000);
    	    }
    	    //veistart();

    	    // 活动页面
    	    $('.share-btn').on('click',function(){
    	    	swipe('share1',200,'pop');
    	    });
    	    // 活动页面
    	    $('.join-me').on('click',function(){
    	    	swipe('share1',200,'pop');
    	    });
    	    // 车位已满弹层
    	    $('#act-over .ok').on('click',function(){
    	    	operate('act-over');
    	    });

    	    $('.tippage').on('click',function(){
    	    	$(this).removeClass('show');
    	    });
    	})
    </script>

      <script type="text/javascript">
      var shearData = {
        title   : 'CS55占座行动，旅行试驾、豪礼大奖等你来！',
		desc 	:'4月19日参与CS55活动，豪礼送不停！更有机会赢取旅行试驾大奖，你还在等什么！',
        link    : window.shearData.link    || window.location.href, // 分享链接
        imgUrl  : window.shearData.imgUrl  || '<?php echo base_url('images/share.jpg?v=1.1')?>',
        success : window.shearData.success || function(){},
        cancel  : window.shearData.cancel  || function(){}
      };
      wx.ready(function(){
        wx.onMenuShareAppMessage(shearData);
        wx.onMenuShareQQ(shearData);
        wx.onMenuShareWeibo(shearData);
        wx.onMenuShareQZone(shearData);
        var shearDataTimeline = {
            title   : 'CS55占座行动，旅行试驾、豪礼大奖等你来！',
            desc    : window.shearData.desc,
            link    : window.shearData.link,
            imgUrl  : window.shearData.imgUrl,
            success : window.shearData.success,
            cancel  : window.shearData.cancel
        };
        wx.onMenuShareTimeline(shearDataTimeline);
      });
      </script>