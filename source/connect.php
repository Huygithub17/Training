<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_demo";

$conn = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
    echo "connect fail: " . mysqli_connect_errno();
    exit;
}


//$mysqli->close();
//mysqli_close($con);
