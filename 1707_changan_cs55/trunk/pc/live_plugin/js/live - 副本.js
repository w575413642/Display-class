GS.options({
		log : function(log) {
			//logEvent("SDK", log, 'orange');
		}
// 		,debug:true
	});
 var firstIn = true;
 var channel = new GS.createChannel();
 var chatnum = 0;
 var nowtop = 0;
 var msgarr = [];
 var isLiveing = false;
 var baseurl = 'php/';
 channel.bind('onDataReady',function(){
    channel.send('submitVolume', {value:1});
	channel.bind('onUserOnline',function(d){
		//console.log(d.data.count);
        //console.log(top.getElementById("d-num"));
		$("span.inlinecount").text(d.data.count);
    });
    channel.bind('onPlay',function(){
        isLiveing = true;
        $(".d-num").show();
    });
    channel.bind('onQAList',function(qalist){
        var rnum = qalist.data.list.length;
        if(parseInt(storage('zannum'))<rnum){
            $(".zan-num").text(rnum);
        }else{
            $(".zan-num").text(storage('zannum'));
        }
    });
    //收到点赞
    channel.bind('onQA',function(qa){
        // console.log(qa.data.question);
        var zannum = parseInt(qa.data.question);//storage('zannum');
        if(zannum>storage('zannum')){
            storage('zannum',zannum);
            $(".zan-num").text(zannum);
        }
        // alert(11);
    });
    channel.bind('onPublicChat',function(msglist){
        //console.log(msglist);
        ++chatnum;
        //数字加前导
        //strnum = getFormatNum(chatnum);
        var tmsg = secName(msglist.data.sender)+": "+msglist.data.richtext;
        if(emotionObj != undefined){
            //console.log(222);
            var emotionlist = '';
            for(var i=0;i<emotionObj.list.length;i++){
                var item = emotionObj.list[i];
                //emotionlist+='<a href="javascript:void(0);" onClick=emotionClick(this) title="'+item.zh_CN+'" class="emotionitem"><img src="'+emotionObj.prefix+item.url+'" /></a>';
                //console.log(item.url);
                if(tmsg.indexOf(item.zh_CN)>-1){
                    tmsg = formatRichText(tmsg,item.zh_CN,"<img src='"+(emotionObj.prefix+item.url)+"' />");
                }
            }
            //msg = encodeURIComponent(msg);
        }
        auto("<p id='danmu_"+chatnum+"' data-num="+chatnum+" >"+tmsg+"</p>");
        //},1000);
        $(".nano-content").append("<p id='msg_"+chatnum+"'>"+tmsg+"</p>");
        $(".chatNum").text(chatnum);
        // nowtop += 100;
        $(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' });
        //$(".live-container_box_bar_content").find(".nano").nanoScroller({scrollTop:nowtop+100});
        //$(".live-container_box_bar_content").find(".nano").nanoScroller({"scrollTop":$("#msg_"+chatnum).offset().top+100});
    });
});
 var visitorid = 0;
 var visitorname = '';
 var voicestate=true;
$(function(){

    //计算播放框比例
    var rateHW = 9/16;
    pageW = $(window).width()*.6*.7;
    //pageW = $(".live-container_box_video").width();
    //$(".live-container_box_video").height(pageW*(rateHW));
    $(".live-container_box").height(pageW*(rateHW)); 
    // $(".live-container_box .video_box").height($(".live-container_box").height());
    $(".live-container_box .video_box").height(pageW*(rateHW)); 
    pageH = pageW*(rateHW);
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

    $('input[placeholder]').placeholder(); 
    //初始化滑块儿
    $("#slider").slider({
        value:100,
        animate: true,
        change:function(){
            var volume =parseInt($("#slider").slider("value"))/100;
            //console.log($("#slider").slider("value"));
			if(voicestate){
				channel.send('submitVolume', {value:volume});
			}
        },
        slide:function(){
            var volume =parseInt($("#slider").slider("value"))/100; 
            //console.log($("#slider").slider("value"));
			if(voicestate){ 
				channel.send('submitVolume', {value:volume});
			}
        }
    });
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
    //弹幕开关动画
    $(".live-container_box_footer_content .toolbar-danmu").click(function(){
        // console.log($(this).data("val"));
        if($(this).attr("data-val")=='close'){
            $(".live-container_box_footer_content .toolbar-danmu-btn").animate({'right':'-2px'},200,function(){
                $('.live-container_box_footer_content .toolbar-danmu').attr("data-val","open");
                $('.live-container_box_footer_content .toolbar-danmu-bg').addClass("btnclose");
                $(".danmu_font").text("关闭弹幕");
                $(".live-container_box_danmu").show();
            });
        }else{
            $(".live-container_box_footer_content .toolbar-danmu-btn").animate({'right':'16px'},200,function(){
                $('.live-container_box_footer_content .toolbar-danmu').attr("data-val","close");
                $('.live-container_box_footer_content .toolbar-danmu-bg').removeClass("btnclose");
                $(".danmu_font").text("开启弹幕");
                $(".live-container_box_danmu").hide();
            });    
        }
    });
	//开关声音
    $(".toolbar-voice").click(function(){ 
        if($(this).attr("data-val")=='close'){
            channel.send('submitMute',{"mute":false})
			$('.toolbar-voice').attr({"data-val":"open",'src':'pc/live_plugin/images/icon-voice.png'}); 
			voicestate = true;
        }else{
            channel.send('submitMute',{"mute":true}) 
			$('.toolbar-voice').attr({"data-val":"close",'src':'pc/live_plugin/images/icon-voice2.png'}); 
			voicestate = false;
        }
    });
    $(".live-container_box_footer_content .toolbar-danmu").trigger("click");
    //表情弹窗
    $(".live-container_box_footer_content .toolbar-emotion").click(function(){
        $(".live-container_box_footer-layout-emotion").toggle();
    });

    //输入同步
    $(".toolbar-input").change(function(){
        $("#msgcontent").html($(this).val());
    });
    //键盘点击
    $(".toolbar-input").on('keydown',function(e){
        if(e.keyCode == 13){
            $("#msgcontent").html($(".toolbar-input").val());
            sendMsg(true);
        }
    });
    //获取服务器赞数
    // setInterval(function(){
    //     $.get(baseurl+'index.php?c=api&m=getaddup',function(data){
    //         data = JSON.parse(data);
    //         if(data.code=200){
    //             $(".zan-num").text(data.num);
    //         }
    //     });
    // },100000);    
    //点赞
    $(".zanbtn").click(function(){
        // $.get(baseurl+'index.php?c=api&m=addup',function(data){
            
        // });
        var oldnum = $(".zan-num").text();
        var zanObj = {
            "content":++oldnum
        };
        channel.send('submitQuestion',zanObj,function(){

        }); 
        $(".zan-num").text(oldnum);
        storage('zannum',oldnum);
        var x = 45;       
        var y = 0;  
        var num = Math.floor(Math.random() * 4 + 0);
        var index=$('.zanbox').children('img').length;
        var rand = parseInt(Math.random(-40,40)*90); 
        //console.log(rand);
        $(".zanbox").append("<img style='opacity:1;position:absolute;bottom:20px;left:35%;' width='30' src=''>");
        $('.zanbox img:eq(' + index + ')').attr('src','images/heart/'+num+'.png')
        $(".zanbox img:eq(" + index + ")").animate({
            bottom:"300px",
            opacity:"0",
            width:"30px",
            left: rand,
        },3000);
   });
    $(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' });
});
//替换表情中的文字为图片
function formatRichText(str,reallyDo,replaceWith) { 
    var e=new RegExp(reallyDo,"g"); 
    words = str.replace(e, replaceWith); 
    return words; 
} 

//格式化显示的序号
function getFormatNum(num){
    var strnum = '';
    // console.log(num.toString().length);
    for(var l=num.toString().length;l<4;l++){
        strnum += '0'
    }
    //console.log(strnum+chatnum.toString());
    strnum = strnum+num.toString();
    return strnum;
}

//发送留言
function sendMsg(isme){
    type = 'submitChat';
    var msg = $("#msgcontent").html();
    if(!canSend){
        return false;
    }
    if(!isLiveing){
        alert('4月5日直击现场直播，敬请期待!');
        return false;
    }
    if($.trim(msg)==''){
        alert("不带点什么发射么?");
        return false;
    }
    if(msg.length>30){
        alert("您的输入超出了最长限制!");
        return false;
    }
	
    //console.log(msg);
    //转换消息内容
    if(emotionObj != undefined){
        //console.log(222);
        var emotionlist = '';
        for(var i=0;i<emotionObj.list.length;i++){
            var item = emotionObj.list[i];
            //emotionlist+='<a href="javascript:void(0);" onClick=emotionClick(this) title="'+item.zh_CN+'" class="emotionitem"><img src="'+emotionObj.prefix+item.url+'" /></a>';
            //console.log(item.url);
            if(msg.indexOf(item.zh_CN)>-1){
                msg = formatRichText(msg,item.zh_CN,"<img src='"+(emotionObj.prefix+item.url)+"' />");
            }
        }
        //msg = encodeURIComponent(msg);
    }
    //过滤处理
    $.post(baseurl+'check.php',{'msg':msg},function(data){
        if(data.msg!='ok'){
            return false;
        }else{
            try{
                msgObj = {
                    "richtext":msg
                };
                var i = channel.send(type, msgObj,function(){
                    //追加评论
                    $(".toolbar-input").val("");
                    $("#msgcontent").html("");
                    //防止刷屏
                    canSend = false;
                    //可用重置
                    setTimeout('resetEnable()',1000);
                    ++chatnum;
                    var tstrnum = "我";//getFormatNum(chatnum);
                    var thismsg = '<p class="mine" id="msg_'+chatnum+'" data-num='+chatnum+' >'+tstrnum+": "+msg+'</p>';
                    auto(thismsg.replace('msg_',"danmu_"),isme);
                    $(".live-container_box_bar_content_list .nano-content").append(thismsg);
                    var vh = $(".live-container_box_video").height()-20; 
                    //msgarr.push("<p id='danmu_"+chatnum+"'>"+msg+"</p>");
                    $(".live-container_box_bar_content").find(".nano").nanoScroller({ scroll: 'bottom' });
                    //$(".live-container_box_bar_content").find(".nano").nanoScroller({scrollTop:nowtop+100});
                    $(".chatNum").text(chatnum);
                    // nowtop += 100;
                });
             }catch(e){
                alert("数据内容格式错误-"+e);
                throw e;
            }
        }

    },'json');
	//var msgdata = {"userid":visitorid,"username":visitorname,"richtext":msg};
	//留言入库备用
	// $.post(baseurl+'index.php?c=api&m=livemsg',msgdata,function(){
		
	// });
}
var danmuInterval = null;
/*显示弹幕*/
var pageW=$(".live-container_box_video").width();
//console.log(pageW); 
// var pageH=$(".live-container_box_video").height();
var pageH=360;
var boxDom=$(".live-container_box_danmu");
var btnDom=$(".toolbar-send");
var Top,Right;
var colorArr=["#cfaf12","#12af01","#981234","#adefsa","#db6be4","#f5264c","#d34a74"];
 //btnDom.on("click",function(){sendMsg()});
 var canSend = true;
 function resetEnable(){
    canSend = true;
 }
 //弹幕动画
function auto(str,isme){
    var creSpan=$(str);
    //console.log(creSpan.html());
    //var text=$("#text").val();
    //creSpan.text(text);
    //$("#text").val("");
    pageW = $(".live-container_box_video").width();
    //console.log(pageW);
	pageH=$(".live-container_box_danmu").height();
    Top=parseInt(pageH*(Math.random()));
    var num=parseInt(colorArr.length*(Math.random()));
    if(Top>pageH-50){
        Top=pageH-80;
    }
    //if(isme) chatnum = 5;
    creSpan.css({"top":Top,"color":colorArr[num],"right":-1*pageW+"px"});
    //console.log(" pageW "+pageW+" right:"+(-1*(pageW)));
    //pageW = parseInt(100*(creSpan.data("num")));
    //if(creSpan.hasClass("mine")){
    //    creSpan.css("border","1px solid "+colorArr[num]);
    //}
    boxDom.append(creSpan);
    var spanDom=$(".live-container_box_danmu>p:last-child");
    spanDom.stop().animate({"right":pageW,"left":-pageW},15000,"linear",function(){
                $(this).remove();
            });
    spanDom.hover(function(){$(this).html();},function(){});
    
}

//表情点击
function emotionClick(t){
    var index = $(t).index();
    var thisemo = emotionObj.list[index];
    var val = $(".toolbar-input").val();
    $(".toolbar-input").insertAtCaret(thisemo.zh_CN);
    $(".toolbar-input").change();
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
        var val = '';
        if(typeof localStorage != undefined && typeof localStorage != null && typeof localStorage !='unknown'){
            val = localStorage.getItem(k);
        }else{
            val = $.cookie(k);
        }
        return val||0;
    }
}
//如果是手机 隐藏几位
function secName(name){
    if((/^1[3|4|5|8|7][0-9]\d{4,8}$/.test(name))){
        return name.substr(0,3)+"****"+name.substr(7);
    }else{
        return name;
    }
}