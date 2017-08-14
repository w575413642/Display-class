<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>奔腾B70疯狂拆车挑战赛，不服来战，邀你一起！</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link type="text/css" rel="stylesheet" href="styles/reset.css" media="screen">
        <link type="text/css" rel="stylesheet" href="styles/swiper.min.css" media="screen">
        <link type="text/css" rel="stylesheet" href="styles/animate.min.css" media="screen">
        <link type="text/css" rel="stylesheet" href="styles/index.css?v=<?php echo time();?>" media="screen">
        <link type="text/css" rel="stylesheet" href="styles/loading.css" media="screen">
        <link type="text/css" rel="stylesheet" href="styles/style.css?v=<?php echo time();?>" media="screen">
    </head>
    <body>
        <!-- 音频按钮 -->
        <div id="audio_btn" class="audio-play" style="display: block;">
            <div class="audio-rotate"></div>
        </div>

        <!-- 活动规则弹窗 start-->
        <div class="rulePop" style="overflow: scroll">
            <img class="closeBtn" data-src="img/close.jpg">
            <div class="activityContent">
                <div class="activityContent-txt">
                    <h1>活动规则：</h1>
                    <p>1、进阶挑战赛共分4题进行，每答对一题，可获得对应称号和徽章并有机会获得相应礼品。</p>
                    <p>2、获得“工程师”称号的用户即有机会参与抽奖，我们为您准备了丰富的活动奖品;</p>
                    <p>3、活动结束后7个工作日内，将通过官方微信发布中奖名单及领奖事宜。</p>
                    <p>4、中奖网友需在7个工作日内将姓名、手机号、寄送地址、邮编等信息发送到一汽奔腾官方微信，以便工作人员核实，未在指定日期内提供个人信息者，将视为自动放弃奖品；</p>
                    <p>5、主办方一汽奔腾汽车有限公司对本活动保留法定范围内最终解释权。</p>
                    <h1>奖品设置：</h1>
                    <p class="prizetxt">一等奖：一汽奔腾B70汽车模型，共计10个</p>
                    <p class="prizeImg"><img src="img/actcontentimg1.jpg" alt="一汽奔腾B70汽车模型">
                    </p>
                    <p class="prizetxt">二等奖：一汽奔腾行车必备工具箱，共计10个</p>
                    <p class="prizeImg"><img src="img/actcontentimg2.jpg" alt="一汽奔腾行车必备工具箱">
                    </p>
                    <p class="prizetxt">三等奖：一汽奔腾汽车胎压计，共计10个</p>
                    <p class="prizeImg"><img src="img/actcontentimg3.jpg" alt="一汽奔腾汽车胎压计">
                    </p>
                    <p class="prizetxt">试驾奖：我们会在填写预约试驾的用户中抽取10名赠送精美雨伞一把。</p>
                    <p class="prizeImg"><img src="img/actcontentimg4.jpg" alt="精美雨伞"></p>
                    <p class="prizetxt">鼓励奖：没有中奖的亲们，也不要灰心。我们会从未中奖的用户名单中抽取20名赠送时尚咖啡杯一个。</p>
                    <p class="prizeImg"><img src="img/actcontentimg5.jpg" alt="咖啡杯"></p>
                    

                </div>
            </div>
        </div>
        <!-- 活动规则弹窗 end-->
        <!-- 分享图层 start-->
        <div class="shareTip"></div>
        <!-- 分享图层 end-->
        <!-- 预约试驾弹层 start-->
        <div  class="testDrivePopUp">
            <img data-src="img/driveTop.png" class="driveTop">
            <form  id="testFrom" class="testFrom">
                <table>
                    <tr>
                        <td><img data-src="img/name.png?v=<?php echo time();?>"></td>
                        <td colspan="3"> <input type="text" name="name"  data-valid="^[a-zA-Z\u4e00-\u9fa5]+$">
                    </td>
                </tr>
                <tr>
                    <td><img data-src="img/sex.png?v=<?php echo time();?>"></td>
                    <td colspan="3">
                        <div class="cti-testdrive-sex clearfix" id="testdrv_sex">
                            <div class="cti-sex-man sex active">男</div>
                            <div class="cti-sex-woman sex">女</div>
                            <input type="hidden" name="sex" id="d_sex" value="男"  data-valid="^['男'|'女']$">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><img data-src="img/tel.png?v=<?php echo time();?>"></td>
                    <td colspan="3"> <input type="tel" name="mobile"  data-valid="^1+\d{10}$">
                </td>
            </tr>
            <tr>
                <td><img data-src="img/type.png?v=<?php echo time();?>"></td>
                <td colspan="3">
                    <select name="pattern" data-valid=".+">
                        <option value="B70" checked>B70</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><img data-src="img/provice.png?v=<?php echo time();?>"></td>
                <td>
                    <select name="dealer_province" data-valid=".+" style="width:68px;">
                        <option value="">请选择</option>
                    </select>
                </td>
                <td><img data-src="img/city.png"></td>
                <td style="text-align: right;">
                    <select name="dealer_city" data-valid=".+" style="width:68px;">
                        <option value="">请选择</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                <img data-src="img/dealer.png"></td>
                <td colspan="3">
                    <select name="dealer" data-valid=".+">
                        <option value="">请选择</option>
                    </select>
                </td>
            </tr>
        </table>
    </form>
    <img data-src="img/testSubmit.png" class="submitBtn">
</div>
<!-- 预约试驾弹层 end-->
<!-- loading start-->
<div class="cti-loading" id="d_loading">
    <div class="d-timer">
        <div class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
        <label for="d-timer" class="d-status-txt">0%</label>
    </div>
</div>
<!-- loading end-->
<!--swiper start-->
<div class="swiper-container parent">
    <div class="swiper-wrapper">
        <div class="swiper-slide" data-flag="start">
            <!-- 首页灯光闪动测试 -->
            <div class="guang guang1_m"></div>
            <div class="startGameTitle">
                <img data-src="img/startTitleIco.png" class="startGameIco">
                <img data-src="img/startTitleTxt.png" class="startGameTitleImg">
            </div>
            <div class="startGameBtn">
                <img class="startGameBtnImg1" data-src="img/startButtonTxt1.png">
                <img class="startGameBtnImg2" data-src="img/startButtonTxt2.png">
                <img class="startGameBtnImg3" data-src="img/startButtonTxt3.png">
                <img class="startGameBtnImg4" data-src="img/startButtonTxt4.png">
                <img data-src="img/startGame.png" class="startGameBtnBg">
            </div>
            <img data-src="img/lookRule.png" class="lookRuleBtn">
        </div>
        <div class="swiper-slide" data-flag="video"  id="video">
            <!-- 视频页灯光闪动测试 -->
            <div class="guang2 guang1_m"></div>
            <div id="guang2_div" style="width:100%;height:100%;position: absolute;left: 0;top: 0;  background: rgba(0,0,0,0.1);  z-index: 1;overflow:hidden;font-size:10000px;">&nbsp;</div>
            <div class="videoOpenBtn">
                <img data-src="img/videoBtn.jpg" alt="" class="videoOpenBtnImg">
                <video id="video_play_home" poster="img/videoBtn.jpg" controls="controls" data-src="video/video.mp4">
                    <source type="video/mp4">
                </video>
            </div>
    </div>
    <div class="swiper-slide" data-flag="question01" id="question01">
        <!-- 问题灯光闪动测试 -->
        <div class="guang3 guang1_m"></div>
        <div class="question">
            <span>1. 奔腾B70采用什么样的车身结构？</span>
            <ul>
                <li>A. 笼式车身</li>
                <li>B. 3H车身</li>
                <li>C. GOA车身</li>
                <li>D. 厢式车身</li>
            </ul>
        </div>
    </div>
    <div class="swiper-slide" data-flag="question02">
        <!-- 问题灯光闪动测试 -->
        <div class="guang3 guang1_m"></div>
        <div class="question question2">
            <span>2. 视频中奔腾B70运动版的发动机采用的是？</span>
            <ul>
                <li>A. 4GC 2.0T高性能涡轮增压发动机</li>
                <li>B. 4GC 1.8T高性能涡轮增压发动机</li>
                <li>C. 4GD 2.0L自然吸气发动机</li>
                <li>D. 4GD 1.8L自然吸气发动机</li>
            </ul>
        </div>
    </div>
    <div class="swiper-slide" data-flag="question03" id="question03">
        <!-- 问题灯光闪动测试 -->
        <div class="guang3 guang1_m"></div>
        <div class="question">
            <span>3. 奔腾B70完美完成弯道漂移（详见《竞速天门山》视频）主要在于__？</span>
            <ul>
                <li>A. 3H车身结构</li>
                <li>B. 动力系统</li>
                <li>C. 悬挂系统</li>
                <li>D. 电气系统</li>
            </ul>
        </div>
    </div>
    <div class="swiper-slide" data-flag="question04" id="question04">
        <!-- 问题灯光闪动测试 -->
        <div class="guang3 guang1_m"></div>
        <div class="question">
            <span>4. 奔腾B70采用的是BOSCH第几代电子控制系统？</span>
            <ul>
                <li>A. 第八代</li>
                <li>B. 第九代</li>
                <li>C. 第十代</li>
                <li>D. 第十一代</li>
            </ul>
        </div>
    </div>
    <div class="swiper-slide" data-flag="success">
        <img data-src="img/lottery.png" class="lotteryBtn">
    </div>
    <div class="swiper-slide" data-flag="failure">
        <img data-src="img/must.png" class="mustBtn">
        <img data-src="img/playAgain.png" class="playAgainBtn">
        <img data-src="img/testDrive.png" class="testDriveBtn">
    </div>
    <div class="swiper-slide" data-flag="rotate">
        <!-- 转盘页灯光闪动测试 -->
        <div class="guang4 guang1_m"></div>
        <div class="getPrice">
            <img data-src="img/zhuanpan-bg.png" class="zhuanpan-bg">
            <img data-src="img/zhuanpan.png" class="zhuanpan">
            <img data-src="img/ClickPrice.png" class="ClickPrice">
        </div>
    </div>
    <div class="swiper-slide" data-flag="successPrizeResult">
        <!-- 此页面 start 缺少中奖失败psd-->
        <!-- 第一次抽奖并且中奖的页面 -->
        <div  class="Enter">
            <div class="whichPrice"></div>
            <div class="formSPR" >
                <form  class="formSPRzwy">
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="username" data-valid="^[a-zA-Z\u4e00-\u9fa5]+$" placeholder="Name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="tel" name="usermobile" placeholder="Tel" data-valid="^1+\d{10}$">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <img data-src="img/weixin.png" class="weixin">
            <ul class="shareAndDrive clearfix">
                <li><img data-src="img/share.png" class="shareBtn"></li>
                <li><img data-src="img/renxingTest.png" class="successDrive"></li>
            </ul>
        </div>
        <!-- 第一次抽奖并且没有中奖 -->
        <div  class="Enter">
            <div class="whichPrice"></div>
            <img data-src="img/must.png" class="mustBtn" >
	        <img data-src="img/playAgain.png" class="playAgainBtn">
	        <img data-src="img/testDrive.png" class="testDriveBtn">
        </div>
        <!-- 任性抽奖的页面 -->
        <div  class="Enter">
            <div class="whichPrice"></div>
            <div class="formSPR">
                <form>
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="username" data-valid="^[a-zA-Z\u4e00-\u9fa5]+$" placeholder="Name">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="tel" name="usermobile" placeholder="Tel" data-valid="^1+\d{10}$">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <img data-src="img/weixin.png" class="weixin">
            <ul class="shareAndDrive renXing clearfix">
                <li><img data-src="img/renxingShare.png" class="shareBtn"></li>
                <li><img data-src="img/renxingTest.png" class="successDrive"></li>
                <li><img data-src="img/renxingAgain.png" class="renxingAgain"></li>
            </ul>
        </div>
        <!-- 此页面 end -->
    </div>

    <div class="swiper-slide" data-flag="hasPrizeAndEnterAgain">
        <!-- 中奖后第二次进入-->
        <div class="Enter" style="display:block;">
            <div class="whichPrice" id="hasPrizeAndEnterAgainImg"></div>
            <ul class="shareAndDrive clearfix">
                <li><img src="img/share.png" class="shareBtn"></li>
                <li><img src="img/renxingTest.png" class="successDrive"></li>
            </ul>
            <img src="img/weixin.png" class="weixin" style="margin-top: 4%;">
        </div>
        <!-- 此页面 end -->
    </div>
</div>
</div>

<audio id="bg_audio" class="bg-audio" autobuffer autoloop loop autoplay>
    <source src="audio/bg.mp3?v=<?php echo time();?>">
    <source src="audio/bg.ogg?v=<?php echo time();?>">
</audio>
<!--swiper end-->
<script type="text/javascript" src="scripts/zepto.min.js"></script>
<script type="text/javascript" src="scripts/zepto.fx_methods.js"></script>
<script type="text/javascript" src="scripts/fuc.js"></script>
<script type="text/javascript" src="scripts/index.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="scripts/testDrive.js?v=<?php echo time();?>"></script>
</body>
</html>