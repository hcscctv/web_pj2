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
            </li>';
        } else {
            header("Location:./login.php");
        }
        ?>
    </ul>
</nav>
<?php
require_once("wheel.php");
$details = mysqlDo("select * from travelimage where ImageID='{$_POST['imgid']}'")[0];
?>
<div id="main">
    <form action="revise_file.php" method="post" enctype="multipart/form-data" id="form" onsubmit="check_submit()">
        <div id="title">Revise</div>
        <div>
            <img id="img0" <?php echo "src=../../travel-images/medium/" . $details['PATH']; ?>>
            <span class="fileinput-button">
                <!-- 显示的按钮 -->
        <button id="button">重新上传</button>
                <!-- 上传的图片 -->
        <input type="file" name="file" id="file">
        <script src="../js/upload.js">
        </script>
        </span>
        </div>
        <br><br><br><br><br><br>

        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <label>图片标题：</label>
        <input type="text" class="detail_input" name="title" <?php echo "value='" . $details['Title'] . "'"; ?>
               required>
        <br> <label>图片描述：</label>
        <textarea name="detail" id="detail" cols="30" rows="3" <?php echo "value='" . $details['Description'] . "'"; ?> class="detail_input"
                  required><?php echo $details['Description']; ?></textarea>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#160;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <select name="content" id="content" required>
            <option value="scenery" <?php if ($details['Content'] == 'scenery') echo "selected"; ?>>Scenery</option>
            <option value="city" <?php if ($details['Content'] == 'city') echo "selected"; ?>>City</option>
            <option value="people" <?php if ($details['Content'] == 'people') echo "selected"; ?>>People</option>
            <option value="animal" <?php if ($details['Content'] == 'animal') echo "selected"; ?>>Animal</option>
            <option value="building" <?php if ($details['Content'] == 'building') echo "selected"; ?>>Building</option>
            <option value="wonder" <?php if ($details['Content'] == 'wonder') echo "selected"; ?>> Wonder</option>
        </select>

        <select class="area-select" id='country' name="country">
            <option value="<?php $country = mysqlDo("select CountryName from geocountries where ISO='{$details['CountryCodeISO']}'")[0]['CountryName'];
            echo $country; ?>"><?php echo $country ?></option>
            <?php
            $countries = mysqlDo("select CountryName from geocountries");
            for ($i = 0; $i < sizeof($countries); $i++) {
                echo "<option value='{$countries[$i]["CountryName"]}'>{$countries[$i]['CountryName']}</option>";
            }
            ?>
        </select>
        <select class="area-select" id="city" name="city">
            <option value="0">请选择城市</option>
            <option selected
                    value="<?php $city = mysqlDo("select AsciiName from geocities where GeoNameID='{$details['CityCode']}'")[0]['AsciiName'];
                    echo $city; ?>"><?php echo $city; ?></option>
        </select>

        <br>

        <button type="submit" name="submit" onclick="check_submit()">submit</button>
        <script>function check_submit() {
                if (($('#country').val() != 0) && ($('#city').val() != 0)) {
                    let opt = document.createElement("input");
                    opt.name = "imgid";
                    opt.value = <?php echo $_POST['imgid']; ?>;
                    document.getElementById("form").appendChild(opt);
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