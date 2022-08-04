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
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    
    $res = mysqli_query($conn, "SELECT block_update FROM user WHERE `user`.`email` = '$email1';");

    $rows_res = array();
    while ($r = mysqli_fetch_assoc($res)) {
        $rows_res[] = $r;
    }
    $flag = false;
    foreach ($rows_res as $key => $value) {
        foreach ($value as $key => $val)
        {
            echo gettype($val);
            if($val ==="1")
            {
                $flag = true; 
            }
            echo "<br>".$val; 
        }
    }

    //echo $flag; 
    //exit; 

    if($flag === false){
        $result = mysqli_query($conn, "UPDATE user SET `email` = '$email2' WHERE `user`.`email` = '$email1';");
        if (!$result) {
            echo "Cannot update !";
        } else {
            $sth_2 = mysqli_query($conn, "SELECT * FROM user");
            $rows_kq = array();
            while ($r = mysqli_fetch_assoc($sth_2)) {
                $rows_kq[] = $r;
            }
            /* foreach ($rows_kq as $key => $value) {
                foreach ($value as $key => $va) {
                    echo "<br>".$va. "<br>";
                }
            } */
            foreach ($rows_kq as $key => $value) {
                var_dump($value);
            }
            echo "<br>" . json_encode($rows_kq);
            echo "<br> update successfully.";
        }
    }else{
        echo "<br> This email is blocked: SORRY !!! <br>";
    }

   
}

$conn->close();
