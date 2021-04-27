<?php
session_start();
require_once "config.php";

$email = "";
$email_err = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['email'] = "";

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');

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

                $sql = "SELECT id FROM users where email='$param_email'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        $user_id = $row["id"];
                        $_SESSION['id'] = $user_id;

                        $sql1 = "INSERT INTO event_log (userID, Activity, date_time) VALUES('$user_id', 'Forget Password', '$currentDate')";
                        if(mysqli_query($link, $sql1)){
                       
                        } else{
                            echo "ERROR: $sql. " . mysqli_error($link);
                        }
                    }
                }

                header("location:update.php");
    
            }
        else if(mysqli_stmt_num_rows($stmt) != 1){
            $email_err = "This email is not exist.";
        } else{
            $email = trim($_POST["email"]);
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
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
        <h2>Forget Password</h2>
        <p>Please Enter your email</p>
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Proceed">
                <input type="submit" class="btn btn-primary" value="Cancel" name="cancel">
            </div>
        </form>
    </div>    
    </div>
</body>
</html>