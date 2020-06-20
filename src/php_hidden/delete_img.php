<?php
echo $_POST['imgid'] . $_POST['userid'];

$link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
$sql = "delete from travelimage where UID='{$_POST['userid']}' and ImageID='{$_POST['imgid']}'";
$result = $link->query($sql);
mysqli_close($link);
$link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
$sql = "delete from travelimagefavor where UID='{$_POST['userid']}' and ImageID='{$_POST['imgid']}'";
$result = $link->query($sql);
mysqli_close($link);

header("Location: ../php/my_photo.php");