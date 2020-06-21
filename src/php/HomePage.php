<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/Homepage.css">
</head>

<body>
<script src="../js/particles.js"></script>
<div id="main">
    <nav>
        <ul id="nav" name="nav">
            <li id="logo">
                <a href="HomePage.php"><img src="../../img/logo_nav.png"></a>
            </li>
            <li class="this"><a href="HomePage.php">Home</a></li>
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
                </li>';}
                else{
                    echo "<li id='account'><a href='./login.php'>login</a></li>";
                }
                ?>
            </ul>
        </nav>
        <div class="slidershow middle">

            <div class="slides">

                <input type="radio" name="r" id="r1" checked />
                <input type="radio" name="r" id="r2" />
                <input type="radio" name="r" id="r3" />
                <input type="radio" name="r" id="r4" />

                <div class="slide s1">
                    <img src="../../img/showimages/1.jpg" alt="photo" />
                </div>

                <div class="slide">
                    <img src="../../img/showimages/2.jpg" alt="photo" />
                </div>

                <div class="slide">
                    <img src="../../img/showimages/3.jpg" alt="photo" />
                </div>
                <div class="slide">
                    <img src="../../img/showimages/4.jpg" alt="photo" />
                </div>
            </div>

            <div class="navigaion">
                <label for="r1" class="bar"></label>
                <!-- label标签为 input 元素定义标注  "for"属性可把label绑定到另外一个元素。请把 "for" 属性的值设置为相关元素的 id 属性的值。 -->
                <label for="r2" class="bar"></label>
                <label for="r3" class="bar"></label>
                <label for="r4" class="bar"></label>
            </div>

        </div>
    <br>
    <div class="hot_image_area">
        <?php
        require("./wheel.php");
        require('../php_hidden/img_show.php');

        function hotImage($id)
        {
            $details = mysqlDo("select Title,Description from travelimage where ImageID='$id'");
            echo "<div class=\"hot_image\">" . img($id, "show_pic") . " <p class=\"image_title\">" . $details[0]['Title'] . "</p>"
                . "<p class=\"image_description\">" . $details[0]['Description'] . "</p>
            </div>";
        }

        $show = mysqlDo("Select ImageID from travelimage order by like_num desc limit 0,12");
        for ($i = 0; $i < 12; $i++) {
            hotImage($show[$i]['ImageID']);
        }
        ?>
    </div>
</div>

<div class="float_button">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <img src="../../img/refresh.png" title="刷新" id="refresh_button" class="refresh_button">
    <script>
        $(function () {
            let url = '../php_hidden/home_page_refresh.php'; //后台地址
            $("#refresh_button").click(function () {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {key: 1},
                    dataType: 'json',
                    success: function (data) {
                        let status = data.status;
                        let details = data.data;
                        if (status == 200) {
                            hotimages = document.getElementsByClassName("hot_image");
                        }
                        for (let i = 0; i < 12; i++) {
                            hotimages[i].innerHTML = "<img src=\"../../travel-images/medium/" + details[i]['PATH'] + "\" class=\"show_pic\" onclick=\"postid(" + details[i]['ImageID'] + ")\">" +
                                " <p class=\"image_title\">" + details[i]['Title'] + "</p><p class=\"image_description\">" + details[i]['Description'] + "</p>"
                        }
                    },
                });
            });
        });
    </script>
    <a href="#nav"><img src="../../img/back_to_top.png" id="back_to_top" class="back_to_top"></a>
</div>

<div id="footer">
    <br>
    <div id="footer_left"><a href="">帮助</a>
        <a href="">举报</a>
        <a href="">用户反馈</a><br><br> Copyright&#169;19302010004&nbsp;沪ICP备20008620号<br>
    </div>
    <div id="footer_right">
        <img src="../../img/1586323807.png" alt="">
    </div>

</div>
</body>

</html>