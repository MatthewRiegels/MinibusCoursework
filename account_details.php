<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Account Details</title>
        <link rel="stylesheet" href="styles.css">
        <script src='functions.js'></script>
    </head>
    <body>
        <?php
        echo('<h1>' . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Account Details</h1>");

        $stmt = $conn->prepare('SELECT * FROM TblUsers WHERE UserID = "' . $_SESSION['UserID'] . '"');
        $stmt->execute();
        $userArr = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        echo('<h2>Personal Details</h2>');
        echo('Forename: ' . $userArr['Forename'] . '<br>');
        echo('Surname: ' . $userArr['Surname'] . '<br>');
        echo('Email: ' . $userArr['Email'] . '<br>');
        echo('Tel: ' . $userArr['TelephoneNumber'] . '<br>');
        if ($userArr['IsDriver'] == 1){
            echo('Hours Worked: ' . $userArr['HoursWorked'] . '<br>');
        }
        ?>
        <h2>Change Password</h2>
        <form method='post' action='change_password.php'>
            Password:<input type='password' name='NewPassword'><br>
            Confirm Password:<input type='password' name='ConfirmPassword'><br>
            <input type='submit' value='Change password'>
        </form>
    </body>
</html>