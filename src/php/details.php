<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/details.css">
</head>

<body>
<script src="../js/particles.js"></script>
<nav>
    <!-- 导航栏 -->
    <ul id="nav">
        <li id="logo">
            <a href="HomePage.php"><img src="../../img/logo_nav.png"></a>
        </li>
        <li><a href="HomePage.php">Home</a></li>
        <li><a href="Browse.php">Browse</a></li>
        <li><a href="Search.php">Search</a></li>
        <?php
        if (isset($_COOKIE['username'])) {
            echo '<li id= "account">My&nbsp; Account&nbsp;
            <br>
            <ul id="dropdown">
                <li>
                    <a href="Upload.php"><img src="../../img/upload.png" alt="">Upload</a>
                </li>
                <li>
                    <a href="my_photo.php"><img src="../../img/photo.png" alt="">My photo</a>
                </li>
                <li>
                    <a href="favor.php"><img src="../../img/favourite.png" alt="">My favorite</a>
                </li>
                <li>
                    <a href="login.php"><img src="../../img/login.png" alt="">Log out</a>
                </li>
            </ul>
            </li>';
        } else {
            echo "<li id='account'><a href='login.php'>login</a></li>";
        }
        ?>
    </ul>
</nav>
<?php
require("wheel.php");
$result = mysqlDo("SELECT * FROM travelimage WHERE ImageID ={$_GET['imgid']}");
$userName_actual = decode($_COOKIE['username']);
$uid = mysqlDo("select UID, username from traveluser where UserName='{$userName_actual}'")[0]['UID'];
?>
<div class="main">
    <div class="title">Details</div>
    <h2><?php echo $result[0]['Title']; ?>
        &nbsp;<span>by <?php $author = mysqlDo("select UserName from traveluser where UID={$result[0]['UID']}");
            echo $author[0]['UserName'] ?></span></h2>
    <div id="info">
        <!-- 左图右信息 -->
        <div class="half"><img src=../../travel-images/medium/<?php echo $result[0]["PATH"]; ?>></div>
        <div class="half">
            <div class="main">
                <div class="title">Like Number</div>
                <div id="like_number"><?php $resultlike = mysqlDo( "select * from travelimagefavor where ImageID={$_GET['imgid']}");
                    if ($resultlike != null)
                        echo sizeof($resultlike);
                    else echo '0';
                    ?></div>
            </div>
            <div class="main">
                <div class="title">Image Details</div>
                <div class="detail">
                    Content:<?php echo $result[0]['Content'] ?>
                </div>
                <div class="detail">
                    Country:<?php
                    $resultcountry = mysqlDo("select * from geocountries where ISO='{$result[0]['CountryCodeISO']}'");
                    echo $resultcountry[0]['CountryName']; ?>
                </div>
                <div class="detail_last">
                    City:<?php
                    $resultcity = mysqlDo("select * from geocities where GeoNameID='{$result[0]['CityCode']}'");
                    echo $resultcity[0]['AsciiName']; ?>
                </div>
            </div>
            <script src="../js/collect.js"></script>
            <?php if (isset($_COOKIE['username'])) {

                $whetherlike = mysqlDo("SELECT * FROM travelimagefavor WHERE UID ='{$uid}' and ImageID='{$_GET['imgid']}'");
                if ($whetherlike != null) {
                    echo "<button id=\"collect\" value=\"\" onclick=\"postlike({$_GET['imgid']},{$uid},1)\">
                    <img id=\"collect_img\" src=\"../../img/collect.png\">已收藏</button>";
                }
                    else{
                        echo "<button id=\"collect\" value=\"\" onclick=\"postlike({$_GET['imgid']},{$uid},0)\">
                    <img id=\"collect_img\" src=\"../../img/collect.png\">收藏</button>";}
                    }
                else{
                    echo "<button id='collect' value=\"\" onclick='window.location.href=\"../php/login.php\"'>
                    现在登陆</button>";
                }?>
            </div>

        </div>
        <div id="text">
           <?php
           echo ($result[0]['Description']!=null)?$result[0]['Description']:"there is no description"?>
    </div>

    <footer>
        Copyright&#169;19302010004 黄呈松
    </footer>
</body>

</html>