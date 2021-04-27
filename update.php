<?php

session_start();

 
require_once "config.php";
 
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['email'] = "";
    $user_id = $_SESSION['id'];

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');
    
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if(empty($new_password_err) && empty($confirm_password_err)){
        
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_email);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_email= $_SESSION["email"];    
            
            if(mysqli_stmt_execute($stmt)){

                $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Change Password', '$currentDate')";
                if(mysqli_query($link, $sql1)){
                       
                } else{
                    echo "ERROR: $sql. " . mysqli_error($link);
                }
    
                session_destroy();
                echo "<script>if(confirm('Successfuly Change!, Please Click Ok!')){document.location.href='login.php'};</script>";
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
if(isset($_POST['cancel'])){
    header("location:login.php");
        
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
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label> New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label> Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="submit" class="btn btn-primary" value="Cancel" name="cancel">
            </div>
        </form>
    </div>    
</body>
</html>