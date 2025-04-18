<?php
// This is the script page for logging a user in (from login.php)

header('Location: login.php');
include_once('connection.php');
session_start();

// Display all form data for testing
echo('FormEmail: ' . $_POST['FormEmail'] . '<br>');
echo('FormPassword: ' . $_POST['FormPassword'] . '<br>');

// Fetch password from TblUsers with email from form
$stmt = $conn->prepare('SELECT Password FROM TblUsers WHERE Email = "' . $_POST['FormEmail'] . '"');
$stmt->execute();
$arr = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

// Check if user email exists on database
$user_found = 'True';
if (empty($arr)){// this means that there is no user with that email
    echo('no user found with email address "' . $_POST['FormEmail'] . '"<br>');
    $user_found = 'False';
}
else{
    echo('TblUsers Password: ' . $arr['Password'] . '<br>');// displays password hash stored on TblUsers
}

// Check if passwords match and log in if all correct
if ($user_found == 'True'){
    if (password_verify($_POST['FormPassword'], $arr['Password'])){// password from TblUsers = password from form --> credentials correct
        echo('Passwords match - access granted<br>');
        // Query TblUsers for details and add to session
        $stmt = $conn->prepare('SELECT * FROM TblUsers WHERE Password = "' . $arr['Password'] . '"');
        $stmt->execute();
        $arr2 = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $_SESSION['UserID'] = $arr2['UserID'];
        $_SESSION['Email'] = $arr2['Email'];
        $_SESSION['TelephoneNumber'] = $arr2['TelephoneNumber'];
        $_SESSION['Forename'] = $arr2['Forename'];
        $_SESSION['Surname'] = $arr2['Surname'];
        $_SESSION['IsDriver'] = $arr2['IsDriver'];
        $_SESSION['IsAdmin'] = $arr2['IsAdmin'];
        $_SESSION['IsRequestor'] = $arr2['IsRequestor'];
        $_SESSION['HoursWorked'] = $arr2['HoursWorked'];

        // Display session data for testing
        echo('Displaying session data:<br>');
        echo('UserID: ' . $_SESSION['UserID'] . '<br>');
        echo('Email: ' . $_SESSION['Email'] . '<br>');
        echo('TelephoneNumber: ' . $_SESSION['TelephoneNumber'] . '<br>');
        echo('Forename: ' . $_SESSION['Forename'] . '<br>');
        echo('Surname: ' . $_SESSION['Surname'] . '<br>');
        echo('IsDriver: ' . $_SESSION['IsDriver'] . '<br>');
        echo('IsAdmin: ' . $_SESSION['IsAdmin'] . '<br>');
        echo('IsRequestor: ' . $_SESSION['IsRequestor'] . '<br>');
        echo('HoursWorked: ' . $_SESSION['HoursWorked'] . '<br');

        // Redirect management
        if ($_SESSION["IsRequestor"] == 1){
            header('Location: active_requests.php');
        }
        elseif ($_SESSION["IsDriver"] == 1){
            header('Location: pending_requests.php');
        }
        elseif ($_SESSION["IsAdmin"] == 1){
            header('Location: pending_requests_admin.php');
        }
    }
    else{
        echo('Incorrect password<br>');
    }
}
?>