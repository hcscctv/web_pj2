<?php
$key = $_POST['key']; //获取值
require ("../php/wheel.php");
$ans=mysqlDo("select UserName from traveluser where UserName='{$key}'");
if($ans===null){
    $result['data'] = true;
}
else $result['data'] = false;
$result['status'] = 200;
echo json_encode($result); //返回JSON数据