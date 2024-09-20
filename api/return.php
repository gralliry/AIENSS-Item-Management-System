<?php

use api\Database;

header('Content-Type:application/json;charset=utf-8');
include_once './verify.php';
//获取原始数据
$content = file_get_contents("php://input");
//解码JSON数据
$content = json_decode($content, true);
//获取数据
$itemId = $content['itemId'];
$itemName = $content['itemName'];
$borrowQuantity = (int)$content['borrowQuantity'];
//是否为用户及以上 //只有用户及以上才可以借用物品
if ($_SESSION['loginAuthority'] < 2) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '权限不足'
    ]));
}
//连接数据库
include_once './database.php';
// 修改物品数量信息
$sql = 'update ' . Database::$itemTable . " set quantity=quantity+? where id=? and name=?";
if (!Database::execute($sql, $borrowQuantity, $itemId, $itemName)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '物品不存在'
    ]));
}
// 修改操作信息
$sql = "update " . Database::$operationTable . " set isreturn=1,returntime=? where accountid=? and itemid=? and isreturn=0";
if (!Database::execute($sql, date("Y-m-d H:i:s", time()), $_SESSION['loginId'], $itemId)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '信息更新失败'
    ]));
}
//成功获取
exit(json_encode([
    'opCode' => 100,
    'message' => '归还成功'
]));