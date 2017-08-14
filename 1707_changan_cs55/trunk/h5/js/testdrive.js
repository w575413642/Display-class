var clickable = true;
var availableDealersOnly=[],availableCity=[],availableTown=[];

// function ale(text){
//     iosOverlay({
//         text: text,
//         duration: 2e3
//     });
//     return false;
// }
function Testdrive(config){
	var defaults = {
		debug:1,	//是否调试 主要作用是不提交数据到长安DMS
		baseurl:'//e.changan.com.cn/changan_dealers/api.php?appkey=212C9F1F9C02A967352C0935DD9CDA20&',//长安DMS接口URL
		ctiurl:'',	//个人后台地址URL
		from_source:'PC',	//来源
		aid:'',		//活动id 由长安提供
		op:"",		//留资类型 try：预约试驾 order：在线订车
		cartype:'',	//车系类型 vc_：商用车 jc_:乘用车
		carcode:'',	//车系编码
		carname:'',	//车系名字
		cartypeEle:$("#cartype"),	//车系类型Element
		carcodeEle:$("#carcode"),	//车系名称Element
		carlevel:"2",				//级别	1：长安汽车，2：车系，3：车型，4：配置。
		carbrand:"1",				//品牌类型 1=轿车，2=商用车，3=轻型车
		unameEle: $("#uname"),		//姓名Element
		umobileEle: $("#umobile"),	//电话Element
		usexEle:$("#usex"),			//性别Element
		provinceEle: $("#province"),//省份Element
		cityEle: $("#city"),		//城市Element
		townEle:$("#town"),			//地区Element
		dealerEle:$("#dealer"),		//经销商Element
		dtimeEle:'',				//到店日期Element
		otimeEle:'',				//购车日期Element
		submitBtn:$("#submitdrive"),//提交按钮Element
		cartypeText:'车系类型',		//车系类型select第一项汉字
		carcodeText:'选择车系',		//车系select第一项汉字
		sexText:'您的性别',			//性别select第一项汉字
		provinceText:'选择省份',	//省份select第一项汉字
		cityText:'选择城市',		//城市select第一项汉字
		townText:'选择地区',		//地区select第一项汉字
		dealerText:'选择经销商',	//经销商select第一项汉字
		hasRaffle:false,			//是否有抽奖
		cartypechange:function(){},	//车系类型选中的用户自定义回调
		carcodechange:function(){},	//车系选中的用户自定义回调
		sexchange:function(){},		//性别选中的用户自定义回调
		provincechange:function(){},//省份选中的用户自定义回调
		citychange:function(){},	//城市选中的用户自定义回调
		townchange:function(){},	//地区选中的用户自定义回调
		dealerchange:function(){},	//经销商选中的用户自定义回调
		submitdrive:function(){}	//提交数据后的回调
	}
	config = $.extend({province:'',city:'',town:'',dealer:''},defaults,config);
	var othis = this;
	// 车型 ----  车系  ------- 省  市   区
	this.init=function(){
			for(var j=0;j<availableDealers.length;j++){
				var dealerItem = availableDealers[j];
				availableDealersOnly.push(dealerItem.dealer);
				availableCity.push(dealerItem.city);
				availableTown.push(dealerItem.town);
			}
			if(config.cartype=='' && config.carcode==''){//没有确定车系类型和车系
				config.cartypeEle.change(function(){
					config.carcodeEle.html("");
					othis.loadcarname($(this));  
				});
				//车系改变
				config.carcodeEle.change(function(){
					config.provinceEle.html("");
					othis.loadprovince($(this));
				});
			}else if(config.cartype!='' && config.carcode ==''){//确定了车系类型没有确定车系
					//车系改变
					config.carcodeEle.change(function(){
						config.provinceEle.html("");
						othis.loadprovince($(this));
					});
					config.carcodeEle.html("");
					othis.loadcarname(config.cartype);
			}else if(config.cartype != '' && config.carcode != ''){//确定了车系类型和车系
				othis.loadprovince(config.carcode);
				//console.log(config.carcode);
			}/*
			if(config.usexEle != undefined){
				//性别改变
				config.usexEle.change(function(){
					othis.sexchange($(this));
				});
			}*/
			//省份改变
			config.provinceEle.change(function(){
				othis.provincechange($(this));
			});
			//城市改变
			config.cityEle.change(function(){
				othis.citychange($(this));
			});
			//地区改变
			config.townEle.change(function(){
				othis.townchange($(this));
			});
			//经销商改变
			config.dealerEle.change(function(){
				othis.dealerchange($(this));
			});
			//提交绑定
			config.submitBtn.click(function(){
				othis.submitdrive();
			});
	},
	this.loadcarname=function(e){
		if(typeof e =='string'){
			config.cartype = e;
		}else{
			config.cartypechange(e);
			config.cartype=e.val();
		}
		config.carcodeEle.html("<option value=0>"+config.carcodeText+"</option>");
		config.provinceEle.html("<option value=0>"+config.provinceText+"</option>");
		config.cityEle.html("<option value=0>"+config.cityText+"</option>");
		config.townEle.html("<option value=0>"+config.townText+"</option>");
		config.dealerEle.html("<option value=0>"+config.dealerText+"</option>");
		if(config.cartype==0) return;
		var carcodelist = '<option value=0>'+config.carcodeText+'</option>'+
						'<option value="S301">2016款 cs75</option>';
		config.carcodeEle.html(carcodelist);
		// $.ajax({
			// url:config.baseurl+"m=group&stype="+config.cartype+"&level="+config.carlevel,
			// type: "GET",
			// dataType:'jsonp',
			// success:function(jsondata){
				// var carnameoptionhtml = '<option value=0>'+config.carcodeText+'</option>';
				// for(var i=0;i<jsondata.length;i++){
					// carnameoptionhtml += "<option value='"+jsondata[i].groupCode+"'>"+jsondata[i].groupName+"</option>";
				// }
				// config.carcodeEle.html(carnameoptionhtml);
			// }
		// });
	},
	this.loadprovince=function(e){
		if(typeof e =='string'){
			config.carcode = e;
		}else{
			config.carcodechange(e);
			config.carcode = e.val();
			config.carname = e.find("option").not(function(){ return !this.selected }).text();
		}
		//alert(config.carname);
		config.provinceEle.html("<option value=0>"+config.provinceText+"</option>");
		config.cityEle.html("<option value=0>"+config.cityText+"</option>");
		config.townEle.html("<option value=0>"+config.townText+"</option>");
		config.dealerEle.html("<option value=0>"+config.dealerText+"</option>");
		if(config.carcode==0)	return;
		//}
		$.ajax({
			url:config.baseurl+"m=province&stype="+config.cartype+"&groupCode="+config.carcode,
			type: "GET",
			dataType:'jsonp',
			success:function(jsondata){
				var prooptionhtml = '<option value=0>'+config.provinceText+'</option>';
				for(var i=0;i<jsondata.length;i++){
					prooptionhtml += "<option value='"+jsondata[i].regionCode+"'>"+jsondata[i].regionName+"</option>";
				}
				config.provinceEle.html(prooptionhtml);
			}
		});
	},
	this.sexchange=function(e){
		config.sexchange(e);
	},
	this.provincechange=function(e){
		config.provincechange(e);
		config.province = e.val();
		config.cityEle.html("<option value=0>"+config.cityText+"</option>");
		config.townEle.html("<option value=0>"+config.townText+"</option>");
		config.dealerEle.html("<option value=0>"+config.dealerText+"</option>");
		if(config.province==0)	return;
		$.ajax({
			url:config.baseurl+"m=city&stype="+config.cartype+"&groupCode="+config.carcode+"&pcode="+config.province,
			type: "GET",
			dataType:'jsonp',
			success:function(jsondata){
				var cityoptionhtml = '<option value=0>'+config.cityText+'</option>';
				for(var i=0;i<jsondata.length;i++){
					if($.inArray(jsondata[i].regionName,availableCity)>-1)
						cityoptionhtml += "<option value='"+jsondata[i].regionCode+"'>"+jsondata[i].regionName+"</option>";
				}
				config.cityEle.html(cityoptionhtml);
			}
		});
	},
	this.citychange=function(e){
		config.citychange(e);
		config.city = e.val();
		config.townEle.html("<option value=0>"+config.townText+"</option>");
		config.dealerEle.html("<option value=0>"+config.dealerText+"</option>");
		if(config.city==0)	return;
		$.ajax({
			url:config.baseurl+"m=town&stype="+config.cartype+"&groupCode="+config.carcode+"&cityid="+config.city,
			type: "GET",
			dataType:'jsonp',
			success:function(jsondata){
				var townoptionhtml = '<option value=0>'+config.townText+'</option>';
				for(var i=0;i<jsondata.length;i++){
					// console.log(availableCity);
					if($.inArray(e.find("option:selected").text(),availableCity)>-1 && $.inArray(jsondata[i].regionName,availableTown)>-1)
						townoptionhtml += "<option value='"+jsondata[i].regionCode+"'>"+jsondata[i].regionName+"</option>";
				}
				config.townEle.html(townoptionhtml);
			}
		});
		// $.ajax({
		// 	url:config.baseurl+"m=dealers&stype="+config.cartype+"&groupCode="+config.carcode+"&cityid="+config.city,
		// 	type: "GET",
		// 	dataType:'jsonp',
		// 	success:function(jsondata){
		// 		var dealeroptionhtml = '<option value=0>'+config.dealerText+'</option>';
		// 		for(var i=0;i<jsondata.length;i++){
		// 			//if($.inArray(jsondata[i].dealerName,availableDealers)>-1){
		// 				dealeroptionhtml += "<option dealerid='"+jsondata[i].dealerId+"' value='"+jsondata[i].dealerCode+"'>"+jsondata[i].dealerName+"</option>";
		// 			//}
		// 		}
		// 		config.dealerEle.html(dealeroptionhtml);
		// 	}
		// });
	},
	this.townchange=function(e){
		config.townchange(e);
		config.town = e.val();
		if(config.town==0){
			config.town = config.city;
		}
		$.ajax({
			url:config.baseurl+"m=dealers&stype="+config.cartype+"&groupCode="+config.carcode+"&cityid="+config.town,
			type: "GET",
			dataType:'jsonp',
			success:function(jsondata){
				// console.log(availableDealersOnly);
				var dealeroptionhtml = '<option value=0>'+config.dealerText+'</option>';
				for(var i=0;i<jsondata.length;i++){
					// console.log(jsondata[i].dealerName);
					if($.inArray(jsondata[i].dealerName,availableDealersOnly)>-1){
						dealeroptionhtml += "<option dealerid='"+jsondata[i].dealerId+"' value='"+jsondata[i].dealerCode+"'>"+jsondata[i].dealerName+"</option>";
					}
				}
				config.dealerEle.html(dealeroptionhtml);
			}
		});
	},
	this.submitdrive=function(){
		var uname = config.unameEle.val();
		var umobile = config.umobileEle.val();
		var usex = config.usexEle.val();
		var pro = config.provinceEle.val();
		var proName = config.provinceEle.find("option").not(function(){ return !this.selected }).text();
        var city = config.cityEle.val();
		var cityName = config.cityEle.find("option").not(function(){ return !this.selected }).text();
		var town = config.townEle.val();
		var townName = config.townEle.find("option").not(function(){ return !this.selected }).text();
		var dealerCode = config.dealerEle.val();
		var dealerName = config.dealerEle.find("option").not(function(){ return !this.selected }).text();
		var dealerId = config.dealerEle.find('option').not(function(){ return !this.selected }).attr("dealerid");
		//console.log(uname+umobile+proName+cityName+townName+town+city+pro);
		//return false;
		if(dealerId !='' && dealerId != undefined)
			dealerId = dealerId.replace(" ","");
		var dtime='',otime = '';			
		if(config.op=="try"&&config.dtimeEle!=''){
			dtime = config.dtimeEle.val();
		}
		if(config.op=="order"&&config.otimeEle !=''){
			otime = config.otimeEle.val();
		}
		//console.log(dtime);
		//return false;
        var _from = this.getParam("trail_channel_from");
        if(uname==''|| uname =='姓名'){
			alert('请输入姓名!');
		}else if(config.cartype=='' || config.cartype==0){
			alert('请选择车系类型');
		}else if(config.carcode=='' || config.carcode==0){
			alert('请选择车型');
		}else if(umobile==''){
			alert('请输入手机号码');
		}else if(umobile.length != 11 || /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(umobile) == false){
			alert('请输入正确的手机号码');
		}else if(pro==0){
			alert('请选择省份');
		}else if(city==0){
			alert('请选择城市');
		}else if(town==0){
			alert('请选择地区');
		}else if(dealerCode==0||dealerCode=='请选择经销商'){
			alert('请选择经销商');
		}else if(dtime=="试驾时间"||otime=="购买时间"){
			if (config.op=="try") {
				alert('请选择试驾时间');
			}else if(config.op=="order"){
				alert('请选择购买时间');
			}
		}else{
			var dmsurl = config.baseurl+"m=testdrive&aid="+config.aid+"&op="+config.op+"&trail_channel_from="+_from+ "&uname=" + uname + "&umobile=" + umobile + "&carcode="+config.carcode+"&carname=" +config.carname+ "&province=" + pro + "&proname=" + proName+"&city=" + city + "&cityname=" +cityName + "&town=" + town + "&townname=" + townName + "&dealercode=" + dealerCode+"&dealer=" + dealerId+ "&dealername=" + dealerName+"&brand="+config.carbrand+"&dtime="+dtime;
			if(config.op=='order'){
				dmsurl += "&otime="+otime;
			}
			//先提交到自己的后台然后再提交到接口后台
			if(clickable == false) return;
			clickable = false;
			$.ajax({
                 url: config.ctiurl + "index.php?c=api&m=testdrive_adddrive",
                 type: 'GET',
                 data: {
                     uname: uname,
                     phone: umobile,
                     procode:pro,
                     province: proName,
                     sex:usex,
                     citycode:city,
                     city:cityName,
                     dealercode:dealerCode,
                     dealerid:dealerId,
                     dealer:dealerName,
                     cartype:config.carname,
                     from_usergent:config.from_source,
					 dtime:dtime,
					 otime:otime
                 },
                 dataType: 'jsonp',
                 success: function(jsondata) {
                 	 clickable = true;
                     if (jsondata.code == "200") {
						config.submitdrive(jsondata);
                         $.ajax({
                             url: dmsurl+"&debug="+config.debug,
                             type: 'GET',
                             dataType: 'jsonp',
                             success: function(jsondata) {
                                 if (jsondata.status == "0") {
                                    //alert('提交成功');
                                 } else {
                                    //alert(jsondata.msg);
                                 }
                             }
                         });
                         if(!config.hasRaffle) alert("提交成功!");
                     }else{
                        alert(jsondata.msg);
                     }
                 },
                 error:function(){
					 alert('提交失败，请稍候再试!');
                 	clickable = true;
                 }
            });
		}
	},
	this.dealerchange=function(e){
		config.dealerchange(e);
	}
	this.getParam=function(paramName) {
	    paramValue = "", isFound = !1;
	    var that = window;  
	    if (that.location.search.indexOf("?") == 0 && that.location.search.indexOf("=") > 1) {  
	        arrSource = unescape(that.location.search).substring(1, that.location.search.length).split("&"), i = 0;  
	        while (i < arrSource.length && !isFound) arrSource[i].indexOf("=") > 0 && arrSource[i].split("=")[0].toLowerCase() == paramName.toLowerCase() && (paramValue = arrSource[i].split("=")[1], isFound = !0), i++  
	    }
		if(paramValue !=''){
			paramValue == "" && (paramValue = null), paramValue;
			return paramValue.substring(0,paramValue.indexOf("?")==-1?paramValue.length:paramValue.indexOf("?"));
		}else{
			return "OfficalWebSite";
		}
	}
}