<?php
// Start the sesison and add details to it later on in the action page
session_start();
?>

<!DOCTYPE html>
<!-- This page is entirely placeholders right now since having to log in to test anything will be inconvenient -->
<html>
    <head>
        <title>Minibus Coursework</title>
    </head>
    <body>
        <!-- form for entering credentials -->
        <form action="login_action.php" method = "post">
            Username:<input type="text" name="Username"><br>
            Password:<input type="password" name="Password"><br>
            <input type="submit" value="Login">
        </form>
    </body>
</html>