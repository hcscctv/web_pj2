# web_pj2开发文档

> 19302010004 黄呈松

### 整体概述

- pj除搜索界面以外采取MVC模式，将前后端分离，便于维护和升级
- 前端布局沿用pj1设计 （https://github.com/hcscctv/web_pj） 
  采用html+js（以jQuery为主）+css
- 后端采取原生php（7.0）+mysql的方式
- 可在chrome浏览器及firefox浏览器完善运行
- 可在其余主流浏览器正常运行，可能出现极小范围布局错位
  
##### 文件结构
```
web_pj
├─ .idea
├─ img //页面布局中所使用到的一些图片
├─ index.html //用于云端部署的首页，跳转至homepage
├─ pj2.sql //后端数据库
├─ readme.md //本文档
├─ src //相关代码
│  ├─ css //对应css
│  ├─ js //使用到的js
│  ├─ php //前端页面
│  └─ php_hidden //后端程序
└─ travel-images
   └─ medium //储存图片的文件夹
    
```

##### 相关地址

+ github地址：https://github.com/hcscctv/web_pj2
+ 网站地址：http://hcscctv.xyz:51222
+ icp备案完成，网安未备案（实在懒得弄了，面完试立刻马上把网站下架）
  
### 项目基本要求完成情况

>基础功能全部完成，后续解释部分功能实现，部分省略的功能详见pj1文档,未写明的部分面试时详细解释

##### 首页图片刷新

>> 考虑到直接刷新整个界面会使页面回到最上方，故采用ajax直接修改界面元素
``` js
 $(function () {
            let url = '../php_hidden/home_page_refresh.php';//该页面将返回一个json对象含有将要换的12张图片信息
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
                        //省略修改图片的部分
                    },
                });
            });
        });
```

##### 二级联动

>> 为防止过多城市的国家传输速度较慢，采用本地静态json文件的方式进行二级联动，但是再服务器上由于带宽限制还是会有一定延迟

```js
$(function () {
        var url = '../js/cities.json';
        $("#country").change(function () {
            var address = $(this).val();
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                success: function (data) {
                    //省略修改下拉框的部分
                },
            });
        });
    });
```

##### 联合筛选及翻页

>> browse页联合筛选采用纯mysql语句，采取get方法尽量实现Restful风格,维护url用于翻页，sql用于搜索

```php
if (isset($_GET["content"])) {
    if ($url != "") $url .= "&";
    $url .= "content=" . $_GET["content"];
    if ($sql === "") $sql .= "WHERE ";
    else $sql .= "and ";
    $sql .= "Content = '{$_GET["content"]}' ";
}

$title = $_GET["title"];
$title = str_replace("[", "[[]", $title);
$title = str_replace("]", "[]]", $title);
$title = str_replace("_", "[_]", $title);
$title = str_replace("%", "[%]", $title);//出现like关键词的替换

```
>>翻页功能通过php实现

```php
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
```

##### 注册界面的提示

>>通过ajax及时提示用户名重复，两次密码不相同等，此处以用户名重复为例

```js
$(function () {
                    let url = '../php_hidden/checkUsername.php';//用于检查是否重复的后台
                    $("#username").blur(function () {
                        let username = $(this).val();
                        $.ajax({
                            type: 'post',
                            url: url,
                            data: {key: username},
                            dataType: 'json',
                            success: function (data) {
                                let status = data.status; 
                                let ans = data.data;
                                if (status == 200) {
                                  //省略给出相应提示信息的部分
                                }
                            },
                        });
                    });
                });
```

### bonus完成情况
##### bonus1 密码的哈希加盐储存
>>为防止更多储存消息未使用随机盐，为了预防安全也未使用固定盐，采用用户名作为盐值进行两次sha1加密
```php
function hashsalt($password, $salt)
{
    return sha1(sha1($password) . $salt);
}
```

```php
$password = hashsalt($_GET['passWord'], $_GET['userName']);//注册时的保存用密码
```

##### 云端部署
>>采用阿里云学生服务器，网址hcscctv.xyz:51222

##### 前端框架
>>未曾使用，但自己用js写了动态背景将在下一部分解释

### bonus外额外部分

>主要以网络安全部分为主，加上手写的动态背景

+ 简单的通过htmlspecialchars()进行了防止XSS攻击
  
+ 简单的防止了简单的sql注入大致如下
  ```php
  function SQLprepare(&$str)//SQL防注入
    {
    $str = preg_replace("/(DELETE)|(INSERT)|(UPDATE)|(SELECT)|(DROP)|(DATABASE)|(#)/", " ", strtoupper($str));
    $str = str_replace("'", "''", $str);//单引号转义
    }
  ```

+ 简单的通过同时上传userID的方式防止了delete页的CSRF攻击
```js
  function postdelete(imgid,userid){
    let tempform = document.createElement("form");
    tempform.action = "../php_hidden/delete_collect.php";
    tempform.method = "post";
    tempform.style.display="none"
    let opt = document.createElement("input");
    opt.name = "imgid";
    opt.value = imgid;
    tempform.appendChild(opt);
    let opt1 = document.createElement("input");
    opt1.name = "userid";
    opt1.value = userid;
    tempform.appendChild(opt1);
    let opt2 = document.createElement("input");
    opt2.type = "submit";
    tempform.appendChild(opt2);
    document.body.appendChild(tempform);
    tempform.submit();
    document.body.removeChild(tempform);
  }
```
+ 简单的cookie加密
  >>通过base64进行cookie加密保存用户名记录登陆状态

+ 简单的验证码
  
  >>登录页采用验证码的方式防止密码撞库,密码保存在session中用于验证

```php
    session_start();
    getCode(4,320,60);
    function getCode($num,$w,$h) {
    $code = "";
    for ($i = 0; $i < $num; $i++) {
        $code .= rand(0, 9);
    }
    $_SESSION["helloweba_num"] = $code;
    header("Content-type: image/PNG");
    $im = imagecreate($w, $h);
    $black = imagecolorallocate($im, 0, 0, 0);
    $gray = imagecolorallocate($im, 200, 200, 200);
    imagefill($im, 0, 0, $gray);
    imagerectangle($im, 0, 0, $w-1, $h-1, $black);
    $style = array ($black,$black,$black,$black,$black,
        $gray,$gray,$gray,$gray,$gray
    );
    imagesetstyle($im, $style);
    $y1 = rand(0, $h);
    $y2 = rand(0, $h);
    $y3 = rand(0, $h);
    $y4 = rand(0, $h);
    imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED);

    imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED);
    for ($i = 0; $i < 150; $i++) {
        imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
    }
    //将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
    $strx = rand(30, 90);
    for ($i = 0; $i < $num; $i++) {
        $strpos = rand(20, 40);
        imagestring($im, 10000, $strx, $strpos, substr($code, $i, 1), $black);
        $strx += rand(30, 50);
    }
    imagepng($im);//输出图片
    imagedestroy($im);//释放图片所占内存
}
```

+ 背景采用js进行canvas绘图，背景灵感来自某网站（具体忘了），背景js中部分代码来自网络
  
+ 图片过大会进行压缩后存储防止传输过慢

### 对pj及课程建议
>>我说了也只能造福（？）以后的人了，害...  
pj2有点滑大量工作时重复的复制粘贴...有许多页面内容高度相似例如delete功能和取消关注功能
绝大部分与php高度相关，与js关系不大（这是我尝试完成动态背景的原因）pj中基本只会使用到DOM的相关内容  
课程中有一些内容（如对象继承等）完全没有使用到，现有要求绝大部分靠面向百度都有现成的模块可以使用，个人感觉对能力帮助不大(但往年似乎也是这样)  
pj整体内容设计有亿点点简单，加之分数不能超过100让人没有继续好好认真研究的动力，给人一种真的很简单的网站。  
课程跟pj有丢丢脱节（虽然我是边写边学的，没什么感受）  

>>然后  
助教人很好也很帅
老师人很好不知道长什么样








