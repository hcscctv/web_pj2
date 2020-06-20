<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/Upload.css">
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
            </li>';}
            else{
                header("Location:./login.php");
            }
            ?>
    </ul>
</nav>
<div id="main">
    <form action="upload_file.php" method="post" enctype="multipart/form-data" id="form" onsubmit="return check_submit()">
        <div id="title">Upload</div>
        <div>
            <img id="img0">
            <span class="fileinput-button">
                <!-- 显示的按钮 -->
        <button id="button">上传(暂未上传）</button>
                <!-- 上传的图片 -->
        <input type="file" name="file" id="file" required>
        <script src="../js/upload.js">
        </script>
        </span>
        </div>
        <br><br><br><br><br><br>

        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <label>图片标题：</label>
        <input type="text" class="detail_input" name="title" required>
        <br> <label>图片描述：</label>
        <textarea name="detail" id="detail" cols="30" rows="3" class="detail_input" required></textarea>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#160;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <select name="content" id="content" required>
            <option value="scenery" selected>Scenery</option>
            <option value="city">City</option>
            <option value="people">People</option>
            <option value="animal">Animal</option>
            <option value="building">Building</option>
            <option value="wonder"> Wonder</option>
        </select>

        <select class="area-select" id='country' name="country">
            <option value="0">请选择国家</option>
            <?php
            require('wheel.php');
            $countries = mysqlDo("select CountryName from geocountries");
            for ($i = 0; $i < sizeof($countries); $i++) {
                echo "<option value='{$countries[$i]["CountryName"]}'>{$countries[$i]['CountryName']}</option>";
            }
            ?>
        </select>
        <select class="area-select" id="city" name="city">
            <option value="0">请选择城市</option>
        </select>

        <br>

        <button type="submit" name="submit" onclick="check_submit()">submit</button>
        <script>function check_submit() {
                if (($('#country').val() != 0) && ($('#city').val() != 0)) {
                    return true;
                } else {
                    if ($('#country').val() == 0) {
                        $('#country').css("color", "red");
                    }
                    if ($('#city').val() == 0) $('#city').css("color", "red");
                    return false;
                }
            }</script>
    </form>
</div>
<script>
    $(function () {
        var url = '../js/cities.json';
        $("#country").change(function () {
            var address = $(this).val();
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                success: function (data) {
                    let ans = data[address];
                    var option = '';
                    if (ans == null) option = '\'<option>\' + address + \'</option>\''
                    else for (var i = 0; i < ans.length; i++) {
                        option += '<option value=' + ans[i] + '>' + ans[i] + '</option>';
                    }
                    $("#city").html(option);
                },
            });
        });
    });
</script>
<footer>
    Copyright&#169;19302010004 黄呈松
</footer>
</body>

</html>