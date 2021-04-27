<?php

session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
require_once "config.php";

$_SESSION["verify"] = false;
$_SESSION["code_access"] = false;
$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
                   
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty($username_err) && empty($password_err)){

         if(empty($username_err) && empty($password_err)){ 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){ 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
             
            $param_username = $username;
             
            if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);            
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            $_SESSION["verify"] = true;
                            $_SESSION["code_access"] = true;
                            $_SESSION["id"] = $id;
                            $permitted_chars = '0123456789';

                            $duration = floor(time()/(60*2));
                            srand($duration);
                            $_SESSION["codee"] = substr(str_shuffle($permitted_chars), 0, 6);
                                    
                            date_default_timezone_set('Asia/Manila');
                    
                            $currentDate = date('Y-m-d H:i:s');
                            $currentDate_timestamp = strtotime($currentDate);
                            $endDate_months = strtotime("+2 minutes", $currentDate_timestamp);
                            $packageEndDate = date('Y-m-d H:i:s', $endDate_months);
                                
                            $_SESSION["current"] = $currentDate;
                            $_SESSION["expired"] = $packageEndDate;
                    
                            $user_id = $_SESSION["id"];
                            $codee = $_SESSION["codee"];
                            
                    
                            $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$codee', '$currentDate', '$packageEndDate')";
                            
                            $result = mysqli_query($link,"select * from code where code='$codee'") or die('Error connecting to MySQL server');
                            $count = mysqli_num_rows($result);
                            if($count == 0)
                            {
                                if(mysqli_query($link, $sql)){
                                   
                                } else{
                                echo "ERROR: $sql. " . mysqli_error($link);
                                }
                            }else{
                           
                            }
                            $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$id', 'Verification', '$currentDate')";
                            if(mysqli_query($link, $sql1)){
                       
                            } else{
                            echo "ERROR: $sql. " . mysqli_error($link);
                            }
                      
                            echo "<script>if(confirm('This is your Code: $codee')){document.location.href='verification.php'};</script>";
                            
                            
                        } else{ 
                             
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{ 
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="mycss.css">
    <style type="text/css">
        body{ 
            font: 14px sans-serif; 
        }
        .wrapper{ 
            width: 350px; padding: 20px; 
        }

        .center {
            background-color: lightblue;
            border-radius: 20px;
            position: absolute;
            top: 200px;
            left: 750px;
            box-shadow: 5px 5px blue;
        }
        .left {
            position: absolute;
            top: 0;
	        left: 110px;
            
        }
    </style>
</head>  
<body>
    <div class="left"><img src="photos/bg.png"></div>
    <div class="center">    
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
                <p>Did you forget your password? <a href="forget.php">Forget Password</a>.</p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
    </div>
</body>
</html>