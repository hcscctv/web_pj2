<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>favor</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/favor_myphoto_search.css">
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
            header("Location: ./login.php");
        }
        ?>
    </ul>
</nav>
<div class="main">
    <div class="title">My favorite</div>
    <script src="../js/postdelete.js">
    </script>
    <ul>
        <?php
        require('wheel.php');
        require('../php_hidden/img_show.php');
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $page_start = $page * 5 - 5;
        $username = decode($_COOKIE['username']);
        $flag = true;

        $uid = mysqlDo("select UID from traveluser where UserName='$username'")[0]['UID'];
        $details = mysqlDo("select ImageID from travelimagefavor where UID='$uid'");
        $detail_sum = sizeof($details);
        $details = mysqlDo("select ImageID from travelimagefavor where UID='$uid' limit 0" . $page_start . ",5");
        if ($details == null) {
            echo "find some picture you like";
            $flag = false;
        } else foreach ($details as $detail) {
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
                    <button class=\"delete\" onclick=\"postdelete({$detail['ImageID']},{$uid})\">delete</button>
                </div>
            </li>";
        }
        ?>
    </ul>
    <script>
        function postpage(page) {
            let tempform = document.createElement("form");
            tempform.action = "../php/favor.php";
            tempform.method = "get";
            tempform.style.display = "none"
            let opt = document.createElement("input");
            opt.name = "page";
            opt.value = page;
            tempform.appendChild(opt);
            let opt2 = document.createElement("input");
            opt2.type = "submit";
            tempform.appendChild(opt2);
            document.body.appendChild(tempform);
            tempform.submit();
            document.body.removeChild(tempform);
        }
    </script>
    <?php
    if ($flag) {
        echo "<div id=\"page_number\">";
        $left = $page - 1;
        $right = $page + 1;
        if ($page != 1) echo "<span onclick=\"postpage(" . $left . ")\">《</span>";
        $page_now = 0;
        while ($detail_sum > 0) {
            if ($page_now == 5) break;
            if (++$page_now == $page) echo "<span id='active' onclick=\"postpage(" . $page_now . ")\">" . $page_now . "</span>";
            else {
                echo "<span onclick=\"postpage(" . $page_now . ")\">" . $page_now . "</span>";
            }
            $detail_sum -= 5;
        }
        if ($page != $page_now) echo "<span onclick=\"postpage(" . $right . ")\">》</span>";
        echo "</div>";
    }


    ?>
</div>

<footer>
    Copyright&#169;19302010004 黄呈松
</footer>
</body>


</html>