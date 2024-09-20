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
$borrowQuantity = (int)$content['borrowQuantity'];
//时间暂时无用
$year = $content['year'];
$month = $content['month'];
$day = $content['day'];
//借用物品数量存在问题
if ($borrowQuantity <= 0 || $borrowQuantity > $itemQuantity) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '借用物品数量存在问题'
    ]));
}
// 日期格式存在问题
if (!checkdate((int)$month, (int)$day, (int)$year)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '日期格式存在问题'
    ]));
}
//日期不能早于今天
if (strtotime($year . '-' . $month . '-' . $day . ' 23:59:59') < time()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '日期不能早于今天'
    ]));
}
//是否为用户及以上
if ($_SESSION['loginAuthority'] < 2) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '权限不足'
    ]));
}
//连接数据库
include_once './database.php';
//是否借用了该物品未归还
$sql = "select * from " . Database::$operationTable . " where accountid=? and itemid=? and isreturn=0";
if (Database::execute($sql, $_SESSION['loginId'], $itemId)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '已借用该物品',
    ]));
}
// 修改物品信息
$sql = 'update ' . Database::$itemTable . " set quantity=quantity-? where id=? and quantity>=?";
if (!Database::execute($sql, $borrowQuantity, $itemId, $borrowQuantity)->rowCount()) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '借用失败'
    ]));
}
//写入操作信息
$sql = "insert into " . Database::$operationTable . " set accountid=?,accountname=?,itemid=?,itemname=?,borrowquantity=?";
if (!Database::execute(
    $sql,
    $_SESSION['loginId'],
    $_SESSION['loginName'],
    $itemId,
    $itemName,
    $borrowQuantity
)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '信息更新失败'
    ]));
}
//成功获取
exit(json_encode([
    'opCode' => 100,
    'message' => '借用成功'
]));