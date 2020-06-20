<?php
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