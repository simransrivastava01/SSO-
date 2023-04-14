<?php

session_start(); // Start or resume a session


$con = mysqli_connect("localhost","root","","database");
if(!$con){
    die("Connection Failed: ".mysqli_connect_error());
}

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
{
    if($_GET['source']=='app1')
    {
        $AppName = 'Application1'; 
        $home = 'home1';
    }
    elseif($_GET['source']=='app2')
    {
        $AppName = 'Application2'; 
        $home = 'home2';
    }
    else
    {
        echo "Invalid source";
    }
    header('Location: http://'.$AppName.'.com:8080/'.$home.'.php');
    exit;

}

// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username and password from the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the credentials against the users table in the database
    // You should replace the database credentials with your own
    $dbHost = 'localhost';
    $dbName = 'database';
    $dbUser = 'root';
    $dbPass = '';

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to retrieve the user with the given username and password
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');

        // Bind the values to the parameters in the SQL statement
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);

        // Execute the SQL statement
        $stmt->execute();

        // Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user was found
        if ($user) {
            // Set a session variable to indicate that the user is logged in
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
        

        $cookie_name = array_keys($_COOKIE);
        $latest_cookie_name = end($cookie_name);
        //echo "Latest Cookie is: " . $latest_cookie_name;

        function get_token_from_cookie($latest_cookie_name){
            if(isset($_COOKIE[$latest_cookie_name])){
                return $_COOKIE[$latest_cookie_name];
            }
            else{
                return null;
            }
        }

        $token_value = get_token_from_cookie($latest_cookie_name);

        $session_id = session_id();

        $username =  $_SESSION['username'];

        $sql = "SELECT userID FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $sql);

        $sql1 = "SELECT * FROM application_table ORDER BY ID DESC LIMIT 1";
        $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));

        
        if(mysqli_num_rows($result)>0)
        {
            $row = mysqli_fetch_assoc($result);
            $USER_ID = $row['userID'];

            $sql = "INSERT INTO login_history (USER_ID) VALUES ('$USER_ID');
                    INSERT INTO session_table (username, session_id) VALUES ('$username', '$session_id');
                    INSERT INTO token_table (token_value, user_id) VALUES ('$token_value', '$USER_ID');
                    INSERT INTO user_application (username, token_value, app1_access, app2_access) VALUES ('$username','$token_value',1,1)";


            if(mysqli_multi_query($con,$sql)){
                echo "Data Added";
            }
            else{
                echo "Error ". mysqli_error($con); 
            }
            }
            else{
                echo "Error Adding login time, Invalid user Id.";
            }

            mysqli_free_result($result);
            

            if($_GET['source']=='app1')
            {
                $AppName = 'Application1'; 
            }
            elseif($_GET['source']=='app2')
            {
                $AppName = 'Application2'; 
            }
            else
            {
                echo "Invalid source";
            }

            // Redirect
            header('Location: http://'.$AppName.'.com:8080/?token='.$token_value);

            exit;

} else {
    $errorMessage = 'Invalid username or password.';
}
} catch (PDOException $e) {
$errorMessage = 'Database error: ' . $e->getMessage();
}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Identity Provider</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    
    <h1 style="text-align:center;">Identity Provider</h1>
    <div class="container" style="background-color:#f1f1f1">
    <form method="post">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" id="username" name="username" required>
        <br>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" id="password" name="password" required>
        <br><br>
        <button type="submit">Login</button>
    </form>
    </div>

</body>
</html>



