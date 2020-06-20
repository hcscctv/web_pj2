<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
<?php
require("../php/wheel.php");
setcookie("username", "", time()-3600);
$userName=get('username');
$result=mysqlDo("SELECT UserName,Pass FROM traveluser WHERE username ='{$userName}'");
if(get('username')==''){
    $nameErr='';
    $passErr='';
}
elseif($result===null) {
    $nameErr="non-exist";
}
else {
    if ($result[0]['Pass'] != hashsalt(get('password'), get('username'))) {
        $passErr = 'wrong';
    } else {
        setcookie("username", encode($userName), time() + 3600);
        header("Location: ../php/HomePage.php");
    }
}?>
    <div class="box">
        <h2>Login</h2>
        <form  id="login" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
            <div class="inputbox">
                <input type="text" name="username" required>
                <label>Username <?php echo $nameErr;?></label>
            </div>
            <div class="inputbox">
                <input type="password" name="password" required>
                <label>Password <?php echo $passErr;?></label>
            </div>
            <div class="inputbox">
                <input type="text" name="check_num" id="code_num" required>
                <label id="check">check number</label>
               <img src="../php_hidden/code_num.php" id="getcode_num" title="看不清，点击换一张" align="absmiddle">
                <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
                <script>$('#getcode_num').click(function () {
                        this.src="../php_hidden/code_num.php";
                    });</script>
            </div>
            <br>
            <input type="button"  id="chk_num" value="submit" onclick="check_submit()">
            <script>
                    function check_submit() {
                        //发送一个post请求
                        let flag=false;
                        let url = '../php_hidden/chk_code.php';
                        let code=$('#code_num').val();
                        $.ajax({
                            type: 'post',
                            url: url,
                            data: {key: code},
                            dataType: 'json',
                            success: function (data) {
                                let status = data.status; //获取返回值
                                if (status == 200)document.getElementById('login').submit();
                                else $('#check').html('wrong');
                            },
                        });

                    }
            </script>
            <input type="button" value="register" id="button2" onclick="window.location.href='register.php'">
        </form>
    </div>
</body>

</html>