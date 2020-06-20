<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
<div id="main">
    <img src="../../img/logo_nav.png" class="logo">
    <br>
    <h1>Sign up for Fisher</h1>
    <br>
    <form id="from" action="../php_hidden/register.php" method="GET">
        <table>
            <tr>
                <td>
                    <h6 id="usernameErr">Username:</h6>
                    <input type="text" name="userName" id="username" required>
                </td>
            </tr>
            <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
            <script>
                let flag1 = false;
                let flag2 = false;
                let flag3 = false;
                $(function () {
                    let url = '../php_hidden/checkUsername.php';
                    $("#username").blur(function () {
                        let username = $(this).val();
                        $.ajax({
                            type: 'post',
                            url: url,
                            data: {key: username},
                            dataType: 'json',
                            success: function (data) { //请求成功回调函数
                                let status = data.status; //获取返回值
                                let ans = data.data;
                                if (status == 200) { //判断状态码，200为成功
                                    if (!ans) {
                                        $('#usernameErr').html("Username:<p>used</p>");
                                        flag1 = false;
                                    } else {
                                        $('#usernameErr').html("Username: unused");
                                        flag1 = true;
                                    }
                                }
                            },
                        });
                    });
                });
            </script>
            <tr>
                <td>
                    <h6 id="emailErr">Email:</h6>
                    <input type="text" name="mail" id="mail" required>
                    <script>
                        let mail_regexp = /^([a-zA-Z0-9_-]+)@([a-zA-Z0-9_-]+)((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
                        $('#mail').blur(function () {
                            let mail = this.value;
                            if (mail_regexp.test(mail)) {
                                $('#emailErr').html("Email:");
                                flag2 = true;
                            } else {
                                $('#emailErr').html("Email:<p>not a e-mail</p>");
                                flag2 = false;
                            }
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <h6 id="passwordErr">Password:</h6>
                    <input type="password" name="passWord" id="passWord" required>
                    <script>
                        function checkPassWord(value) {
                            // 0： 表示第一个级别 1：表示第二个级别 2：表示第三个级别
                            // 3： 表示第四个级别 4：表示第五个级别
                            var arr = [], array = [1, 2, 3, 4];
                            if (value.length < 6) {//最初级别
                                return 0;
                            }
                            if (/\d/.test(value)) {//如果用户输入的密码 包含了数字
                                arr.push(1);
                            }
                            if (/[a-z]/.test(value)) {//如果用户输入的密码 包含了小写的a到z
                                arr.push(2);
                            }
                            if (/[A-Z]/.test(value)) {//如果用户输入的密码 包含了大写的A到Z
                                arr.push(3);
                            }
                            if (/\W/.test(value)) {//如果是非数字 字母 下划线
                                arr.push(4);
                            }
                            return arr.length;
                        }

                        function checkRepeated() {
                            if ($('#passWord').val() !== $('#repassWord').val()) {
                                $('#repasswordErr').html("Comfirm Your Password:<p>wrong</p>");
                                flag3 = false
                            } else {
                                $('#repasswordErr').html("Comfirm Your Password:");
                                flag3 = true;
                            }
                        }

                        $('#passWord').blur(function () {
                            checkRepeated();
                            $('#passwordErr').html('Password:<p>strength:' + checkPassWord($('#passWord').val().toString()) + '</p>');
                        })

                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <h6 id="repasswordErr">Comfirm Your Password:</h6>
                    <input type="password" name="repassWord" id="repassWord" required>
                    <script>
                        $('#repassWord').blur(function () {
                            checkRepeated();
                        })
                    </script>
                </td>
            </tr>
        </table>
    </form>
    <a href="javascript:goRegister()">new world</a>
    <script>
        function goRegister() {
            if (flag1 && flag3 && flag2) document.getElementById('from').submit()
        }
    </script>
</div>
<footer>
    Copyright&#169;19302010004 黄呈松
</footer>
</body>
</html>