<?php

use api\Database;

session_start();
header('Content-Type:application/json;charset=utf-8');
//3秒内请求过多
if (isset($_SESSION['loginTime']) && time() - $_SESSION['loginTime'] < 3) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '请求次数过多,3秒后再尝试'
    ]));
}
$_SESSION['loginTime'] = time();
//获取原始数据
$content = file_get_contents("php://input");
//获取用户输入的用户名密码
$account = $content['account'];
$password = $content['password'];
//账号或密码不能为空
if (!$account || !$password) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '账号或密码不能为空'
    ]));
}
//连接数据库
include_once './database.php';
$sql = "select id, account, password, authority, name from " . Database::$accountTable . " where account = ?";
//账号密码是否正确
//账号不存在
if (($result = Database::execute($sql, $account))->rowCount() != 1) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '账号不存在'
    ]));
}
//密码错误 //使用哈希匹配
$infoList = $result->fetch(PDO::FETCH_ASSOC);
if (!password_verify($password, $infoList['password'])) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '密码错误'
    ]));
}
//已登录
//设置用户SESSION
$_SESSION['loginId'] = $infoList['id'];
$_SESSION['loginAccount'] = $infoList['account'];
$_SESSION['loginAuthority'] = $infoList['authority'];
$_SESSION['loginName'] = $infoList['name'];
//设置token
$token = rand(1000000000, 9999999999);
$_SESSION['token'] = $token;
//成功登录
exit(json_encode([
    'opCode' => 100,
    'message' => '登录成功'
]));