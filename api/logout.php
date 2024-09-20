<?php
include_once './verify.php';
//获取原始数据
$content = file_get_contents("php://input");
//删除session//用于退出登录
unset($_SESSION['loginId']);
unset($_SESSION['loginAccount']);
unset($_SESSION['loginAuthority']);
unset($_SESSION['loginName']);
unset($_SESSION['token']);
exit;
