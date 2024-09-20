<?php
//账号需重新登录
use api\Database;

session_start();
if (!isset($_SESSION['loginAccount'])) {
    header('Location:/index.php');
}
?>
<!DOCTYPE html><!--这是一个声明指明是HTML5-->
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <!--浏览器配置-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自科部物品借用管理</title>
    <link href="src/css/mainPage.css?v=20230210.1" rel="stylesheet" type="text/css">
    <link href="src/css/animation.css?v=20230201" rel="stylesheet" type="text/css">
    <link href='src/css/font/iconfont.css?v=20230201' rel='stylesheet' type='text/css'>
</head>

<body>
<view id="mainPage" class="page">
    <header>
        <div class="quitBar">
            <span id="quitLogin" class="iconfont icon-zuojiantou" title="退出登录"></span>
        </div>
        <div class="inputBar">
            <input id="searchContent" type="search" placeholder="输入搜索的东西">
            <div><span id='searchBtn' class="iconfont icon-sousuo"></span></div>
        </div>
        <div class="infoBar">
            <div class="info">
                <!-- 权限 -->
                <span id="authority"><?php
                    $authority = $_SESSION['loginAuthority'];
                    if ($authority == 1) {
                        echo '游客';
                    } else if ($authority == 2) {
                        echo '用户';
                    } else if ($authority == 3) {
                        echo '管理员';
                    }
                    ?></span>
                <input id="name"
                       value="<?php
                       echo $_SESSION['loginName']; ?>"
                       size="<?php
                       $length = mb_strlen($_SESSION['loginName']);
                       echo $length > 3 ? $length + 1 : $length; ?>"
                       maxlength="8"
                       onkeydown="this.size=this.value.length>3?this.value.length+1:this.value.length"
                       onchange="this.size=this.value.length>3?this.value.length+1:this.value.length"
                >
                <span>，<?php
                    $hour = (int)date('H');
                    if ($hour < 6) {
                        echo "夜深了";
                    } else if ($hour < 8) {
                        echo "早上好";
                    } else if ($hour < 11) {
                        echo "上午好";
                    } else if ($hour < 13) {
                        echo "中午好";
                    } else if ($hour < 18) {
                        echo "下午好";
                    } else {
                        echo "晚上好";
                    }
                    ?></span>
            </div>
            <span class="iconfont icon-yonghu" title="显示个人借用信息"></span>
        </div>
    </header>
    <main>
        <aside>
            <ul id="showLogInfo">
                <li>日志</li>
                <?php
                //连接数据库
                include_once './api/database.php';
                //查找数据
                $sql = "select * from " . Database::$logTable . " order by time desc";//降序asc
                $info = Database::execute($sql);
                // 写入数据
                while ($result = $info->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li><hr><' . $result['time'] . '><br>';
                    if ($result['action'] == 'append') {
                        echo "已添加<br>" . $result['quantity'] . "个 '" . $result['item'] . "'";
                    } else if ($result['action'] == 'delete') {
                        echo "已删除<br>" . $result['quantity'] . "个 '" . $result['item'] . "'";
                    } else if ($result['action'] == 'modify') {
                        echo $result['quantity'] . "个 '" . $result['item'] . "'<br/> 修改为<br/>" . $result['newquantity'] . "个 '" . $result['newname'] . "'";
                    }
                    echo '</li>';
                }
                ?>
            </ul>
        </aside>
        <section>
            <table>
                <thead>
                <tr>
                    <th class="id"><span>编号</span></th>
                    <th class="name"><span>物品</span></th>
                    <th class="quantity"><span>数量</span></th>
                    <th class="operation"><span>操作</span></th>
                </tr>
                </thead>
                <tbody id="showItemInfo">
                <?php
                $authority = $_SESSION['loginAuthority'];
                //连接数据库
                include_once './api/database.php';
                //查找数据
                $sql = "select * from " . Database::$itemTable . " order by time desc";
                $info = Database::execute($sql);
                // 写入数据
                while ($result = $info->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr class="itemRow">';
                    echo '<td class="id"><input value="' . $result['id'] . '" disabled></td>';
                    echo '<td class="name"><input class="modifyName" ' . ($authority != 3 ? 'disabled' : '') . ' value="' . $result['name'] . '"></td>';
                    echo '<td class="quantity"><input class="modifyQuantity" ' . ($authority != 3 ? 'disabled' : '') . ' value="' . $result['quantity'] . '"></td>';
                    echo '<td class="operation"><button class="record">记录</button>';
                    if ($authority > 1) echo '<button class="borrow">借用</button>';
                    if ($authority == 3) echo '<button class="delete">删除</button>';
                    echo '</td></tr>';
                }
                if ($authority == 3) {
                    echo <<<EOF
                            <tr id='appendRow'>
                                <td class="id"><span>/</span></td>
                                <td class="name"><input id='appendName' placeholder='输入添加的物品名字' require></td>
                                <td class="quantity"><input id='appendQuantity' placeholder='数量' min='0' require></td>
                                <td class="operation"><span class='iconfont icon-tianjia' title='点击此处添加'></span></td>
                            </tr>
EOF;
                }
                ?>
                </tbody>
            </table>
        </section>
    </main>
</view>
<view id="maskLayer"></view>
<view id="borrowItemPage" tabindex="1">
    <header>
        <summary>物品借用</summary>
    </header>
    <section class="infoBar">
        <div class="fixedInfo">
            <span class="attr">物品编号:</span>
            <div class="value"><input id="borrowId" value='null' disabled></div>
        </div>
        <div class="fixedInfo">
            <span class="attr">物品信息:</span>
            <div class="value"><input id="borrowName" value='null' disabled></div>
        </div>
        <div class="fixedInfo">
            <span class="attr">剩余数量:</span>
            <div class="value"><input id="borrowQuan" value="null" disabled></div>
        </div>
        <div class="variaInfo">
            <span class="attr">借阅数量:</span>
            <div class="value">
                <select id='borrowItemQuan'>
                </select>
            </div>
        </div>
        <div class="variaInfo">
            <span class="attr">归还时间:</span>
            <div class="value">
                <select id="yearOption">
                </select>
                <select id="monthOption">
                </select>
                <select id="dayOption">
                </select>
            </div>
        </div>
        <div class="specialInfo">
            <button id="confirmBorrow">确定</button>
        </div>
    </section>
</view>
<view id="recordItemPage" tabindex="1">
    <header>
        <summary>物品借用记录</summary>
    </header>
    <section>
        <table>
            <thead>
            <tr>
                <th class="person"><span>借用人</span></th>
                <th class="quantity"><span>借用数量</span></th>
                <th class="borrowtime"><span>借用时间</span></th>
                <th class="isreturn"><span>是否归还</span></th>
                <th class="returntime"><span>归还时间</span></th>
            </tr>
            </thead>
            <tbody id="showItemRecordInfo"></tbody>
        </table>
    </section>
</view>
<view id="selfItemPage" tabindex="1">
    <header>
        <summary>个人主页</summary>
    </header>
    <section>
        <table>
            <thead>
            <tr>
                <th class="id"><span>编号</span></th>
                <th class="item"><span>借用物品</span></th>
                <th class="quantity"><span>借用数量</span></th>
                <th class="borrowtime"><span>借用时间</span></th>
                <th class="operation"><span>操作</span></th>
            </tr>
            </thead>
            <tbody id="showSelfItemInfo">
            <?php
            //连接数据库
            include_once './api/database.php';
            //准备预处理 //写入操作信息
            $sql = "select itemid, itemname, borrowquantity, borrowtime from " . Database::$operationTable . " where accountid=? and isreturn=0";
            $info = Database::execute($sql, $_SESSION['loginId']);
            while ($result = $info->fetch(PDO::FETCH_ASSOC)) {
                echo <<<EOF
                        <tr>
                            <td class="id"><input value='{$result['itemid']}' disabled></td>
                            <td class="item"><input value='{$result['itemname']}' disabled></td>
                            <td class="quantity"><input value='{$result['borrowquantity']}' disabled></td>
                            <td class="borrowtime"><input value='{$result['borrowtime']}' disabled></td>
                            <td class="operation"><button class="return">归还</button></td>
                        </tr>
EOF;
            }
            ?>
            </tbody>
        </table>
    </section>
</view>
<view id='popWindow' class='box'>
    <i><span class="iconfont icon-warning"></span></i>
    <p></p>
</view>
<div id='loadingBar'></div>
<label for='token'></label><input id='token' value='<?php echo $_SESSION['token']; ?>' style='display:none'>
<script type='text/javascript' src='src/js/jquery.min.js?v=20240921'></script>
<script type='text/javascript' src='src/js/function.js?v=20240921'></script>
<script type='text/javascript' src='src/js/mainPage.js?v=20240921'></script>
</body>

</html>