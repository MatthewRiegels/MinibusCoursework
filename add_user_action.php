<?php
// This is a scripting page for Kristian adding a new user to the system (from add_user.php)

header('Location: add_user.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Role management
$isAdmin = 0;
$isRequestor = 0;
$isDriver = 0;

switch ($_POST['Role']){
    case 'Admin':
        $isAdmin = 1;
        $hoursWorked = null;
        break;
    case 'StaffMember':
        $isRequestor = 1;
        $hoursWorked = null;
        break;
    case 'Driver':
        $isDriver = 1;
        $hoursWorked = 0;
        break;
}

// Test outputs
// echo('Forename: ' . $_POST['Forename'] . '<br>');
// echo('Surname: ' . $_POST['Surname'] . '<br>');
// echo('Email: ' . $_POST['Email'] . '<br>');
// echo('TelephoneNumber: ' . $_POST['TelephoneNumber'] . '<br>');
// echo('Password: ' . $_POST['Password'] . '<br>');
// echo('$isAdmin: ' . $isAdmin . '<br>');
// echo('$isRequestor: ' . $isRequestor . '<br>');
// echo('$isDriver: ' . $isDriver . '<br>');

// Password hashing
htmlspecialchars($_POST['Password']);
$passwordHash = password_hash($_POST['Password'], PASSWORD_BCRYPT);

// Checking for duplicate email
$stmt = $conn->prepare('SELECT * FROM TblUsers WHERE Email = "' . $_POST['Email'] . '"');
$stmt->execute();
$arr = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
if (empty($arr)){
    // Inserting record into TblUsers
    $stmt = $conn->prepare('INSERT INTO TblUsers (Password, Email, TelephoneNumber, Forename, Surname, IsDriver, IsAdmin, IsRequestor, HoursWorked)
    VALUES (:Password, :Email, :TelephoneNumber, :Forename, :Surname, :IsDriver, :IsAdmin, :IsRequestor, :HoursWorked)');
    $stmt->bindParam(':Password', $passwordHash);
    $stmt->bindParam(':Email', $_POST['Email']);
    $stmt->bindParam(':TelephoneNumber', $_POST['TelephoneNumber']);
    $stmt->bindParam(':Forename', $_POST['Forename']);
    $stmt->bindParam(':Surname', $_POST['Surname']);
    $stmt->bindParam(':IsDriver', $isDriver);
    $stmt->bindParam(':IsAdmin', $isAdmin);
    $stmt->bindParam(':IsRequestor', $isRequestor);
    $stmt->bindParam(':HoursWorked', $hoursWorked);
    $stmt->execute();
}
?>