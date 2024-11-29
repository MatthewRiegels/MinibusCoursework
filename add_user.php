<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add User</title>
        <link rel='stylesheet' href='styles.css'>
        <script src='functions.js'></script>
    </head>
    <body>
        <h1>Add User</h1>
        <form method='post' action='add_user_action.php'>
            Forename:<input type='text' name='Forename' maxlength='30' required><br>
            Surname:<input type='text' name='Surname' maxlength='30' required><br>
            Email:<input type='text' name='Email' minlength='7' maxlength='50' required><br>
            Tel Number:<input type='text' name='TelephoneNumber' minlength='11' maxlength='11'><br>
            <input type="radio" id="staff" name="Role" value="StaffMember">
            <label for="staff">Staff member</label><br>
            <input type="radio" id="driver" name="Role" value="Driver">
            <label for="driver">Driver</label><br>
            <input type="radio" id="admin" name="Role" value="Admin">
            <label for="admin">Admin</label><br>
            <input type='submit' value='Add user'>
        </form>
    </body>
</html>