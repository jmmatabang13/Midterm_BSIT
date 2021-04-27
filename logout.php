<?php

session_start();
 

require_once "config.php";

    $user_id = $_SESSION['user_id'];
    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s'); 

        $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Logout', '$currentDate')";

            if(mysqli_query($link, $sql1)){

            	session_destroy();
               	header("location: login.php");

            } else{
                echo "ERROR: $sql. " . mysqli_error($link);
            }

            

mysqli_close($link); // Close connection


exit;
?>