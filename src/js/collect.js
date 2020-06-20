function postlike(imgid,userid,whetherlike){
    var tempform = document.createElement("form");
    tempform.action = "../php_hidden/collect.php";
    tempform.method = "post";
    tempform.style.display="none"
    var opt = document.createElement("input");
    opt.name = "imgid";
    opt.value = imgid;
    tempform.appendChild(opt);
    var opt1 = document.createElement("input");
    opt1.name = "userid";
    opt1.value = userid;
    tempform.appendChild(opt1);
    var opt1 = document.createElement("input");
    opt1.name = "whetherlike";
    opt1.value = whetherlike;
    tempform.appendChild(opt1);
    var opt2 = document.createElement("input");
    opt2.type = "submit";
    tempform.appendChild(opt2);
    document.body.appendChild(tempform);
    tempform.submit();
    document.body.removeChild(tempform);
}


