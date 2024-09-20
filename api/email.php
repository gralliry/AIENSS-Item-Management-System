<?php
header('Content-Type:application/json;charset=utf-8');
include_once './verify.php';
//获取原始数据
$content = file_get_contents("php://input");
//获取用户输入的账号
$account = $content['account'];
//邮箱无效
if (!filter_var($account, FILTER_VALIDATE_EMAIL)) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '邮箱无效'
    ]));
}
//10秒内请求过多
if (isset($_SESSION['registerTime']) && time() - $_SESSION['registerTime'] < 10) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '请求次数过多,10秒后再尝试'
    ]));
}
// 引入PHPMailer的核心文件
require_once './email/Exception.php';
require_once './email/PHPMailer.php';
require_once './email/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$fromName = '校科联自然科学部';
$fromEmail = '1579405324@qq.com';
// 保密!!!!
$password = 'kqcmawnajsybibba';
try {
    // 实例化PHPMailer核心类
    $mail = new PHPMailer(true);
    // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    // $mail->SMTPDebug = 1;
    // 使用smtp鉴权方式发送邮件
    $mail->isSMTP();
    // smtp需要鉴权 这个必须是true
    $mail->SMTPAuth = true;
    // 链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.qq.com';
    // 设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';
    // 设置ssl连接smtp服务器的远程服务器端口号
    $mail->Port = 465;
    // 设置发送的邮件的编码
    $mail->CharSet = 'UTF-8';
    // 邮件正文是否为html编码 注意此处是一个方法
    $mail->isHTML(false);
    // 发件人设置
    // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = $fromName;
    // 设置发件人邮箱地址 同登录账号
    $mail->From = $fromEmail;
    // smtp登录的账号 QQ邮箱即可
    $mail->Username = $fromEmail;
    // smtp登录的密码 使用生成的授权码
    $mail->Password = $password;
    // 设置收件人邮箱地址 // 添加多个收件人 则多次调用方法即可
    $mail->addAddress($account);
    // 添加该邮件的主题
    $mail->Subject = '校科联自然科学部物品借用系统账号注册';
    // 选择验证码
    $code = rand(100000, 999999);
    // 添加邮件正文
    $mail->Body = '您好，您的验证码为:' . $code;
    if (!$mail->send()) {
        exit(json_encode([
            'opCode' => 502,
            'message' => '验证码发送失败'
        ]));
    }
} catch (Exception $e) {
    exit(json_encode([
        'opCode' => 200,
        'message' => '验证码获取失败'
    ]));
}
// 写入验证码
$_SESSION['registerAccount'] = $account;
$_SESSION['registerCode'] = $code;
$_SESSION['registerTime'] = time();
exit(json_encode([
    'opCode' => 100,
    'message' => '验证码已发送'
]));