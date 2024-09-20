// 公共内容
let apiPath = '/api/';
let token = $('#token').val();
// 当前时间对象
let time = new Date();
// 基础月份定义
let months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
// 全局按键
document.onkeydown = function (event) {
    // 回车键进入搜索已加载的
    if (event.keyCode === 13) {
        $("#showItemInfo>tr[class='itemRow']").each(function () {
            if ($(this).find('.name>input').val().search($('#searchContent').val()) >= 0) {
                $(this).css('display', 'flex');
            } else {
                $(this).css('display', 'none');
            }
        })
    }
}

//表格自动调整
function reSize() {
    //同时关闭高度
    $("#showLogInfo").css('display', 'none');
    $("#showItemInfo").css('display', 'none');
    //调整列表
    let aside = $("#showLogInfo").parent();
    $("#showLogInfo").css('height', aside.height() * 0.98 + 'px');
    //表格
    let table = $("#showItemInfo").parent();
    let thead = table.find('thead');
    $("#showItemInfo").css('height', (table.height() - thead.height()) + 'px');
    //同时开启
    $("#showLogInfo").css('display', 'block');
    $("#showItemInfo").css('display', 'block');
}

//修改宽度自动适应
window.onresize = reSize;
// 主页内容
$(function () {
    reSize()
    //物品借阅页面 //生成下拉框
    for (let i = 0, now = time.getFullYear(); i < 4; i++) {
        $('#yearOption').append(`<option>` + (now + i) + `</option>`)
    }
    for (let i = time.getMonth() + 1; i <= 12; i++) {
        $('#monthOption').append(`<option>` + i + `</option>`)
    }
    for (let i = time.getDate(); i <= months[time.getMonth()]; i++) {
        $('#dayOption').append(`<option>` + i + `</option>`)
    }
    // 开局动画加载
    $('#mainPage').css('left', '50%');
});
// 退出登录按钮绑定
$('#quitLogin').click(function () {
    startLoading('#quitLogin');
    $.ajax({
        url: apiPath + 'logout.php',
        type: 'post',
        data: JSON.stringify({
            'token': token
        }),
        complete: function () {
            endLoading('#quitLogin');
        }
    });
    window.location.replace('/index.php');
});
// 搜索按钮绑定
$('#searchBtn').click(function () {
    $("#showItemInfo>tr[class='itemRow']").each(function () {
        if ($(this).find('.name>input').val().search($('#searchContent').val()) >= 0) {
            $(this).css('display', 'flex');
        } else {
            $(this).css('display', 'none');
        }
    })
})
// 个人名字
let accountName;
//保存修改前名字
$('#name').focus(function () {
    accountName = $('#name').val();
})
//修改名字
$('#name').change(function () {
    startLoading('#name');
    $.ajax({
        url: apiPath + 'changeName.php',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify({
            'token': token,
            'name': $('#name').val()
        }),
        error: function (XMLHttpRequest) {
            popWindow('请求错误');
        },
        success: function (response) {
            //弹窗提示
            popWindow(response['message']);
            if (response['opCode'] == 101) {
                setTimeout(window.location.href = '/index.php', 1000);
            } else if (response['opCode'] == 200) {
                //恢复原来名字
                $('#name').val(accountName);
                $('#name').attr('size', accountName.length);
            }
        },
        complete: function () {
            endLoading('#name');
        }
    })
})
// 绑定记录按钮事件
$('#showItemInfo').on('click', '.record', function () {
    let grandfather = $(this).parent().parent();
    $('#recordItemPage').focus();
    startLoading();
    $.ajax({
        url: apiPath + 'record.php',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify({
            'token': token,
            'itemId': grandfather.find('.id>input').val(),
            'itemName': grandfather.find('.name>input').val(),
        }),
        error: function (XMLHttpRequest) {
            popWindow('请求错误');
        },
        success: function (response) {
            //弹窗提示
            if (response['opCode'] == 101) {
                popWindow(response['message']);
                setTimeout(window.location.href = '/index.php', 1000);
            } else if (response['opCode'] == 100) {
                $('#showItemRecordInfo').empty();
                let allData = response['data'];
                for (let i = 0, j = allData.length; i < j; i++) {
                    let simpleData = allData[i];
                    $('#showItemRecordInfo').append(`
                    <tr>
                        <td class="person"><input value='` + simpleData['accountname'] + `' disabled></th>
                        <td class="quantity"><input value='` + simpleData['borrowquantity'] + `' disabled></th>
                        <td class="borrowtime"><input value='` + simpleData['borrowtime'] + `' disabled></th>
                        <td class="isreturn"><input value='` + (Number(simpleData['isreturn']) ? '是' : '否') + `' disabled></th>
                        <td class="returntime"><input value='` + (Number(simpleData['isreturn']) ? simpleData['returntime'] : '/') + `' disabled></th>
                    </tr>
                    `)
                }
            } else {
                popWindow(response['message']);
            }
        },
        complete: function () {
            endLoading();
        }
    })
})
$('#recordItemPage').focus(function () {
    //打开记录页面
    $(this).css({
        'width': $("#showItemInfo").width() + 'px',
        'height': '400px',
        'opacity': '1',
    });
    //背景蒙版
    lockMainPage();
});
$('#recordItemPage').blur(function () {
    //关闭记录页面
    $(this).css({
        'width': '0px',
        'height': '0px',
        'opacity': '0',
    });
    //关闭背景蒙版
    unlockMainPage();
})
// 借用信息(元素)
let borrowItemQuantity;
// 绑定借阅按钮事件
$('#showItemInfo').on('click', '.borrow', function () {
    // 保存借阅按下时的对应物品信息
    let grandfather = $(this).parent().parent();
    $('#borrowId').val(grandfather.find('.id>input').val());
    $('#borrowName').val(grandfather.find('.name>input').val());
    borrowItemQuantity = grandfather.find('.quantity>input');
    let quantity = Number(borrowItemQuantity.val());
    $('#borrowQuan').val(quantity);
    //借阅数量限制
    $('#borrowItemQuan').empty();
    for (let i = (quantity == 0 ? 0 : 1); i < quantity + 1; i++) {
        $('#borrowItemQuan').append(`<option>` + i + `</option>`)
    }
    // 展示弹窗
    $('#borrowItemPage').focus();
})

//限制借阅时间选择
$('#yearOption').change(function () {
    console.log('true');
    let year = $('#yearOption').val();
    let month = $('#monthOption').val();
    let day = $('#dayOption').val();
    $('#monthOption').empty();
    for (let i = (year == time.getFullYear() ? time.getMonth() + 1 : 1); i <= 12; i++) {
        $('#monthOption').append(`<option>` + i + `</option>`)
    }
    $('#monthOption').val(month = Math.max(month, time.getMonth() + 1));
    $('#dayOption').empty();
    for (let i = (year == time.getFullYear() && month == time.getMonth() + 1 ? time.getDate() : 1); i <= months[month - 1] + (year % 4 == 0 && month == 2 ? 1 : 0); i++) {
        $('#dayOption').append(`<option>` + i + `</option>`)
    }
    $('#dayOption').val(day = Math.min(day, months[month - 1] + (year % 4 == 0 && month == 2 ? 1 : 0)));
    if (year == time.getFullYear() && month == time.getMonth() + 1) {
        $('#dayOption').val(day = Math.max(day, time.getDate()));
    }
})
$('#monthOption').change(function () {
    let year = $('#yearOption').val();
    let month = $('#monthOption').val();
    let day = $('#dayOption').val();
    $('#dayOption').empty();
    for (let i = (year == time.getFullYear() && month == time.getMonth() + 1 ? time.getDate() : 1); i <= months[month - 1] + (year % 4 == 0 && month == 2 ? 1 : 0); i++) {
        $('#dayOption').append(`<option>` + i + `</option>`)
    }
    $('#dayOption').val(day = Math.min(day, months[month - 1] + (year % 4 == 0 && month == 2 ? 1 : 0)));
    if (year == time.getFullYear() && month == time.getMonth() + 1) {
        $('#dayOption').val(day = Math.max(day, time.getDate()));
    }
})
$('#borrowItemQuan,#yearOption,#monthOption,#dayOption,#confirmBorrow').focus(function () {
    // 展示弹窗
    $('#borrowItemPage').focus();
})
// 展示弹窗
$('#borrowItemPage').focus(function () {
    $(this).css({
        // 'width': $("#showItemInfo").width() + 'px',
        'width': '400px',
        'height': '300px',
        'opacity': '1'
    })
    //蒙版
    lockMainPage();
});
// 关闭借阅页面
$('#borrowItemPage').blur(function () {
    $(this).css({
        'width': '0px',
        'height': '0px',
        'opacity': '0',
    });
    //取消背景蒙版
    unlockMainPage();
})
// 确认借阅按钮
$('#confirmBorrow').click(function () {
    startLoading('#confirmBorrow');
    $.ajax({
        url: apiPath + 'borrow.php',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify({
            'token': token,
            'itemId': $('#borrowId').val(),
            'itemName': $('#borrowName').val(),
            'itemQuantity': $('#borrowQuan').val(),
            'borrowQuantity': $('#borrowItemQuan').val(),
            'year': $('#yearOption').val(),
            'month': $('#monthOption').val(),
            'day': $('#dayOption').val()
        }),
        error: function (XMLHttpRequest) {
            popWindow('请求错误');
        },
        success: function (response) {
            //弹窗提示
            popWindow(response['message']);
            if (response['opCode'] == 101) {
                setTimeout(window.location.href = '/index.php', 1000);
            } else if (response['opCode'] == 100) {
                //更新物品信息
                borrowItemQuantity.val(borrowItemQuantity.val() - $('#borrowItemQuan').val());
                //更新个人主页
                $('#showSelfItemInfo').prepend(`
                <tr>
                    <td class="id"><input value='` + $('#borrowId').val() + `' disabled></td>
                    <td class="item"><input value='` + $('#borrowName').val() + `' disabled></td>
                    <td class="quantity"><input value='` + $('#borrowItemQuan').val() + `' disabled></td>
                    <td class="borrowtime"><input value='` + getCurrentTime() + `' disabled></td>
                    <td class="operation"><button class="return">归还</button></td>
                </tr>
                `)
                //关闭借用页面
                $('#borrowItemPage').css({
                    'width': '0px',
                    'height': '0px',
                    'opacity': '0',
                });
                //取消背景蒙版
                unlockMainPage();
            }
        },
        complete: function () {
            endLoading('#confirmBorrow');
        }
    })
})
// 修改信息
let oldName, oldQuantity;
// 保存修改前信息
$('#showItemInfo').on('focus', '.modifyName,.modifyQuantity', function () {
    let grandfather = $(this).parent().parent();
    oldName = grandfather.find('.name>.modifyName').val();
    oldQuantity = grandfather.find('.quantity>.modifyQuantity').val();
})
// 确认修改
$('#showItemInfo').on('change', '.modifyName,.modifyQuantity', function () {
    let grandfather = $(this).parent().parent();
    let itemId = grandfather.find('.id>span').text();
    let itemName = grandfather.find('.name>.modifyName');
    let itemQuantity = grandfather.find('.quantity>.modifyQuantity')
    let isModifye = confirm('是否修改为:\n' + itemQuantity.val() + '个\n"' + itemName.val() + '"');
    if (isModifye) {
        startLoading('#showItemInfo .modifyName,.modifyQuantity');
        $.ajax({
            url: apiPath + 'modify.php',
            type: 'post',
            dataType: 'json',
            data: JSON.stringify({
                'token': token,
                'itemId': itemId,
                'itemName': itemName.val(),
                'itemQuantity': itemQuantity.val()
            }),
            error: function (XMLHttpRequest) {
                popWindow('请求错误');
            },
            success: function (response) {
                //弹窗提示
                popWindow(response['message']);
                if (response['opCode'] == 101) {
                    setTimeout(window.location.href = '/index.php', 1000);
                } else if (response['opCode'] == 100) {
                    // 更新日志信息
                    info = oldQuantity + "个 '" + oldName + "'<br/> 修改为<br/>" + itemQuantity.val() + "个 '" + itemName.val() + "'";
                    $('#showLogInfo').children(':first').after("<li><hr><" + getCurrentTime() + "><br>" + info + "</li>")
                }
            },
            complete: function () {
                endLoading('#showItemInfo .modifyName,.modifyQuantity');
            }
        })
    } else {
        itemName.val(oldName);
        itemQuantity.val(oldQuantity);
    }
})
//删除物品
$('#showItemInfo').on('click', '.delete', function () {
    let grandfather = $(this).parent().parent();
    let itemId = grandfather.find('.id>span').text();
    let itemName = grandfather.find('.name>.modifyName').val();
    let itemQuantity = grandfather.find('.quantity>.modifyQuantity').val()
    let isDelete = confirm('是否删除:\n' + itemQuantity + '个\n"' + itemName + '"');
    if (isDelete) {
        startLoading('#showItemInfo .delete');
        $.ajax({
            url: apiPath + 'delete.php',
            type: 'post',
            dataType: 'json',
            data: JSON.stringify({
                'token': token,
                'itemId': itemId,
                'itemName': itemName,
                'itemQuantity': itemQuantity
            }),
            error: function (XMLHttpRequest) {
                popWindow('请求错误');
            },
            success: function (response) {
                //弹窗提示
                popWindow(response['message']);
                if (response['opCode'] == 101) {
                    setTimeout(window.location.href = '/index.php', 1000);
                } else if (response['opCode'] == 100) {
                    //更新日志信息
                    info = itemQuantity + "个 '" + itemName + "'";
                    $('#showLogInfo').children(':first').after("<li><hr><" + getCurrentTime() + "><br>已删除<br>" + info + "</li>");
                    //更新物品信息
                    grandfather.remove();
                }
            },
            complete: function () {
                endLoading('#showItemInfo .delete');
            }
        })
    }
})
// 账号权限
let accountAuthority = $('#authority').text();
//绑定添加事件按钮
$('.icon-tianjia').click(function () {
    let itemName = $('#appendName').val();
    let itemQuantity = $('#appendQuantity').val();
    startLoading('#showItemInfo .icon-tianjia');
    $.ajax({
        url: apiPath + 'append.php',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify({
            'token': token,
            'itemName': itemName,
            'itemQuantity': itemQuantity
        }),
        error: function (XMLHttpRequest) {
            popWindow('请求错误');
            console.log(XMLHttpRequest)
        },
        success: function (response) {
            //弹窗提示
            popWindow(response['message']);
            if (response['opCode'] == 101) {
                setTimeout(window.location.href = '/index.php', 1000);
            } else if (response['opCode'] == 100) {
                // 更新日志信息
                info = itemQuantity + "个 '" + itemName + "'";
                $('#showLogInfo').children(':first').after("<li><hr><" + getCurrentTime() + "><br>已添加<br>" + info + "</li>");
                // 刷新物品页面
                let lastId = response['data']['lastId'];
                $('#showItemInfo').prepend(`
                <tr class='itemRow'>
                    <td class="id"><span>` + lastId + `</span></td>
                    <td class="name"><input class='modifyName' value='` + itemName + `'></td>
                    <td class="quantity"><input class='modifyQuantity' value='` + itemQuantity + `'></td>
                    <td class="operation">
                        <button class='record' title='查看物品借用记录'>记录</button>`
                    + (accountAuthority == '用户' || accountAuthority == '管理员' ? '<button class="borrow" title="借用该物品">借用</button>' : '')
                    + (accountAuthority == '管理员' ? '<button class="delete" title="删除该物品">删除</button>' : '')
                    + `</td>
                </tr>
                `)
                //
                $('#appendName').val('');
                $('#appendQuantity').val('');
            }
        },
        complete: function () {
            endLoading('#showItemInfo .icon-tianjia');
        }
    })
})
//个人主页showItemInfo
$('.icon-yonghu').click(function () {
    $('#selfItemPage').focus();
})
$('#showSelfItemInfo').on('focus', '.return', function () {
    $('#selfItemPage').focus();
})
$('#selfItemPage').focus(function () {
    //打开个人界面
    $('#selfItemPage').css({
        'width': $('#showItemInfo').width() + 'px',
        'height': '400px',
        'opacity': '1'
    })
    //背景蒙版
    lockMainPage();
})
$('#selfItemPage').blur(function () {
    //关闭个人界面
    $(this).css({
        'width': '0px',
        'height': '0px',
        'opacity': '0'
    })
    //取消背景蒙版
    unlockMainPage();
})
//绑定归还按钮事件
$('#showSelfItemInfo').on('click', '.return', function () {
    let grandfather = $(this).parent().parent();
    let itemId = grandfather.find('.id>input').val();
    let itemName = grandfather.find('.item>input').val();
    let borrowQuantity = grandfather.find('.quantity>input').val();
    startLoading('#showSelfItemInfo .return');

    $.ajax({
        url: apiPath + 'return.php',
        type: 'post',
        dataType: 'json',
        data: JSON.stringify({
            'token': token,
            'itemId': itemId,
            'itemName': itemName,
            'borrowQuantity': borrowQuantity
        }),
        error: function (XMLHttpRequest) {
            popWindow('请求错误');
            console.log(XMLHttpRequest);
        },
        success: function (response) {
            //弹窗提示
            popWindow(response['message']);
            if (response['opCode'] == 101) {
                setTimeout(window.location.href = '/index.php', 1000);
            } else if (response['opCode'] == 100) {
                //更新个人信息
                grandfather.remove();
                //更新物品信息
                let result = $('#showItemInfo').find('.itemRow:contains(' + itemId + ')');
                if (result) {
                    result.find('.modifyQuantity').val(Number(result.find('.modifyQuantity').val()) + Number(borrowQuantity));
                }

            }
        },
        complete: function () {
            endLoading('#showSelfItemInfo .return');
        }
    })
})

// 对背景蒙版
function lockMainPage() {
    $('#mainPage').css({
        'pointer-events': 'none',
        'filter': 'blur(1px) brightness(80%)'
    });
}

//解除背景蒙版
function unlockMainPage() {
    $('#mainPage').css({
        'pointer-events': 'all',
        'filter': 'blur(0px) brightness(100%)'
    });
}
