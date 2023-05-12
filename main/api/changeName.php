<?php
    header('Content-Type:application/json;charset=utf-8');
    //获取原始数据
    $content = file_get_contents("php://input");
    //检查是否获取公钥并解密为$dataArray
    include_once './decryptData.php';
    //获取数据
    $name = $dataArray['name'];
    //名字是否为空
    if(!$name){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'名字不能为空',
        ]));
    }
    //名字不能超过八个字
    if(8<mb_strlen($name,'utf8')){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'名字不能超过八个字',
        ]));
    }
    //连接数据库
    include_once './database.php';
    //准备预处理 //写入操作信息
    //修改账号表
    $sql = "update ".Database::$accountTable." set name=? where id=?";
    if(!Database::execute($sql,$name,$_SESSION['loginId'])){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'修改失败'
        ]));
    }
    $_SESSION['loginName'] = $name;
    //修改操作表
    $sql = "update ".Database::$operationTable." set accountname=? where accountid=?";
    if(!Database::execute($sql,$name,$_SESSION['loginId'])){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'修改失败'
        ]));
    }
    //成功获取
    exit(json_encode([
        'opCode'=>100,
        'message'=>'修改成功'
    ]));