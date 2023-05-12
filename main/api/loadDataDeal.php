<?php
    session_start();
    //解码信息
    $private_key_res = openssl_pkey_get_private($_SESSION['loadPrivateKey']);
    //解码，可能出现加号被转成空格的情况
    $eninfo = base64_decode(str_replace(' ','+', $content));
    //解密
    openssl_private_decrypt($eninfo, $content, $private_key_res);
    //提交的数据是否正确
    @$dataArray = json_decode($content,true) or exit(json_encode([
        'opCode'=>200,
        'message'=>'提交的数据异常'
    ]));
