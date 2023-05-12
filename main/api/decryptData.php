<?php
    session_start();
    //账号需重新登录
    if(!isset($_SESSION['loginAccount'])){
        exit(json_encode([
            'opCode'=>101,
            'message'=>'未登录'
        ]));//未登录代码
    }
    //解码信息
    $private_key_res = openssl_pkey_get_private($_SESSION['loginPrivateKey']);
    //解码，可能出现加号被转成空格的情况
    $eninfo = base64_decode(str_replace(' ','+', $content));
    //解密
    openssl_private_decrypt($eninfo, $content, $private_key_res);
    //提交的数据是否正确
    $dataArray = @json_decode($content,true) or exit(json_encode([
        'opCode'=>200,
        'message'=>'提交的数据异常',
        'sessionId'=>session_id()
    ]));
    $redis = new Redis();
    @$redis->connect('127.0.0.1',6379) or exit(json_encode([
        'opCode'=>200,
        'message'=>'连接错误'
    ]));;
    $redis->select(0);
    $result = $redis->get($_SESSION['loginAccount']);
    $redis->close();
    if(!$result||$result!=$dataArray['token']){
        exit(json_encode([
            'opCode'=>101,
            'message'=>'重复登录'
        ]));
    }