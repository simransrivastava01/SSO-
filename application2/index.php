<?php

session_start();

if(isset($_GET['token']))
{
    header('Location: http://application2.com:8080/home2.php');
}
else
{
    echo '<html>
    <body style="text-align:center;">
        <h1>Application2</h1>
        <br>
        <a href="http://idp.account.com:8080/?source=app2"><button style="font-size:16px;">Login</button></a>
    </body>
    </html>';
}

?>









