<?php
include "../source/connect.php";
//-------------
//finished_02/8
/* $mysqli = new mysqli("localhost", "root", null, "db_demo");
// Check connection ::
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
} */
//--------------
$jsonReqUrl  = "php://input";
$reqjson = file_get_contents($jsonReqUrl);
$reqjsonDecode = json_decode($reqjson, true);

$email1 = $reqjsonDecode['friends'][0];
$email2 = $reqjsonDecode['friends'][1];
//-------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //echo $email1;
    $sth = mysqli_query($conn, "SELECT friend FROM user WHERE `user`.`email` = '$email1';");

   /*  if (!$sth) {
        die(mysqli_error($mysqli));
    } */
    $rows = array();
    while ($r = mysqli_fetch_assoc($sth)) {
        $rows[] = $r;
    }
    echo "<br>" . json_encode($rows);
}

$conn->close();
