<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>CS55占座行动，旅行试驾、豪礼大奖等你来！</title>
    <meta name="keywords" itemprop="name" content="CS55占座行动，旅行试驾、豪礼大奖等你来！"/>
    <meta name="description" itemprop="description" content="CS55占座行动，旅行试驾、豪礼大奖等你来！"/>
    <meta name="content" itemprop="image" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <link href="css/idangerous.swiper.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="css/index.css?rand=<?php echo rand(10000, 99999)?>" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
    <script type="text/javascript" src="<?php echo site_url('c=api')?>"></script>
  <!-- <script>
    window.shearData = {};
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?4bd135ed274e675e539c8d3ebecb3ef0";
      var s = document.getElementsByTagName("script")[0];
      s.parentNode.insertBefore(hm, s);
    })();
    </script> -->
    <script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?6e72448173e718c74336d71d7a8f2f00";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
  </head>
  <body>
    <div class="bdwrap">
    <!-- logo -->
    <img src="img/logo.png" class="logo"/>
    <img src="img/landscape-logo.png" class="landscape-logo"/>

    <div class="abs">
      <!-- loading -->
      <div class="page loading show">
        <div class="loader">
          <div class="loader-inner line-spin-fade-loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <p> 0 </p>
          </div>
          <p class="tip">
            loading...
          </p>
        </div>
        <div class="car">
          <img src="img/car.png"/>
          <img src="img/car-go.png" id="loading-car"/>
        </div>
      </div>
      <!-- /loading -->
    </div>