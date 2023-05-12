<?php
class Database{
    // 静态用self 非静态用this
    //本地模式
    // private static $dsn = "mysql:host=127.0.0.1;port=3306;dbname=myweb";
    // private static $userName = "myweb";
    // private static $userPassword = "my_web";
    //服务器模式
    private static $dsn = "mysql:host=127.0.0.1;port=3306;dbname=item_forye_top";
    private static $userName = "item_forye_top";
    private static $userPassword = "asJwbkb8fLj326i6";

    public static $accountTable = 'account';
    public static $itemTable = 'item';
    public static $logTable = 'log';
    public static $operationTable = 'operation';
    public static $ipTable = 'ip';

    private static $database;
    // 直接执行SQL指令 // 需要防止sql注入
    public static function execute($command,...$content){
        // 构造预处理命令
        $stmt = self::$database->prepare($command);
        // 写入参数
        for($i=1,$j=count($content);$i<=$j;$i++){
            $stmt->bindValue($i,$content[$i-1]);
        }
        // 执行成功
        if($stmt->execute()){
            return $stmt;
        }else{
            exit(json_encode([
                'opCode'=>321,
                'message'=>'数据获取异常'
            ]));//数据库执行异常代码
        }
    }
    // 连接数据库
    public static function connect(){
        self::$database = new PDO(self::$dsn,self::$userName,self::$userPassword);
        if(self::$database->errorCode()){//是否连接数据库成功
            exit(json_encode([
                'opCode'=>320,
                'message'=>'数据库异常'
            ]));//数据库异常代码
        }else return true;
    }
    // 返回最后操作的id
    public static function getLastId(){
        return self::$database->lastInsertId();
    }
}
//创建数据库
Database::connect();