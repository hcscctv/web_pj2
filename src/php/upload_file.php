<?php
class imgcompress
{
    private $src;
    private $image;
    private $imageinfo;
    private $percent = 0.5;

    public function __construct($src, $percent = 1)
    {
        $this->src = $src;
        $this->percent = $percent;
    }

    public function compressImg($saveName = '')
    {
        $this->_openImage();
        if (!empty($saveName)) $this->_saveImage($saveName);  //保存
        else $this->_showImage();
    }

    private function _openImage()
    {
        list($width, $height, $type, $attr) = getimagesize($this->src);
        $this->imageinfo = array(
            'width' => $width,
            'height' => $height,
            'type' => image_type_to_extension($type, false),
            'attr' => $attr
        );
        $fun = "imagecreatefrom" . $this->imageinfo['type'];
        $this->image = $fun($this->src);
        $this->_thumpImage();
    }

    private function _thumpImage()
    {
        $new_width = $this->imageinfo['width'] * $this->percent;
        $new_height = $this->imageinfo['height'] * $this->percent;
        $image_thump = imagecreatetruecolor($new_width, $new_height);
        //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度
        imagecopyresampled($image_thump, $this->image, 0, 0, 0, 0, $new_width, $new_height, $this->imageinfo['width'], $this->imageinfo['height']);
        imagedestroy($this->image);
        $this->image = $image_thump;
    }

    private function _showImage()
    {
        header('Content-Type: image/' . $this->imageinfo['type']);
        $funcs = "image" . $this->imageinfo['type'];
        $funcs($this->image);
    }

    private function _saveImage($dstImgName)
    {
        if (empty($dstImgName)) return false;
        $allowImgs = ['.jpg', '.jpeg', '.png', '.bmp', '.wbmp', '.gif'];   //如果目标图片名有后缀就用目标图片扩展名 后缀，如果没有，则用源图的扩展名
        $dstExt = strrchr($dstImgName, ".");
        $sourseExt = strrchr($this->src, ".");
        if (!empty($dstExt)) $dstExt = strtolower($dstExt);
        if (!empty($sourseExt)) $sourseExt = strtolower($sourseExt);

        //有指定目标名扩展名
        if (!empty($dstExt) && in_array($dstExt, $allowImgs))
        {
            $dstName = $dstImgName;
        }
        elseif (!empty($sourseExt) && in_array($sourseExt, $allowImgs))
        {
            $dstName = $dstImgName . $sourseExt;
        }
        else
        {
            $dstName = $dstImgName . $this->imageinfo['type'];
        }
        $funcs = "image" . $this->imageinfo['type'];
        $funcs($this->image, $dstName);
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }
}

require('../php/wheel.php');
echo ($_COOKIE['username']);
$user=decode($_COOKIE['username']);
echo $user;
$uid = mysqlDo("select UID from traveluser where UserName='{$user}'")[0]['UID'];//UID
echo $uid;
$countrycode=mysqlDo("select ISO from geocountries where CountryName='{$_POST['country']}'")[0]['ISO'];
$citycode=mysqlDo("select GeoNameID from geocities where AsciiName='{$_POST['city']}'")[0]['GeoNameID'];
$uploadRoot=dirname(dirname(dirname(__FILE__)))."/travel-images\medium/"; //取得当前文件的上一层目录名，结果：D:\
$allowedExts = array("jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
    && in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        $detail=htmlspecialchars($_POST["detail"]);
        $link = mysqli_connect('localhost', 'pma', '3amvKokUVvIIvbES','pj2');
        $path = md5(uniqid(microtime(true),true)).".".$extension;
        $sql= "insert into travelimage (Title, Description, CityCode, CountryCodeISO, UID, PATH, Content, like_num) values ('{$_POST["title"]}','{$detail}','{$citycode}','{$countrycode}','{$uid}','{$path}','{$_POST["content"]}','0')";
        $result = $link->query($sql);
        mysqli_close($link);
        $destination=$uploadRoot.$path;
        $size_MB = $_FILES["file"]["size"] / 1048576.0;
        if ($size_MB < 0.2)
            move_uploaded_file($_FILES['file']['tmp_name'], $destination);
        else
            (new imgcompress($_FILES['file']['tmp_name'],(0.2/sqrt($size_MB))))->compressImg($destination);

    }
}
else
{
    echo "非法的文件格式";
}
header("Location:./my_photo.php");
?>