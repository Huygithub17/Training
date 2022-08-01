<?php
include "./source/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sth = mysqli_query($conn, "SELECT * FROM person ");
    $rows = array();
    while ($r = mysqli_fetch_assoc($sth)) {
      $rows[] = $r;
    }
    echo json_encode($rows). "<br>";
}
//--------------
$jsonReqUrl  = "php://input";
$reqjson = file_get_contents($jsonReqUrl);
$reqjsonDecode = json_decode($reqjson, true);

$firstname = $reqjsonDecode['firstname'];
$lastname = $reqjsonDecode['lastname'];
$email = $reqjsonDecode['email'];
$id = $reqjsonDecode['id'];
//-------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $firstname = $_POST['firstname'];
    // $lastname = $_POST['lastname'];
    // $email = $_POST['email'];
    
    // TODO::
    $sql = "INSERT INTO `person` (`id`, `firstname`, `lastname`, `email`) VALUES (NULL, '$firstname', '$lastname','$email');";
    //$result = mysqli_query($con, "INSERT INTO `person` (`id`, `firstname`, `lastname`, `email`) VALUES (NULL, '$firstname', '$lastname','$email');");
    // $conn->query($sql) === TRUE;
    // mysqli_query($con, $sql) === TRUE;
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $sth = mysqli_query($conn, "SELECT * FROM person WHERE id = '$last_id'");
        $rows = array();
        while ($r = mysqli_fetch_assoc($sth)) {
          $rows[] = $r;
        }
        echo json_encode($rows);
        echo "New record created successfully. Last inserted ID is: " . $last_id;

      } else {
        echo "Error: " . $sql . "<br>" . $con->error;
      }
}
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $result = mysqli_query($conn, "UPDATE `person` SET `firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email' WHERE `person`.`id` = '$id';");
    if (!$result) {
        echo "Cannot update !"; 
    }else{
        $sth = mysqli_query($conn, "SELECT * FROM person ");
        $rows = array();
        while ($r = mysqli_fetch_assoc($sth)) {
          $rows[] = $r;
        }
        echo json_encode($rows). "<br>";
        echo "update successfully.";
    } 
    mysqli_close($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //echo "This is DELETE method"; 
    $result = mysqli_query($conn, "DELETE FROM `person` WHERE `person`.`id` = '$id';");
    if (!$result) {
        echo "Cannot delete !"; 
    }else{
        $sth = mysqli_query($conn, "SELECT * FROM person ");
        $rows = array();
        while ($r = mysqli_fetch_assoc($sth)) {
          $rows[] = $r;
        }
        echo json_encode($rows). "<br>";
        echo "delete successfully.";
    } 
    mysqli_close($conn);
}

?>