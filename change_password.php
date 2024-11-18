<?php
header('Location: account_details.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 0);

$valid = 'True';
if ($_POST['NewPassword'] != $_POST['ConfirmPassword']){
    $valid = 'False';
}
if (strlen($_POST['NewPassword']) < 6){
    $valid = 'False';
}

if ($valid == 'True'){
    htmlspecialchars($_POST['NewPassword']);
    $newPassword = password_hash($_POST['NewPassword'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare('UPDATE Tblusers SET Password = "' . $newPassword . '" WHERE UserID = "' . $_SESSION['UserID'] . '"');
    $stmt->execute();
    $stmt->closeCursor();
}

?>