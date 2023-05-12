<?php
    header('Content-Type:application/json;charset=utf-8');
    //3秒内请求过多
    if(isset($_SESSION['loginTime'])&&time()-$_SESSION['loginTime']<3){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'请求次数过多,3秒后再尝试'
        ]));
    }
    $_SESSION['loginTime'] = time();
    //获取原始数据
    $content = file_get_contents("php://input");
    //检查是否获取公钥并解密为$dataArray
    include_once './loadDataDeal.php';
    //获取用户输入的用户名密码
    $account = $dataArray['account'];
    $password = $dataArray['password'];
    //账号或密码不能为空
    if(!$account||!$password){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'账号或密码不能为空'
        ]));
    }
    //连接数据库
    include_once './database.php';
    $sql = "select id,account,password,authority,name from ".Database::$accountTable." where account=?";
    //账号密码是否正确
    //账号不存在
    if(($result=Database::execute($sql,$account))->rowCount()!=1){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'账号不存在'
        ]));
    }
    //密码错误 //使用哈希匹配
    $infoList = $result->fetch(PDO::FETCH_ASSOC);
    if(!password_verify($password,$infoList['password'])){
        exit(json_encode([
            'opCode'=>200,
            'message'=>'密码错误'
        ]));
    }
    //已登录
    //设置用户SESSION
    $_SESSION['loginId'] = $infoList['id'];
    $_SESSION['loginAccount'] = $infoList['account'];
    $_SESSION['loginAuthority'] = $infoList['authority'];
    $_SESSION['loginName'] = $infoList['name'];
    //制作登录钥匙对
    $config = array(
        "digest_alg"    => "sha512",
        "private_key_bits" => 4096,           //字节数  512 1024 2048  4096 等 ,不能加引号，此处长度与加密的字符串长度有关系，可以自己测试一下
        "private_key_type" => OPENSSL_KEYTYPE_RSA,   //加密类型
    );
    $res = openssl_pkey_new($config); 
    //提取私钥
    openssl_pkey_export($res, $private_key); 
    //生成公钥
    $public_key = openssl_pkey_get_details($res);
    $public_key = $public_key["key"];
    //保存登录钥匙对
    $_SESSION['loginPrivateKey'] = $private_key;
    $_SESSION['loginPublicKey'] = $public_key;
    //设置token
    $token = rand(1000000000,9999999999);
    $_SESSION['token'] = $token;
    $redis = new Redis();
    $redis->connect('127.0.0.1',6379);
    $redis->select(0);
    $redis->set($_SESSION['loginAccount'],$token,1*30*60);
    $redis->close();
    //成功登录
    exit(json_encode([
        'opCode'=>100,
        'message'=>'登录成功'
    ]));