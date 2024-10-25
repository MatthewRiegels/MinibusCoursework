<?php
// Start the sesison and add details to it later on in the action page
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Login</title>
    </head>
    <body>
        <!-- form for entering credentials -->
        <form action='login_action.php' method = 'post'>
            Email:<input type='text' name='Email' maxlength='50' required><br>
            Password:<input type='password' name='Password' minlength='6' required><br>
            <input type='submit' value='Login'>
        </form>
    </body>
</html>