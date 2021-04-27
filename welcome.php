<?php

session_start();
 
require_once "config.php";
 
    $codee = $_SESSION["codee"];

    $sql = "SELECT user_id FROM code where code='$codee'";
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        $user_id = $row["user_id"];
                        $_SESSION['user_id'] = $user_id;
                    }
                }

                

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="mycss.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        img {
            width: 300px;
            border-radius: 40%;
        }
        .pic {
            
            position: absolute;
            top: 220px;
            left: 200px;
        }
	form{
padding: 20px;
}
    </style>
    <script>
                function logout(){
                    if(confirm("Are you sure you want to logout?")){
                        window.location.href='logout.php';
                    }
                }
            </script>
               
</head>
<body>
    
    <div class="page-header">
        <h1>Hi,Welcome to our site.</h1>
    </div>
    <p>    
        <input type="submit" onclick="logout()" class="btn btn-danger" name="logout" value="Sign Out of Your Account">
        <a href="reset.php" class="btn btn-danger">View List</a>
    </p>
    <div class="pic">
    <img src="photos/jm.jpg">
    </div>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }

        
    </style>  
    <style>
        .center {
            background-color: lightblue;
            border-radius: 20px;
            position: absolute;
            top: 220px;
            left: 650px;
            width: 400px;
            height: 300px;
	        padding: 30px;
        }
        .footer {
            position: absolute;
            bottom: 0px;
            background-color: black;
            width: 100%;
            height: 30px;
            padding: 20px;
            color: white;
        }
    </style>

<div class="center">  
<form>
	<div class="form-group ">
                <label>LAB ACTIVITY 1</label>
                <label>ITEC 100 - Information Assurance and Security 2</label>
            </div>
            <div class="form-group ">
                <label>Name:</label>
                <label><u>Jolito James P Matabang</u></label>
            </div>    
            <div class="form-group">
            <label>Year/Course:</label>
                <label><u>BSIT3E</u></label>
            </div>
            <div class="form-group ">
                <label>Instructor:</label>
                <label><u>Michael John Reboya</u></label>
<div class="form-group ">
</div>
        </div> 
        </form>
        </div>
<div class="footer">(C) Copyright 2021.</div>
</body>
</html>