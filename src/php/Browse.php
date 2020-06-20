<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/Browse.css">
    <script src="../js/disabled_change.js"></script>
</head>

<body>
<!-- 导航栏 -->
<script src="../js/particles.js"></script>
<script>
    function go(search) {
        self.location = "./Browse.php?" + search;
    }
</script>
<?php
require('../php_hidden/img_show.php');
require_once("wheel.php");
function SQLprepare(&$str)//SQL防注入
{
    $str = preg_replace("/(DELETE)|(INSERT)|(UPDATE)|(SELECT)|(DROP)|(DATABASE)|(#)/", " ", strtoupper($str));
    $str = str_replace("'", "''", $str);//单引号转义
}

$url = "";
$sql = "";
if (isset($_GET["title"]))//按标题查询，wd是word的意思
{
    if ($url != "") $url .= "&";
    $url .= "title=" . $_GET["title"];
    if ($sql === "") $sql .= "WHERE ";
    else $sql .= "and ";
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
}
if (isset($_GET["country"])) {
    if ($url != "") $url .= "&";
    $url .= "country=" . $_GET["country"];
    if ($sql === "") $sql .= "WHERE ";
    else $sql .= "and ";
    $sql .= "CountryCodeISO = '{$_GET["country"]}'";
}

if (isset($_GET["city"])) {
    if ($url != "") $url .= "&";
    $url .= "city=" . $_GET["city"];
    if ($sql === "") $sql .= "WHERE ";
    else $sql .= "and ";
    $sql .= "CityCode = '{$_GET["city"]}' ";
}

if (isset($_GET["content"])) {
    if ($url != "") $url .= "&";
    $url .= "content=" . $_GET["content"];
    if ($sql === "") $sql .= "WHERE ";
    else $sql .= "and ";
    $sql .= "Content = '{$_GET["content"]}' ";
}
?>

<nav>
    <ul id="nav">
        <li id="logo">
            <a href="HomePage.php"><img src="../../img/logo_nav.png"></a>
        </li>
        <li><a href="HomePage.php">Home</a></li>
        <li class="this"><a href="Browse.php">Browse</a></li>
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
            </li>';}
            else{
            echo "<li id='account'><a href='login.php'>login</a></li>";
            }
            ?>
    </ul>
</nav>
<!-- 左边搜索栏 -->
<div id="left">
    <div class="main">
        <div class="title">Search by title</div>
        <table id="filter">
            <tr>
                <td id="filter_input"><input id='title_search' type="text"></td>
                <script>
                    function title_filter() {
                        let title = document.getElementById("title_search").value;
                        go("title=" + title);
                    }
                </script>
                <td id="filter_button" onclick="title_filter ()"><img src="../../img/filter.jpg" alt=""></td>
            </tr>
        </table>
    </div>

    <div class="main">
        <div class="title">Image Details</div>
        <?php

        $contents = mysqlDo("SELECT Content, COUNT(*) FROM travelimage GROUP BY Content;");
        foreach ($contents as $content) {
            echo "<div class=\"choice\" onclick='go(\"content=" . $content['Content'] . "\")'>" .
                $content['Content'] . "
            </div>";
        }
        ?>
    </div>

    <div class="main">
        <div class="title">Hot country</div>
        <?php
        $countries = mysqlDo("SELECT CountryCodeISO, COUNT(*) FROM travelimage GROUP BY CountryCodeISO order by count(*) desc limit 0,5;");
        foreach ($countries as $country) {
            $country_name = mysqlDo("SELECT CountryName from geocountries where ISO='{$country['CountryCodeISO']}'")[0]['CountryName'];
            echo "<div class=\"choice\" onclick='go(\"country=" . $country['CountryCodeISO'] . "\")'>" .
                $country_name . "
            </div>";
        }
        ?>
    </div>

    <div class="main">
        <div class="title">Hot City</div>
        <?php
        $cities = mysqlDo("SELECT CityCode, COUNT(*) FROM travelimage GROUP BY CityCode order by count(*) desc limit 0,5;");
        foreach ($cities as $city) {
            $city_name = mysqlDo("SELECT AsciiName from geocities where GeoNameID='{$city['CityCode']}'")[0]['AsciiName'];
            echo "<div class=\"choice\" onclick='go(\"country=" . $city['CityCode'] . "\")'>" .
                $city_name . "
            </div>";
        }
        ?>
    </div>
</div>

<div id="right">
    <div class="main">
        <div class="title">Filter</div>
        <div class="filter_details">
            <select name="content" id="content" required>
                <option value="0" selected>content</option>
                <?php
                foreach ($contents as $content) {
                    echo "<option value=\"" . $content['Content'] . "\">" .
                        $content['Content'] . "
            </option>";
                }
                ?>
            </select>
            <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
            <select class="area-select" id='country' name="country" required>
                <option value="0">请选择国家</option>
                <?php
                $countries = mysqlDo("SELECT CountryCodeISO, COUNT(*) FROM travelimage GROUP BY CountryCodeISO;");
                foreach ($countries as $country) {
                    $country_name = mysqlDo("SELECT CountryName from geocountries where ISO='{$country['CountryCodeISO']}'")[0]['CountryName'];
                    echo "<option value=\"" . $country['CountryCodeISO'] . "\">" .
                        $country_name . "
                    </option>";
                }
                ?>
            </select>
            <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
            <script>
                $(function () {
                    //初始化数据
                    let url = '../php_hidden/address.php'; //后台地址
                    $("#country").change(function () {
                        //发送一个post请求
                        let address = $("#country").val();
                        if (address == 0) {
                            $('#city').html("<option value=\"0\">请选择城市</option>");
                        } else {
                            $.ajax({
                                type: 'post',
                                url: url,
                                data: {key: address},
                                dataType: 'json',
                                success: function (data) { //请求成功回调函数
                                    let status = data.status; //获取返回值
                                    let ans = data.data;
                                    if (status == 200) { //判断状态码，200为成功
                                        let option = '';
                                        for (let i = 0, max = ans.length; i < max; i++) {
                                            option += '<option value=' + ans[i]['GeoNameID'] + '>' + ans[i]['AsciiName'] + '</option>'
                                        }
                                        $('#city').html(option);
                                    }

                                },
                            });
                        }
                    });
                });
            </script>
            <select class="area-select" id="city" name="city" required>
                <option value="0">请选择城市</option>
            </select>
            <script>
                function filter() {
                    let url = "check=none";
                    if (document.getElementById("content").value != 0) url += "&content=" + document.getElementById("content").value;
                    if (document.getElementById("country").value != 0) url += "&country=" + document.getElementById("country").value;
                    if (document.getElementById("city").value != 0) url += "&city=" + document.getElementById("city").value;
                    go(url);
                }
            </script>

            <button onclick="filter()">Filter</button>
        </div>

        <?php
        if ($sql != "") {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;//当前页码
            $page_start = $page * 6 - 6;//起始
            $details = mysqlDo("select ImageID from travelimage " . $sql);
            if ($details != null) {
                $detail_sum = sizeof($details);//总数
                $details = mysqlDo("select ImageID from travelimage " . $sql . " limit 0" . $page_start . ",6");
                echo "<div id=\"filter_result\">";
                foreach ($details as $detail) {
                    echo "<li>" . img($detail['ImageID'], '123') . "</li>";
                }
                echo "</div>";
                echo "<div id=\"page_number\">";
                $left = $page - 1;
                $right = $page + 1;
                if ($page != 1) echo "<a href=\'Browse.php?" . $url . "&page=" . $left . "\'><span>《</span></a>";
                $page_now = 0;
                while ($detail_sum > 0) {
                    if (++$page_now == $page) echo "<a href='Browse.php?" . $url . "&page=" . $page_now . "'><span id='active'> " . $page_now . "</span></a>";

                    else {
                        echo "<a href='Browse.php?" . $url . "&page=" . $page_now . "'><span>" . $page_now . "</span></a>";
                    }
                    if ($page_now == 5) break;
                    $detail_sum -= 6;
                }
                if ($page != $page_now) echo "<a href='Browse.php?" . $url . "&page=" . $right . "'><span>》</span></a>";
                echo "</div>";
            }
        }


        ?>
    </div>
</div>

<footer>
    Copyright&#169;19302010004 黄呈松
</footer>
</body>

</html>