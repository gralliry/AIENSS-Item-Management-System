<?php

namespace api;
class Database
{
    // 静态用self 非静态用this
    //服务器模式
    private static string $dsn;
    private static string $username;
    private static string $password;

    public static string $accountTable = 'account';
    public static string $itemTable = 'item';
    public static string $logTable = 'log';
    public static string $operationTable = 'operation';

    private static PDO $database;

    // 静态构造函数初始化数据库连接信息
    public static function init()
    {
        $host = getenv('MYSQL_HOST') ?: "120.78.82.53";
        $port = getenv('MYSQL_PORT') ?: "9001";
        $database = getenv('MYSQL_DATABASE') ?: "nss_item_manage";
        self::$dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $database;
        self::$username = getenv('MYSQL_USERNAME') ?: 'nss_item_manage';
        self::$password = getenv('MYSQL_PASSWORD') ?: 'mD3FaxpiaAtBMNCZ';
    }

    // 直接执行SQL指令 // 需要防止sql注入
    public static function execute($command, ...$content)
    {
        // 构造预处理命令
        $stmt = self::$database->prepare($command);
        // 写入参数
        for ($i = 1, $j = count($content); $i <= $j; $i++) {
            $stmt->bindValue($i, $content[$i - 1]);
        }
        // 执行成功
        if ($stmt->execute()) {
            return $stmt;
        } else {
            exit(json_encode([
                'opCode' => 321,
                'message' => '数据获取异常'
            ]));//数据库执行异常代码
        }
    }

    // 连接数据库
    public static function connect()
    {
        self::init();
        self::$database = new PDO(self::$dsn, self::$username, self::$password);
        if (self::$database->errorCode()) {//是否连接数据库成功
            exit(json_encode([
                'opCode' => 320,
                'message' => '数据库异常'
            ]));//数据库异常代码
        } else return true;
    }

    // 返回最后操作的id
    public static function getLastId()
    {
        return self::$database->lastInsertId();
    }
}

//创建数据库
Database::connect();