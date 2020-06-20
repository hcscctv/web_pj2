<?php
require('../php/wheel.php');
echo $_GET['userName'] . $_GET['mail'] . $_GET['passWord'] . $_GET['repassWord'];
$password = hashsalt($_GET['passWord'], $_GET['userName']);
$link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES', 'pj2');
$sql = "insert into traveluser (Email,UserName,Pass) values ('{$_GET['mail']}','{$_GET['userName']}','{$password}')";
$result = $link->query($sql);
mysqli_close($link);

header('Location:../php/login.php');