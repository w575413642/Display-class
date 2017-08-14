var store,eventEmitter,Player,flash,barrage,teacherPlayer,isLiveing=false,chatnum=0,val=0;
var downCount = true;

var initLive = function(){
	return false;
	BJY.init({
		env: 'production',
		class: {
			//mytest 17071889516304
			//正式 17072677193481
			id: '17072677193481'  //测试房间 17072681150633 
		},
		user: {
			number: '0',
			avatar: 'http://img.gsxservice.com/30517_djgkb6i6.jpeg',
			name: '游客: ',
			type: 0
		}
	});
	barrage = new BJY.Barrage({
		container: $('.live-danmu-container'),
		// 移动速度，每秒移动多少个像素
		speed: 80,
		// 最长可显示多少个字，超过这个字数的会过滤
		maxLength: 10000,
		// 在 top - bottom 的区间出现弹幕
		top: 30,
		bottom: 30,
		// 轨道高度
		trackHeight: 20,
		textOnly:false,
		// 填充弹幕
	   renderContent:function(data){
		  // return data.content;
		  //console.log(11);
		  //console.log(data);
		  var tmsg = data.content;
		  for(var i=0;i<emotionObj.list.length;i++){
			  var item = emotionObj.list[i];
			  //emotionlist+='<a href="javascript:void(0);" onClick=emotionClick(this) title="'+item.zh_CN+'" class="emotionitem"><img src="'+emotionObj.prefix+item.url+'" /></a>';
			  //console.log(item.url);
			  if(tmsg.indexOf(item.zh_CN)>-1){
				  tmsg = formatRichText(data.content,item.zh_CN,"<img src='"+(emotionObj.prefix+item.url)+"' />");
			  }
		  }
		  var strnum = getFormatNum(chatnum);
		  //console.log('<p>'+strnum+': '+tmsg+'</p>');
		  return strnum+': '+tmsg;
	  }
	});

	store = BJY.store;
	eventEmitter = BJY.eventEmitter;

	Player = BJY.Player;

	// var playButton = $('#website-live-play');
	// playButton.on('click', function () {
	// 	// alert(11);
	// 	if (teacherPlayer.videoOn || teacherPlayer.audioOn) {
	// 		teacherPlayer.playAVClose();
	// 	}
	// 	if (downCount) {
	// 		//console.log($(".live_player video"))
	// 		teacherPlayer.playAV(
	// 			store.get('teacher.videoOn')
	// 		);
	// 		$(".live_player video").attr("controls","controls").addClass("show");
	// 		// playButton.hide();
	// 		// isPlay=true;
	// 	}
	// });

	eventEmitter
	.on(
		eventEmitter.TEACHER_MEDIA_ON,
		function () {
			if (!teacherPlayer) {
				// teacherPlayer = new Player({
				// 	element: $('.live_player'),
				// 	user: store.get('teacher'),
				// 	extension: Player.html
				// });
				// console.log(teacherPlayer)
				//playButton.hide();
				// $(".live_player video")[0].onpause = function () {
				// 	isPlay=false;
				// }
			}
		}
	).on(
		eventEmitter.TOTAL_USER_COUNT_CHANGE,
		function (event, data) {
			// data.totalUserCount
			$(".inlinecount").html(data.totalUserCount);
		}
	).on(
		// 接收消息列表
		eventEmitter.MESSAGE_RECEIVE,
		function (event, data) {
			//console.log(data);
			++chatnum;
			var tmsg = data.content;
			for(var i=0;i<emotionObj.list.length;i++){
				var item = emotionObj.list[i];
				//emotionlist+='<a href="javascript:void(0);" onClick=emotionClick(this) title="'+item.zh_CN+'" class="emotionitem"><img src="'+emotionObj.prefix+item.url+'" /></a>';
				//console.log(item.url);
				if(tmsg.indexOf(item.zh_CN)>-1){
					tmsg = formatRichText(data.content,item.zh_CN,"<img src='"+(emotionObj.prefix+item.url)+"' />");
				}
			}
			var strnum = getFormatNum(chatnum);
			$(".textList-content-wrap").append('<p>'+strnum+': '+tmsg+'</p>');
			// 发完消息 滚动到底
			
			// data.id   消息 id
			// data.time  服务器为发出的消息加上的服务器时间
			// data.channel  频道
			// data.from  发送方信息
			// data.content 文本消息内容
			// data.data 富文本消息
		}
	).on(
		// 同步点赞数
		eventEmitter.BROADCAST_RECEIVE,
		function (event, data) {
			var oldnum = data.value;
			++oldnum;
			if(isNaN(oldnum)) oldnum=0;
			// $(".zan-num").text(oldnum);
			storage('zannum',oldnum);
			// console.log(data);
		}
	).on(
		eventEmitter.CHAT_SERVER_LOGIN_SUCCESS,
		function () {
			eventEmitter.trigger(
				eventEmitter.MESSAGE_PULL_REQ,
				{
					channel: 'chat',
					count: 10,
				}
			)
		}
	).on(
		eventEmitter.MESSAGE_PULL_RES,
		function (event, data) {
			// 填充历史列表
			$.each(data.messageList,function(index,value,array){
				++chatnum;
				//数字加前导
				strnum = getFormatNum(chatnum);
				var msgitem = data.messageList[data.messageList.length-(index+1)];
				//console.log(msgitem);
				var tmsg = /*secName(msglist.data.sender)*/strnum+": "+msgitem.content;
				if(emotionObj != undefined){
					var emotionlist = '';
					for(var i=0;i<emotionObj.list.length;i++){
						var item = emotionObj.list[i];
						//emotionlist+='<a href="javascript:void(0);" onClick=emotionClick(this) title="'+item.zh_CN+'" class="emotionitem"><img src="'+emotionObj.prefix+item.url+'" /></a>';
						//console.log(item.url);
						if(tmsg.indexOf(item.zh_CN)>-1){
							tmsg = formatRichText(tmsg,item.zh_CN,"<img src='"+(emotionObj.prefix+item.url)+"' />");
						}
					}                    
				}
				$(".textList-content-wrap").append("<p id='msg_"+chatnum+"'>"+tmsg+"</p>");
				// $(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' });
			});
		}
	);

}
function playlive(){
	$('#website-live-play').trigger('click');
	// teacherPlayer.playAV(
	// 	store.get('teacher.videoOn')
	// );
	// $(".live_player video").attr("controls","controls").addClass("show");
	// $(".live_player video")[0].play();
}
$.fn.extend({
	insertAtCaret: function (myValue) {
		var $t = $(this)[0];
		if (document.selection) {
			this.focus();
			sel = document.selection.createRange();
			sel.text = myValue;
			this.focus();
		} else
			if ($t.selectionStart || $t.selectionStart == '0') {
				var startPos = $t.selectionStart;
				var endPos = $t.selectionEnd;
				var scrollTop = $t.scrollTop;
				$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
				this.focus();
				$t.selectionStart = startPos + myValue.length;
				$t.selectionEnd = startPos + myValue.length;
				$t.scrollTop = scrollTop;
			} else {
				this.value += myValue;
				this.focus();
			}
	}
}) 

$(function(){
	$(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' });
	// initLive();
	// setTimeout(function(){
	//     console.log($(".bjy-video"));
	//     $(".bjy-video").attr('id','live_video_website');
	//     document.getElementById("live_video_website").play();
	// },3000);
	//
	//return false;
	//计算播放框比例
	//  var rateHW = 9/16;
	// pageW = $(window).width()*.6*.7;
	// //pageW = $(".live-container_box_video").width();
	// //$(".live-container_box_video").height(pageW*(rateHW));
	// // $(".live-container_box").height(pageW*(rateHW));
	// // $(".live-container_box .video_box").height($(".live-container_box").height());
	// $(".live-container_box .video_box").height(pageW*(rateHW));     
	// $(".live-container_box_bar_content_list").height(pageW*(rateHW)-10);     
	// pageH = pageW*(rateHW);
	// $(".zan-num").text(storage('zannum'));
	// initLive();
	//console.log(pageW*(rateHW));

	// if(localStorage.getItem('cha_liveuid') !=null){
	//     visitorid = localStorage.getItem('cha_liveuid');
	//     visitorname = localStorage.getItem('cha_liveuname');
	// }else{
	//     //初始化用户
	//    $.get(baseurl+'index.php?c=api&m=visitorin',function(data){
	//         data = JSON.parse(data);
	//         if(data.code=200){
	//             visitorid = data.lastid;
	//             visitorname = data.username;
	//             localStorage.setItem('cha_liveuid',visitorid);
	//             localStorage.setItem('cha_liveuname',visitorname);
	//         }
	//     });
	// }

	// $('input[placeholder]').placeholder(); 
	//初始化滑块儿
	// $("#slider").slider({
	// 	value:100,
	// 	animate: true,
	// 	change:function(){
	// 		var volume =parseInt($("#slider").slider("value"));
	// 	   changeVolume(volume);
	// 	},
	// 	slide:function(){
	// 		var volume =parseInt($("#slider").slider("value"));
	// 		changeVolume(volume);
	// 	}
	// });
	//填充表情
	//console.log(emotionObj != undefined);
	if(emotionObj != undefined){
		//console.log(222);
		var emotionlist = '';
		for(var i=0;i<emotionObj.list.length;i++){
			var item = emotionObj.list[i];
			emotionlist+='<a href="javascript:void(0);" onClick=emotionClick(this) title="'+item.zh_CN+'" class="emotionitem"><img src="'+emotionObj.prefix+item.url+'" /></a>';
		}
		$(".live-container_box_footer-layout-emotion").html(emotionlist);
	}
	//留言条动画
	$(".live-container_box_bar_close").click(function(){
		$(".live-container_box_video").animate({"width":"100%"},300,function(){
			pageW = $(this).width();
			pageH = pageW*(rateHW);
			//$(".live-container_box_video").height(pageW*(rateHW));
			// $(".live-container_box").height(pageW*(rateHW)+$(".live-title").height()+60);
			// $(".live-container_box .video_box").height($(".live-container_box").height()-60-$(".live-title").height());
			//$(".live-container_box_bar_open").removeClass("hidden");
			$(".live-container_box_bar").animate({"right":"-19%"},200,function(){
				$(".live-container_box_bar_open").removeClass("hidden");
			});
		});
		$(".live-container_box_bar").animate({"right":"-30%"},800,function(){
			$(".live-container_box_bar").addClass("hidden");
			//$(".live-container_box_bar_open").removeClass("hidden");
		});
	});
	//留言条动画
	$(".live-container_box_bar_open").click(function(){
		$(".live-container_box_bar").removeClass("hidden");
		// $(".live-container_box_bar_close img").css("top",pageH/2);
		$(".live-container_box_bar_open").addClass("hidden") 
		$(".live-container_box_bar").animate({"right":"0%","width":"30%"},600,function(){
			$(".live-container_box_bar_open").addClass("hidden");
			
		});
		setTimeout(function(){
			$(".live-container_box_video").animate({"width":"70%"},800,function(){
				pageW = $(this).width();
				pageH = pageW*(rateHW);
				//console.log(pageW);
				//$(".live-container_box_video").height(pageW*(rateHW));
				// $(".live-container_box").height(pageW*(rateHW)+$(".live-title").height()+60);
				// $(".live-container_box .video_box").height($(".live-container_box").height()-60-$(".live-title").height());
				//$(".live-container_box_bar_open").addClass("hidden");
			});
		},200);
	});
	//弹幕开关动画 已修改 
	$(".icon-dan-no").click(function(){
		// console.log($(this).data("val"));
		if($(this).attr("data-val")=='close'){
			$(".live-danmu-container").show();
			$(this).attr({
				"data-val":"open",
				"src":"h5/images/dan.png"
			});
			barrage.open();
		}else{
			$(".live-danmu-container").hide();
			$(this).attr({
				"data-val":"close",
				"src":"h5/images/dan-no.png"
			});
			barrage.close();
		}
	});
	//点击发送
	$(".bjy-send-message").click(function(){  
		if (downCount) {
			var msg = $("#msginput").val();
			if($.trim(msg)==''){
				alert('说点什么吧!');
			}else{
				//处理要发送的信息
				eventEmitter.trigger(
					eventEmitter.MESSAGE_SEND,
					{
						channel: 'chat',
						content: msg,
					}
				);
				$("#msginput").val('');
			}
		}
	})
	//开关声音
	$(".toolbar-voice").click(function(){  
		if($(this).attr("data-val")=='close'){
			changeVolume(parseInt($("#slider").slider("value")));
			$('.toolbar-voice').attr({"data-val":"open",'src':'pc/live_plugin/images/icon-voice.png'}); 
			voicestate = true;
		}else{
			// channel.send('submitMute',{"mute":true}) 
			changeVolume(0);
			$('.toolbar-voice').attr({"data-val":"close",'src':'pc/live_plugin/images/icon-voice2.png'}); 
			voicestate = false;
		}
	});
	//$(".live-container_box_footer_content .toolbar-danmu").trigger("click");
	//表情弹窗
	$(".toolbar-emotion").click(function(){
		$(".live-container_box_footer-layout-emotion").toggle();
	});
	
	// $(".bjy-send-message").click(function(){
	// 	var msg = $("#msginput").val();
	// 	if($.trim(msg)==''){
	// 		alert('说点什么吧!');
	// 	}else{
	// 		//处理要发送的信息
	// 		eventEmitter.trigger(
	// 			eventEmitter.MESSAGE_SEND,
	// 			{
	// 				channel: 'chat',
	// 				content: msg,
	// 			}
	// 		);
	// 		$("#msginput").val('');
	// 	}
	// }); 
	
	//点赞
	$(".icon-zan").click(function(){
		// $.get(baseurl+'index.php?c=api&m=addup',function(data){
		// });
		var oldnum = storage('zannum');
		BJY.broadcast.send('zan',oldnum); 
		//$(".zan-num").text(oldnum);
		storage('zannum',oldnum);
		var x = 45;       
		var y = 0;  
		var num = Math.floor(Math.random() * 4 + 0);
		var index=$('.zanbox').children('img').length;
		var rand = parseInt(Math.random(-40,40)*10); 
		//console.log(rand);
		$(".zanbox").append("<img style='opacity:1;position:absolute;bottom:0px;left:35%;' src=''>");
		$('.zanbox img:eq(' + index + ')').attr('src','h5/images/heart/'+num+'.png')
		$(".zanbox img:eq(" + index + ")").animate({
			bottom:"90px",
			opacity:"0",
			width:"15px",
			left: rand,
		},1500,function(){
			$(".zanbox :first-child").remove();
		});
   });
	//$(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' });
});
//替换表情中的文字为图片
function formatRichText(str,reallyDo,replaceWith) { 
	var e=new RegExp(reallyDo,"g"); 
	words = str.replace(e, replaceWith); 
	return words; 
} 
//表情点击
function emotionClick(t){
	var index = $(t).index();
	var thisemo = emotionObj.list[index];
	var val = $(".toolbar-input").val();
	$(".bjy-no-forbiden input").insertAtCaret(thisemo.zh_CN);
	$(".bjy-no-forbiden input").change();
	//$("#msgcontent").html(val+img);
	$(".live-container_box_footer-layout-emotion").toggle();
}
//模拟本地缓存
function storage(k,v){
	if(v!=undefined){
		if(typeof localStorage != undefined && typeof localStorage != null && typeof localStorage !='unknown'){
			localStorage.setItem(k,v);
		}else{
			$.cookie(k,v,{expires:7});
		}
	}else{
		if(typeof localStorage != undefined && typeof localStorage != null && typeof localStorage !='unknown'){
			val = localStorage.getItem(k);
		}else{
			val = $.cookie(k);
		}
		return (isNaN(val)||val==null)?0:val;
	}
}

//格式化显示的序号
function getFormatNum(num){
	var strnum = '';
	// console.log(num.toString().length);
	for(var l=num.toString().length;l<2;l++){
		strnum += '0'
	}
	//console.log(strnum+chatnum.toString());
	strnum = '游客'+strnum+num.toString();
	return strnum;
}

// 改变声音大小
function changeVolume(v){
	eventEmitter.trigger(
		eventEmitter.SPEAKER_VOLUME_CHANGE_TRIGGER,
		{
			volume: v
		}
	)
}