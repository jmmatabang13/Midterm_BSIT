<?php

session_start();

require_once "config.php";
 

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
       
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = trim($_POST["username"]);
            
            
            if(mysqli_stmt_execute($stmt)){
               
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
   
   $upcase = "/(?=.*?[A-Z])/";
   $locase = "/(?=.*?[a-z])/";
   $specchar = "/(?=.*?[#?!@$%^&*-])/";
   $num = "/(?=.*?[0-9])/";
   $mail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');

    // password validation
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";        
    } 
    elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";         
     }
    elseif(!preg_match($specchar,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) special characters.";
    }
    elseif(!preg_match($num,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) number.";
    }
    elseif(!preg_match($locase,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) lowercase.";
    }
    elseif(!preg_match($upcase,$_POST['password'])){
        $password_err = "Password must contain atleast one(1) uppercase.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    //confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a Email.";
}
else{
$sql = "SELECT id FROM users WHERE email = ?";
    
if($stmt = mysqli_prepare($link, $sql)){
    
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    
    
    $param_email = trim($_POST["email"]);
}
if(mysqli_stmt_execute($stmt)){
           
mysqli_stmt_store_result($stmt);

if(mysqli_stmt_num_rows($stmt) == 1){
    $email_err = "This email is already taken.";
} else{
    $email = trim($_POST["email"]);
}
} else{
echo "Oops! Something went wrong. Please try again later.";
}
}

    
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        
        $sql = "INSERT INTO users (username, password,email) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            
            
            if(mysqli_stmt_execute($stmt)){

                $sql = "SELECT id FROM users where username='$param_username'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        $user_id = $row["id"];
                        $_SESSION['id'] = $user_id;

                        $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Sign-Up', '$currentDate')";
                        if(mysqli_query($link, $sql1)){
                       
                        } else{
                            echo "ERROR: $sql. " . mysqli_error($link);
                        }
                    }
                }
                
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="mycss.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 500px; padding: 20px; }
	.center {
            background-color: lightblue;
            border-radius: 10px;
            position: absolute;
            box-shadow: 5px 5px blue;
            top: 160px;
            left: 680px;
        }
        .left {
            position: absolute;
            top: 0;
             left: 90px;
        }
    </style>
</head>
<body>
 <div class="left"><img src="photos/bg.png"></div>
 <div class="center">
 <div class="wrapper">  
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
		 <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
    </body>
    </html>