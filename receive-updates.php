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

$sender = $reqjsonDecode['sender'];
$text = $reqjsonDecode['text'];
//----test fucntion: Duyet array_sql:

//-------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $res = mysqli_query($conn, "SELECT email FROM user WHERE `user`.`block_friend` != '$sender';");

    $rows_res = array();
    while ($r = mysqli_fetch_assoc($res)) {
        $rows_res[] = $r;
    }
    echo "Text: ".$text. "<br>";
    echo "<br> recipients : ".json_encode($rows_res);
    //var_dump($rows_res);  // 2 emails
    //echo $sender; exit; 
}

$conn->close();
