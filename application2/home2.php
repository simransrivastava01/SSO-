<?php
session_start();

$con = mysqli_connect("localhost","root","","database");
if(!$con){
    die("Connection Failed: ".mysqli_connect_error());
}

    $sql1 = "SELECT * FROM token_table ORDER BY id DESC LIMIT 1";
    $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));

    $row = mysqli_fetch_assoc($result1);
    $USER_ID = $row['user_id'];

    $sql2 = "SELECT username FROM users WHERE userID = '$USER_ID'";
    $result2 = mysqli_query($con, $sql2) or die(mysqli_error($con));

    $row = mysqli_fetch_assoc($result2);
    $username = $row['username'];

    echo '<html>
    <head>
        <title>Application2</title>
    </head>
    <body style="text-align:center;">
    <h1>Application2</h1>
    <div class="container" style="background-color:#f1f1f1"><br>
    </body>
    </html>';
    print "<h3>Hello <b>{$username}!</b> </h3> <p>Welcome, You are logged in to Application2</p>";
    echo '<html>
    <body style="text-align:center;">
    <a href="http://idp.account.com:8080/logout.php"><button style="background-color:red;color:white;size:50px;font-size:16px;">Logout</button></a><br><br><br>
    </div>
</body>
</html>';

?>
