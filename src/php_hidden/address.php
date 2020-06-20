<?php
$key = $_POST['key']; //获取值
$result['status'] = 200;
if ($key === 0) $result['status'] = 202;
else {
    require("../php/wheel.php");
    $cities = mysqlDo("select CityCode from travelimage where CountryCodeISO='{$key}' group by CityCode");
    for ($i = 0; $i < sizeof($cities); $i++) {
        $result['data'][$i] = mysqlDo("select AsciiName,GeoNameID from geocities where GeoNameID={$cities[$i]['CityCode']};")[0];
    }
}
echo json_encode($result); //返回JSON数据
?>