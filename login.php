<?php
include_once('connection.php');
include_once('functions.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Login</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div id="viewport">
            <!-- Sidebar -->
            <?php loadSidebar($_SESSION); ?>
            <!-- Content -->
            <div id="content">
                <!-- Navbar -->
                <?php loadNavbar($_SESSION); ?>
                <!-- Stuff on the page -->
                <div class="container-fluid">
                    <!-- form for entering credentials -->
                    <form action='login_action.php' method = 'post'>
                        Email:<input type='text' name='FormEmail' maxlength='50' required><br>
                        Password:<input type='password' name='FormPassword' minlength='6' required><br>
                        <input type='submit' value='Login'>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>