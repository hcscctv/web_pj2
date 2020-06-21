<?php
ini_set("error_reporting",E_ALL & ~E_NOTICE);
function resultToArray($result){
    while($row=mysqli_fetch_assoc($result)){
        $rows[]=$row;
    }
    return $rows;
}
function mysqlDo($sql){
    $link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES','pj2');
    $result = $link->query($sql);
    $result=resultToArray($result);
    mysqli_close(($link));
    return $result;
}

function get($str){
    return isset($_GET[$str]) ? $_GET[$str] : null;
}

function encode($str){
    return base64_encode($str);
}

function decode($str){
    return base64_decode($str);
}

function hashsalt($password, $salt)
{
    return sha1(sha1($password) . $salt);
}


