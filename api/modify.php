<?php

use api\Database;

header('Content-Type:application/json;charset=utf-8');
include_once './verify.php';
//获取原始数据
//获取原始数据
$content = file_get_contents("php://input");
//解码JSON数据
$content = json_decode($content, true);
//获取数据
$itemId = $content['itemId'];
$itemName = $content['itemName'];
$itemQuantity = (int)$content['itemQuantity'];
//修改物品数量存在问题
if ($itemQuantity < 0) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '修改物品数量存在问题'
    ]));
}
//是否为管理员
if ($_SESSION['loginAuthority'] != 3) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '权限不足'
    ]));
}
//连接数据库
include_once './database.php';
//物品不存在
$sql = "select * from " . Database::$itemTable . " where id = ?";
if (!($result = Database::execute($sql, $itemId))->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '物品不存在',
    ]));
}
//获取旧数据
$result = $result->fetch(PDO::FETCH_ASSOC);
$oldName = $result['name'];
$oldQuantity = $result['quantity'];
//准备预处理
//更新物品信息
$sql = "update " . Database::$itemTable . " set name=?,quantity=? where id=?";
if (!Database::execute($sql, $itemName, $itemQuantity, $itemId)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '修改失败'
    ]));
}
//写入操作信息
$sql = "update " . Database::$operationTable . " set itemname=? where itemid=?";
if (!Database::execute($sql, $itemName, $itemId)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '修改失败'
    ]));
}
//写入日志
$sql = "insert into " . Database::$logTable . " set time=?,action=?,item=?,quantity=?,newname=?,newquantity=?";
if (!Database::execute(
    $sql,
    date("Y-m-d H:i:s", time()),
    'modify',
    $oldName,
    $oldQuantity,
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
    'message' => '修改成功'
]));