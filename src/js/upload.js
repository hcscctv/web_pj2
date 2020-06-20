document.getElementById("file").onchange = function() {
    var objUrl = getObjectURL(document.getElementById("file").files[0]);
    if (objUrl != "")
        document.getElementById("img0").setAttribute("src", objUrl)
    document.getElementById("button").innerHTML = "重新上传"
};


// 兼容不同浏览器
function getObjectURL(file) {
    var url = null;
    if (window.createObjectURL != undefined) {
        url = window.createObjectURL(file);
    } else if (window.URL != undefined) {
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}