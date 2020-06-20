<?php
echo '<script src="../js/img_set.js"> </script>';
require_once("../php/wheel.php");
function img($id, $class)
{
    $info = mysqlDo("select * from travelimage where ImageID = '{$id}'");
    return "<img src=\"../../travel-images/medium/" . $info[0]['PATH'] . "\" class={$class} onclick=postid(" . $id . ")>";
}

