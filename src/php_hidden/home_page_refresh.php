<?php
require("../php/wheel.php");
$result['status'] = 200;
$result['data'] = mysqlDo("select PATH,Title,Description,ImageID from travelimage ORDER BY  RAND() LIMIT 12");
echo json_encode($result);
