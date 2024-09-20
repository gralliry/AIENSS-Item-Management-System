<?php
session_start();
//账号需重新登录
if (!isset($_SESSION['loginAccount'])) {
    exit(json_encode([
        'opCode' => 101,
        'message' => '未登录'
    ]));//未登录代码
}