// 试驾页面的弹层显示
var $pupup_share = $(".page6 .pupup-share");// 分享 弹层
var $pupup_need = $(".page6 .pupup-need");// 需要更多人数 弹层
var $pupup_lottery = $(".page6 .pupup-lottery");// 抽奖 弹层
var $pupup_self = $(".page6 .pupup-self");// 人满（带自己飞） 弹层

var $share_btn = $(".page6 .share-btn");// 分享 按钮
var $to_draw_nor = $(".page6 .to-draw-nor");// 灰色 我要抽奖 按钮
var $to_draw_act = $(".page6 .to-draw-act");// 红色 我要抽奖 按钮

$share_btn.on('touchend', function() {
	$pupup_share.show();
});
$to_draw_nor.on('touchend', function() {
	$pupup_need.show();
});
$to_draw_act.on('touchend', function() {
	$pupup_lottery.show();
});
// 点击关闭按钮 隐藏父级
$(".close").on('touchend', function() {
	$(this).parent().fadeOut()
});