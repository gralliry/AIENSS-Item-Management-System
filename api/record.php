<?php

use api\Database;

header('Content-Type:application/json;charset=utf-8');
include_once './verify.php';
//获取原始数据
$content = file_get_contents("php://input");
//获取数据
$itemId = $content['itemId'];
$itemName = $content['itemName'];
//连接数据库
include_once './database.php';
//物品不存在
$sql = "select * from " . Database::$itemTable . " where id=? and name=?";
if (!Database::execute($sql, $itemId, $itemName)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '物品不存在'
    ]));
}
//准备预处理 //写入操作信息
$sql = "select accountname,borrowquantity,borrowtime,isreturn,returntime from " . Database::$operationTable . " where itemid=? and itemname=?";
if (!($info = Database::execute($sql, $itemId, $itemName))) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '获取失败'
    ]));
}
$returnData = [];
while ($result = $info->fetch(PDO::FETCH_ASSOC)) {
    // //私钥加密后的数据
    // openssl_private_encrypt(json_encode($result),$encrypted,$_SESSION['loginPrivateKey']);
    // // 加密后的内容通常含有特殊字符，需要base64编码转换下
    // array_unshift($returnData,base64_encode($encrypted));

    array_unshift($returnData, $result);
}
//成功获取
exit(json_encode([
    'opCode' => 100,
    'message' => '获取成功',
    'sessionId' => session_id(),
    'data' => $returnData
]));