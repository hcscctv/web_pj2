<?php
session_start();
$code = trim($_POST['key']);
if($code==$_SESSION["helloweba_num"]){
    $result['status']=200;
}
else $result['status']=202;
echo json_encode($result);
