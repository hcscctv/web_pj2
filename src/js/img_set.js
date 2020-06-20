function postid(id){
    var tempform = document.createElement("form");
    tempform.action = "../php/details.php";
    tempform.method = "get";
    tempform.style.display="none"
        var opt = document.createElement("input");
        opt.name = "imgid";
        opt.value = id;
        tempform.appendChild(opt);
    var opt = document.createElement("input");
    opt.type = "submit";
    tempform.appendChild(opt);
    document.body.appendChild(tempform);
    tempform.submit();
    document.body.removeChild(tempform);
}