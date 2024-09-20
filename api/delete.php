<?php

use api\Database;

header('Content-Type:application/json;charset=utf-8');
include_once './verify.php';
//获取原始数据
$content = file_get_contents("php://input");
//获取数据
$itemId = $content['itemId'];
$itemName = $content['itemName'];
$itemQuantity = (int)$content['itemQuantity'];
//修改物品数量存在问题
if ($itemQuantity < 0) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '借用物品数量存在问题',
    ]));
}
//是否为管理员
if ($_SESSION['loginAuthority'] != 3) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '权限不足',
    ]));
}
//连接数据库
include_once './database.php';
//物品不存在
$sql = "select * from " . Database::$itemTable . " where id=? and name=? and quantity=?";
if (!Database::execute($sql, $itemId, $itemName, $itemQuantity)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '物品不存在',
    ]));
}
//物品是否有人借用
$sql = "select * from " . Database::$operationTable . " where itemid=? and isreturn=0";
if (Database::execute($sql, $itemId)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '有人还未归还该物品',
    ]));
}
//删除物品信息
$sql = "delete from " . Database::$itemTable . " where id=?";
if (!Database::execute($sql, $itemId)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '删除失败'
    ]));
}
//写入日志
$sql = "insert into " . Database::$logTable . " set time=?,action=?,item=?,quantity=?";
if (!Database::execute(
    $sql,
    date("Y-m-d H:i:s", time()),
    'delete',
    $itemName,
    $itemQuantity
)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '写入日志失败'
    ]));
}
//成功获取
exit(json_encode([
    'opCode' => 100,
    'message' => '删除成功'
]));