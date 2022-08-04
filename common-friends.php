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
if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
    $sth = mysqli_query($conn, "SELECT friend FROM user WHERE `user`.`email` = '$email1';");
    $rows = array();
    while ($r = mysqli_fetch_assoc($sth)) {
        $rows[] = $r;
    }
    echo "<br>" . json_encode($rows);

    $sth_2 = mysqli_query($conn, "SELECT friend FROM user WHERE `user`.`email` = '$email2';");
    $rows_2 = array();
    while ($r = mysqli_fetch_assoc($sth_2)) {
        $rows_2[] = $r;
    }
    echo json_encode($rows_2) . "<br>";

    $email1_temp = "";
    $email2_temp = "";
    foreach ($rows as $key => $value) {
        foreach ($value as $key => $val) {
            $email1_temp = $val;
        }
    }
    $count = 0;
    foreach ($rows_2 as $key => $value) {
        foreach ($value as $key => $va) {
            $email2_temp = $va;
            $count++;
        }
    }

    echo $email1_temp . "<br>";
    echo $email2_temp;

    if (strcmp($email1_temp, $email2_temp) == 0) {
       echo "<br> You have common friend: true";
       echo "<br> This is your friend common: ". $email1_temp ."<br>";
       echo "count: ".$count;
    } else {
        echo "<br>Don't have common friend !";
    }
}

$conn->close();
