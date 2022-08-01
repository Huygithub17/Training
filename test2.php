<?php
$mysqli = new mysqli("localhost", "root", null, "demo");

// Check connection
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  echo "This is GET method";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo "This is POST method";
  $jsonReqUrl  = "php://input";
  $reqjson = file_get_contents($jsonReqUrl);
  $reqjsonDecode = json_decode($reqjson, true);
  // echo $reqjsonDecode['first_name'] . "\n";
  // echo $reqjsonDecode['last_name']. "\n";
  // echo $reqjsonDecode['email'];
  //TODO::
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  echo "This is PUT method";
  exit;
}

$mysqli->close();
