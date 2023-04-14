<?php

session_start();

// if(isset($_GET['token']))
// {
//     $token_value = $_GET['token'];
//     //$_SESSION['token'] = $token_value;
// }

if(isset($_GET['token']))
{
    header('Location: http://application1.com:8080/home1.php');
}

else
{
    echo '<html>
    <body style="text-align:center;">
        <h1>Application1</h1>
        <br>
        <a href="http://idp.account.com:8080/?source=app1"><button style="font-size:16px;">Login</button></a>
    </body>
    </html>';
}

?>









