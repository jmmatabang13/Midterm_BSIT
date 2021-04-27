<?php

$link = mysqli_connect("localhost", "root", "", "demo");
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 

$sql = "SELECT * FROM event_log";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table style=\"width:700px;\">";
            echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>UserID</th>";
                echo "<th>Activty</th>";
                echo "<th>Date&Time</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['eID'] . "</td>";
                echo "<td>" . $row['userID'] . "</td>";
                echo "<td>" . $row['Activity'] . "</td>";
                echo "<td>" . $row['date_time'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 


mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="mycss.css">
<style>


table, th, td {
    border: 2px solid black;
    text-align:center;
    margin-bottom:5px;
    margin-left:5px;
   
}
.left {
            position: absolute;
            top: -30px;
	        left: 55%;
            
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
<div class="left"><img src="photos/bg.png"></div>

<p>    
<input type="submit" onclick="logout()" class="btn btn-danger" name="logout" value="Sign Out of Your Account">
        <a href="welcome.php" class="btn btn-danger">Back</a>
    </p>
</body>
</html>