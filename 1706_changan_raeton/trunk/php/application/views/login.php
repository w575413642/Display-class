<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8" />
    <title>试驾数据收集 </title>
    <style type="text/css">
        *{ padding:0; margin:0;}
        body{ text-align:center; background:#4974A4;}
        #login{ width:740px; margin:0 auto; font-size:12px;}
        #loginlogo{ width:700px; height:100px; overflow:hidden; background:url('images/login_logo.png') no-repeat; margin-top:50px;   }
        #loginpanel{ width:729px; position:relative;height:300px;}
        .panel-h{ width:729px; height:20px; background:url('images/panel-h.gif') no-repeat; position:absolute; top:0px; left:0px; z-index:3;}
        .panel-f{ width:729px; height:13px; background:url('images/panel-f.gif') no-repeat; position:absolute; bottom:0px; left:0px; z-index:3;}
        .panel-c{ z-index:2;background:url('images/panel-c.gif') repeat-y;width:729px; height:300px;}
        .panel-c-l{ position:absolute; left:60px; top:40px;}
        .panel-c-r{ position:absolute; right:20px; top:50px; width:222px; line-height:200%; text-align:left;}
        .panel-c-l h3{ color:#556A85; margin-bottom:10px;}
        .panel-c-l td{ padding:7px;}
        
        
        .login-text{ height:24px; left:24px; border:1px solid #e9e9e9; background:#f9f9f9;}
        .login-text-focus{ border:1px solid #E6BF73;}
        .login-btn{width:114px; height:29px; color:#E9FFFF; line-height:29px; background:url('images/login-btn.gif') no-repeat; border:none; overflow:hidden; cursor:pointer;}
        #txtUsername,#txtPassword{ width:191px;} 
        #logincopyright{ text-align:center; color:White; margin-top:50px;}
    </style>
</head>
<body style="padding:10px"> 
    <div id="login">
        <div id="loginlogo"></div>
        <div id="loginpanel">
            <div class="panel-h"></div>
            <div class="panel-c">
                <div class="panel-c-l">
                    <form action="index.php?c=login" method="post">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                         <tr>
                            <td align="left" colspan="2"> 
                             <h3>欢迎使用</h3>
                            </td>
                            </tr> 
                            <tr>
                            <td align="right">账号：</td>
                            <td align="left">
                                <input type="text" name="username" id="txtUsername" class="login-text" 
                                value=""/>
                            </td>
                            </tr>
                            <tr>
                            <td align="right">密码：</td>
                            <td align="left">
                                <input type="password" name="password" id="txtPassword" class="login-text" 
                                value=""/>
                            </td>
                            </tr> 
                            <tr>
                            <td align="center" colspan="2">
                                <input type="submit" id="btnLogin" value="登陆" class="login-btn" />
                            </td>
                            </tr>
                            <tr>
                            <td align="center" colspan="2">
                                <div style="color: red"><?php echo isset($message)?$message:'' ;?></div>
                            </td>
                            </tr> 
                        </tbody>
                    </table>
                    </form>
                </div>
                <div class="panel-c-r">
                <p>请从左侧输入登录账号和密码登录</p>
                <p>如果遇到系统问题，请联系网络管理员。</p>
                <p>如果没有账号，请联系网站管理员。 </p>
                <p>......</p>
                </div>
            </div>
            <div class="panel-f"></div>
        </div>
         <div id="logincopyright">Copyright © 2014  </div>
    </div>
</body>
</html>
