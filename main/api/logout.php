<?php
    //获取原始数据
    $content = file_get_contents("php://input");
    //检查是否获取公钥并解密为$dataArray
    include_once './decryptData.php';
    //
    $redis = new Redis();
    $redis->connect('127.0.0.1',6379);
    $redis->select(0);
    $redis->del($_SESSION['loginAccount'],1*60*60);
    $redis->close();
    //删除session//用于退出登录
    unset($_SESSION['loginId']);
    unset($_SESSION['loginAccount']);
    unset($_SESSION['loginAuthority']);
    unset($_SESSION['loginName']);
    unset($_SESSION['loginPrivateKey']);
    unset($_SESSION['token']);
    exit;
    //loadPrivateKey
    //loadPublicKey
    //registerAccount
    //registerCode
    //registerTime

    //loginId
    //loginAccount
    //loginAuthority
    //loginName
    //loginPrivateKey
    //token