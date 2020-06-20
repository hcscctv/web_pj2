// 选择那个文本框可用

function disabled_change_a() {
    document.getElementById("title").disabled = false;
    document.getElementById("desc").disabled = true;
}

function disabled_change_b() {
    document.getElementById("title").disabled = true;
    document.getElementById("desc").disabled = false;
}