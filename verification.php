<?php 

session_start(); 

if(!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true){
    header("location: login.php");
    exit;
}
 
require_once "config.php";

$user_id = "";
$code_err = "";
$_SESSION["code_access"] = true;



if(isset($_POST['login']))
{ 
    if(empty(trim($_POST["code"]))){
        echo "<script>alert('Please Enter your Code');</script>";
    } else{ 

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        $user_id = $_SESSION["id"];
        

        $id_code = mysqli_query($link,"SELECT * FROM code WHERE code='$code' AND id_code=id_code") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($id_code);


        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'demo';

        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT expiration FROM code where code='$code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<div style='display: none;'>"."Expiration: " . $row["expiration"]. "<br>";
                echo $currentDate."<br></div>";
                if(($row["expiration"]) >($currentDate)){

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;
                    $codee =$_SESSION["codee"];

                    $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Login', '$currentDate')";
                    if(mysqli_query($link, $sql1)){
               
                    } else{
                    echo "ERROR: $sql. " . mysqli_error($link);
                    }

                    header("location: welcome.php");

                }
                else{
                    echo "<script>if(confirm('Expired Code, Please Try Again Back to Login Page Again')){document.location.href='login.php'};</script>";
                }
            }
          } else {
            echo "<script>if(confirm('Error Code, Please Try Again Back to Login Page Again')){document.location.href='login.php'};</script>";
          }

          $conn->close();
    }
    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="mycss.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>autheticator</title>
  <style>
     body{ 
            font: 14px sans-serif; 
        }
    .wrapper{ 
            width: 350px; padding: 20px; 
        }

        .center {
            background-color: lightblue;
            border-radius: 70px;
            position: absolute;
            top: 250px;
            left: 520px;
            height: 250px;
            padding: 20px;
            text-align:center;
            opacity:0.9;
            box-shadow: 5px 5px blue;
        }
        .left {
            position: absolute;
            top: 0px;
            left: 415px;
            
        }
    </style>      
</head>  
<body>
    
    <div class="left">
    <img src="photos/bg.png">
    </div>
    <div class="center">    
    <div class="wrapper">
        <h2>Verification</h2>
        
        
        <form role="form" method="post">

                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" placeholder="Code">
                   
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary">Submit</button><BR> 
                </div>

                
        </form>

    
</body>
</html>