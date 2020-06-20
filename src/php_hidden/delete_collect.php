<?php
echo $_POST['imgid'] . $_POST['userid'];
$link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
$sql = "delete from travelimagefavor where UID='{$_POST['userid']}' and ImageID='{$_POST['imgid']}'";
$result = $link->query($sql);
mysqli_close($link);
require("../php/wheel.php");
$resultlike = mysqlDo(/** @lang text */ "select * from travelimagefavor where ImageID={$_POST['imgid']}");
$like_num = ($resultlike != null) ? sizeof($resultlike) : 0;
$link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
$sql = "update travelimage set like_num={$like_num} where ImageID='{$_POST['imgid']}'";
$result = $link->query($sql);
mysqli_close($link);
header("Location: ../php/favor.php");