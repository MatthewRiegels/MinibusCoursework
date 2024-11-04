<?php
session_start();
include_once('functions.php');
checkRole($_SESSION, 1, 0, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Submit a Request</title>
    </head>
    <body>
        <h1>Submit a Request</h1>
        <!-- form for adding requests -->
        <form action='submission_action.php' method = 'post'>
            <?php // code to ensure DateOfJob is in future
            echo("Date of Job:<input type='date' name='DateOfJob', min='" . date('Y-m-d') . "' required><br>"); ?>
            Time out:<input type='time' name='TimeOut' required><br>
            Time in:<input type='time' name='TimeIn' required><br>
            Destination:<input type='text' name='Destination' required><br>
            Postcode:<input type='text' name='Postcode' minlength='5' maxlength='8' required><br>
            Required Capacity:<input type='number' name='RequiredCapacity' min='1' required><br>
            Purpose:<input type='text' name='Purpose' required><br>
            Driver Required?<input type='checkbox' name='DriverRequired'><br>
            <input type='submit' value='Submit Request'>
        </form>
    </body>
</html>