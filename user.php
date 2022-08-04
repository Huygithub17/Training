<?php
$mysqli = new mysqli("localhost", "root", null, "db_demo");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
//----
$jsonReqUrl  = "php://input";
$reqjson = file_get_contents($jsonReqUrl);
$reqjsonDecode = json_decode($reqjson, true);
$email = $reqjsonDecode['email'];
// $id = $reqjsonDecode['id'];
//----
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "This is GET method";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $sql = "INSERT INTO `user` (`id`,`email`,`friend`) VALUES (NULL, '$email', NULL);";
    //TODO::
    if ($mysqli->query($sql) === TRUE) {
        $last_id = $mysqli->insert_id;
        $sth = mysqli_query($mysqli, "SELECT * FROM user WHERE id = '$last_id'");
        $rows = array();
        while ($r = mysqli_fetch_assoc($sth)) {
            $rows[] = $r;
        }
        echo json_encode($rows);
        echo " <br> New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DETETE') {
    echo "This is DELETE method";
    exit;
}

$mysqli->close();
