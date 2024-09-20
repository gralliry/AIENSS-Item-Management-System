<?php
//爬虫ua识别已在nginx开启,这里不用开启,而且好像还检测不出来
//获取请求头
if (empty($_SERVER["HTTP_USER_AGENT"])) {
    //诈骗网站
    header('location:https://www.bilibili.com/video/BV1GJ411x7h7');
    exit;
}
?>
<!DOCTYPE html><!--这是一个声明指明是HTML5-->
<html lang='zh-CN'>

<head>
    <meta charset='utf-8'>
    <!--浏览器配置-->
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0,maxinum-scale=1.0,user-scalable=no;'>
    <title>自科部物品借用管理</title>
    <link href='src/css/login_register.css?v=20230201' rel='stylesheet' type='text/css'>
    <link href='src/css/animation.css?v=20230201' rel='stylesheet' type='text/css'>
    <link href='src/css/font/iconfont.css?v=20230201' rel='stylesheet' type='text/css'>
</head>

<body>
<div id='loginBox' class='startPage'>
    <summary class='title'>自科部物品管理系统</summary>
    <!-- security_check -->
    <form id='loginForm' onsubmit="return false;">
        <input id='loginAccount' type='text' required placeholder='账号' value="">
        <input id='loginPassword' type='password' required placeholder='密码' value="">
        <div class="btnBar">
            <button id='loginSubmitBtn' type='submit'>登录</button>
            <button id='registerBtn' type='button'>注册</button>
        </div>
    </form>
</div>
<div id="registerBox" class="startPage">
    <summary class='title'>自科部账号注册</summary>
    <!-- register_check -->
    <form id='registerForm' onsubmit="return false;" method='post'>
        <label for='registerAccount'></label><input id='registerAccount' type='email' required placeholder='邮箱'>
        <label for='registerPassword'></label><input id='registerPassword' type='password' required placeholder='密码'>
        <label for='registerCode'></label><input id='registerCode' type='text' required placeholder='验证码'>
        <div class="btnBar">
            <button id='registerSubmitBtn' type='submit'>提交</button>
            <button id="getCodeBtn" type="button" title="获取验证码">获取</button>
            <button id='turnBackBtn' type='button' title="返回登录页面">返回</button>
        </div>
    </form>
</div>
<div id='popWindow' class='box'>
    <i><span class="iconfont icon-warning"></span></i>
    <p></p>
</div>
<div id='loadingBar'></div>
<script type='text/javascript' src='src/js/jquery.min.js?v=20230201'></script>
<script type='text/javascript' src='src/js/function.js?v=20230201'></script>
<script type='text/javascript' src='src/js/login_register.js?v=20230201'></script>
</body>

</html>