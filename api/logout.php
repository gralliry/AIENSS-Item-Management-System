<?php
include_once './verify.php';
//删除session//用于退出登录
unset($_SESSION['loginId']);
unset($_SESSION['loginAccount']);
unset($_SESSION['loginAuthority']);
unset($_SESSION['loginName']);
unset($_SESSION['token']);
exit;
