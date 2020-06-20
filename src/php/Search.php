<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/favor_myphoto_search.css">
    <script src="../js/disabled_change.js"></script>
</head>

<body>
<script src="../js/particles.js"></script>
<nav>
    <ul id="nav">
        <li id="logo">
            <a href="HomePage.php"><img src="../../img/logo_nav.png"></a>
        </li>
        <li><a href="HomePage.php">Home</a></li>
        <li><a href="Browse.php">Browse</a></li>
        <li class="this"><a href="Search.php">Search</a></li>
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
<div class="main">
    <div class="title">Search</div>
    <form action="Search.php">
        <input type="radio" name="filter_way" id="by_title" onclick="disabled_change_a()">Filter by Title <br>
        <input id="title" name="title" type="text"><br>
        <input type="radio" name="filter_way" id="by_description" onclick="disabled_change_b()">Filter by Description
        <br>
        <textarea name="description" id="desc" cols="30" rows="3" disabled></textarea><br>
        <input type="submit" value="Filter">
    </form>
</div>
<?php
require('wheel.php');
require('../php_hidden/img_show.php');
function SQLprepare(&$str)//SQL防注入
{
    $str = preg_replace("/(DELETE)|(INSERT)|(UPDATE)|(SELECT)|(DROP)|(DATABASE)|(#)/", " ", strtoupper($str));
    $str = str_replace("'", "''", $str);//单引号转义
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;//当前页码
$page_start = $page * 5 - 5;//起始
$flag = true;//是否在搜索
if (!isset($_GET['title']) & (!isset($_GET['description']))) $flag = false;
if ($flag) {
    if (isset($_GET["title"]))//按标题查询，wd是word的意思
    {
        $url = "title=" . $_GET["title"];
        $sql .= "WHERE ";
        //LIKE关键字符替换
        $title = $_GET["title"];
        $title = str_replace("[", "[[]", $title);
        $title = str_replace("]", "[]]", $title);
        $title = str_replace("_", "[_]", $title);
        $title = str_replace("%", "[%]", $title);
        SQLprepare($title);//SQL防注入
        $wds = explode(" ", $title);//explode等于字符串的split分割
        $wdsl = count($wds);
        for ($i = 0; $i < $wdsl; $i++) {
            if ($i == $wdsl - 1)
                $sql .= "Title LIKE '%" . $wds[$i] . "%' ";
            else
                $sql .= "Title LIKE '%" . $wds[$i] . "%' AND ";
        }
    } else {
        $url = "description=" . $_GET["description"];
        $sql .= "WHERE ";
        $description = $_GET["description"];
        $description = str_replace("[", "[[]", $description);
        $description = str_replace("]", "[]]", $description);
        $description = str_replace("_", "[_]", $description);
        $tdescription = str_replace("%", "[%]", $description);
        SQLprepare($description);//SQL防注入
        $wds = explode(" ", $description);//explode等于字符串的split分割
        $wdsl = count($wds);
        for ($i = 0; $i < $wdsl; $i++) {
            if ($i == $wdsl - 1)
                $sql .= "Description LIKE '%" . $wds[$i] . "%' ";
            else
                $sql .= "Description LIKE '%" . $wds[$i] . "%' AND ";
        }
    }
    $details = mysqlDo("select ImageID,Title,Description from travelimage " . $sql);
    if ($details != null) {
        $detail_sum = sizeof($details);//总数
        $details = mysqlDo("select ImageID from travelimage " . $sql . " limit 0" . $page_start . ",5");
        echo "<div class=\"main \">
        <div class=\"title \">Result</div>
        <ul>";
        foreach ($details as $detail) {
            $show = mysqlDo("SELECT PATH,Description,Title FROM travelimage WHERE ImageID='{$detail['ImageID']}'");
            echo $show['Description'];
            echo "<li class=\"pic\">" . img($detail['ImageID'], 'pic_pic') . "
                <div class=\"pic_text\">
                    <h2>
                        " . $show[0]['Title'] . "
                    </h2>
                    <br>
                    <p class=\"text\">" . $show[0]['Description'] . "</p>
                    <br>
                </div>
            </li>";
        }
        echo "</ul>";
        echo "<div id=\"page_number\">";
        $left = $page - 1;
        $right = $page + 1;
        if ($page != 1) echo "<a href=\'Search.php?" . $url . "&page=" . $left . "\'><span>《</span></a>";
        $page_now = 0;
        while ($detail_sum > 0) {
            if (++$page_now == $page) echo "<a href='Search.php?" . $url . "&page=" . $page_now . "'><span id='active'> " . $page_now . "</span></a>";

            else {
                echo "<a href='Search.php?" . $url . "&page=" . $page_now . "'><span>" . $page_now . "</span></a>";
            }
            if ($page_now == 5) break;
            $detail_sum -= 5;
        }
        if ($page != $page_now) echo "<a href='Search.php?" . $url . "&page=" . $right . "'><span>》</span></a>";
        echo "</div></div>";
    }
}


?>


<footer>
    Copyright&#169;19302010004 黄呈松
</footer>
</body>


</html>