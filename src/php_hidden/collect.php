<?php
require("../php/wheel.php");
echo $_POST['imgid'];
if($_POST['whetherlike']==0){
    $link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES','pj2');
    $sql = "insert into travelimagefavor (UID,ImageID) values ('{$_POST['userid']}','{$_POST['imgid']}')";
    $result = $link->query($sql);
    mysqli_close($link);
} else {
    $link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
    $sql = "delete from travelimagefavor where UID='{$_POST['userid']}' and ImageID='{$_POST['imgid']}'";
    $result = $link->query($sql);
    mysqli_close($link);
}
$resultlike = mysqlDo(/** @lang text */ "select * from travelimagefavor where ImageID={$_POST['imgid']}");
$like_num = ($resultlike != null) ? sizeof($resultlike) : 0;
$link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
$sql = "update travelimage set like_num={$like_num} where ImageID='{$_POST['imgid']}'";
$result = $link->query($sql);
mysqli_close($link);
echo "<script src='../js/img_set.js'></script><script>postid('{$_POST['imgid']}')</script>";
