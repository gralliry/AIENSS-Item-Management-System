if (window.navigator.webdriver) $('*').remove();
// 获取格式化时间
function getCurrentTime() {
    //补0
    function repair(i) {
        return i <= 9 ? "0" + i : i;
    }
    var date = new Date();
    return date.getFullYear() + "-" + repair(date.getMonth() + 1) + "-" + repair(date.getDate()) + " " + repair(date.getHours()) + ":" + repair(date.getMinutes()) + ":" + repair(date.getSeconds());
}
// 弹出警告弹窗
function popWindow(info) {
    $('#popWindow p').text(info);
    $('#popWindow').css('transform', 'translate(-50%,0%)');
    setTimeout(function () {
        $('#popWindow').css('transform', 'translate(-50%,-100%)');
    }, 2000);
}
// 进入加载
function startLoading(element = false) {
    if (element) $(element).css('pointer-events', 'none');
    $('#loadingBar').css('display','block');
}
// 退出加载
function endLoading(element = false) {
    if (element) $(element).css('pointer-events', 'all');
    $('#loadingBar').css('display','none');
}
// try {
//     setInterval(() => {
//         (function () {
//             return false;
//         }
//         ["constructor"]("debugger")
//         ["call"]());
//     }, 50);
// } catch (err) { }