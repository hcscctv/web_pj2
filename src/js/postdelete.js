function postdelete(imgid,userid){
    let tempform = document.createElement("form");
    tempform.action = "../php_hidden/delete_collect.php";
    tempform.method = "post";
    tempform.style.display="none"
    let opt = document.createElement("input");
    opt.name = "imgid";
    opt.value = imgid;
    tempform.appendChild(opt);
    let opt1 = document.createElement("input");
    opt1.name = "userid";
    opt1.value = userid;
    tempform.appendChild(opt1);
    let opt2 = document.createElement("input");
    opt2.type = "submit";
    tempform.appendChild(opt2);
    document.body.appendChild(tempform);
    tempform.submit();
    document.body.removeChild(tempform);
}