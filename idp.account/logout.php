
<?php

	session_start();

	$con = mysqli_connect("localhost","root","","database");
	
    $sql1 = "SELECT * FROM token_table ORDER BY id DESC LIMIT 1";
    $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));

    $row = mysqli_fetch_assoc($result1);
    $USER_ID = $row['user_id'];


    $sql2 = "SELECT username FROM users WHERE userID = '$USER_ID'";
    $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

    $row = mysqli_fetch_assoc($result2);
    $username = $row['username'];


	$logout_time = date("Y-m-d H:i:s");
    $sql = "UPDATE session_table SET logout_time='$logout_time' WHERE username='$username'";

    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    if(!$result){
        echo "Error updating logout time". mysqli_error($con);
    }
    else{
        echo "Logout time updated successfully".'<br>'; 
    }

	session_unset();
	session_destroy();

   echo "Logged Out";
   
   exit;
?>
