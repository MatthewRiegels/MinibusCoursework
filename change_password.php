<?php
// This is a script page for when a user changes their password (from account_details.php)

header('Location: account_details.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 0);

// Output form data for testing
// echo("NewPassword: " . $_POST["NewPassword"] . "<br>");
// echo("ConfirmPassword: " . $_POST["ConfirmPassword"] . "<br>");

// Validation
$valid = 'True';
if ($_POST['NewPassword'] != $_POST['ConfirmPassword']){ // Confirm password must match
    $valid = 'False';
}
if (strlen($_POST['NewPassword']) < 6){ // New password must be at least 6 characters
    $valid = 'False';
}
if ($valid == 'True'){
    // If validation passes, hash new password and update record on database
    htmlspecialchars($_POST['NewPassword']);
    $newPassword = password_hash($_POST['NewPassword'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare('UPDATE Tblusers SET Password = "' . $newPassword . '" WHERE UserID = "' . $_SESSION['UserID'] . '"');
    $stmt->execute();
    $stmt->closeCursor();
}

?>