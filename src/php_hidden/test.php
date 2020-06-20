<p>验证码：<input type="text" class="input" id="code_num" name="code_num" maxlength="4"/>

    <img src="code_num.php" id="getcode_num" title="看不清，点击换一张" align="absmiddle"></p>

<p><input type="button" class="btn" id="chk_num" value="提交"/></p>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    $('#getcode_num').click(function () {
        this.src="code_num.php";
    });

    $(function () {
        //初始化数据
        let url = '../php_hidden/chk_code.php'; //后台地址
        $("#chk_num").click(function () {
            //发送一个post请求
            let code=$('#code_num').val();
            $.ajax({
                type: 'post',
                url: url,
                data: {key: code},
                dataType: 'json',
                success: function (data) {
                    let status = data.status; //获取返回值
                    if (status == 200) { //判断状态码，200为成功
                        alert('success')
                    }
                    else alert("wrong");
                },
            });
        });
    });
</script>