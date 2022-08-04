<?php
$mysqli = new mysqli("localhost", "root", null, "db_demo");
// Check connection ::
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

//include "../source/connect.php";
//----
$jsonReqUrl  = "php://input";
$reqjson = file_get_contents($jsonReqUrl);
$reqjsonDecode = json_decode($reqjson, true);
//----

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $email1 = $reqjsonDecode['friends'][0];
    $email2 = $reqjsonDecode['friends'][1];

    $kq= mysqli_query($mysqli, "SELECT friend FROM `user` WHERE `user`.`email` = '$email1';");
   
    $rows_kq = array();
    while ($temp = mysqli_fetch_assoc($kq)) {
        $rows_kq[] = $temp;
    }
    $kq = json_encode($rows_kq) ;  

    echo gettype($kq), "<br>"; //string
    echo gettype($rows_kq), "<br>"; // [{"friend":""}] 
    var_dump($rows_kq);

    var_dump(isset($kq)); // true
    var_dump(empty($kq)); //false
    var_dump(!$kq); //false
    //--
    var_dump(count($rows_kq)); // 1

    $flag = 0;
    foreach ($rows_kq as $key => $value) {
        //echo gettype($value);  //aray
        foreach ($value as $key => $val)
        {
            //echo gettype($val);  //string
            if($val === NULL){
                $flag = 1; 
            }
        }
    }

    if ($flag !== 1) {
        $sth = mysqli_query($mysqli, "SELECT friend FROM user  WHERE `user`.`email` = '$email1'");
        $rows = array();
        while ($r = mysqli_fetch_assoc($sth)) {
            $rows[] = $r;
        }
        echo "You Allready have a friend in DB";
        echo  "<br> This is your friend : " . json_encode($rows) . "<br>";
    } else {
        $result = mysqli_query($mysqli, "UPDATE `user` SET `friend` = '$email2' WHERE `user`.`email` = '$email1';");
        if (!$result) {
            echo "cannot make friend !";

        } else {
            $sth = mysqli_query($mysqli, "SELECT friend FROM user  WHERE `user`.`email` = '$email1'");
            $rows = array();
            while ($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }
            echo  "This is your friend : " . json_encode($rows) . "<br>";
            echo "Make new friend successfully.";
        }
    }
}

$mysqli->close();
