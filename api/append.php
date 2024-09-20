<?php

use api\Database;

header('Content-Type:application/json;charset=utf-8');
include_once './verify.php';
//获取原始数据
$content = file_get_contents("php://input");
//获取数据
$itemName = $content['itemName'];
$itemQuantity = (int)$content['itemQuantity'];
//名字不能为空
if (!$itemName) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '物品名字不能为空'
    ]));
}
//添加物品数量存在问题
if ($itemQuantity <= 0) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '物品数量存在问题'
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
//查找物品是否存在
$sql = "select * from " . Database::$itemTable . " where name=?";
if (Database::execute($sql, $itemName)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '该物品已存在'
    ]));
}
//写入物品信息
$sql = "insert into " . Database::$itemTable . " set name=?,quantity=?";
//添加成功
if (!Database::execute($sql, $itemName, $itemQuantity)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '添加失败'
    ]));
}
//获取它的id,注意这里是非线程安全的
$sql = "select max(id) from " . Database::$itemTable;
if (!($result = Database::execute($sql))->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => 'ID获取失败'
    ]));
}
$returnData = $result->fetch(PDO::FETCH_ASSOC);
//写入日志
$sql = "insert into " . Database::$logTable . " set time=?,action=?,item=?,quantity=?";
if (!Database::execute(
    $sql,
    date("Y-m-d H:i:s", time()),
    'append',
    $itemName,
    $itemQuantity
)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '写入日志失败'
    ]));
}
exit(json_encode([
    'opCode' => 100,
    'message' => '添加成功',
    'data' => [
        'lastId' => $returnData['max(id)']
    ]
]));