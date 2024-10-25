<?php
//header('Location: submission.php');// for testing comment this line out
include_once('connection.php');
session_start();

// Display all form data for testing
echo('Email: ' . $_POST['Email'] . '<br>');
echo('Password: ' . $_POST['Password'] . '<br>');
    
// Validation
$valid = 'True';
if (empty($_POST['Email']) || empty($_POST['Password'])){
    $valid = 'False';
}

// Display valid for testing
echo('<br>');
echo('Valid: ' . $valid . '<br>');

if ($valid == 'True'){
    // Check if password is correct (no hashing used at this point in the implementation - will come back later)
    $stmt = $conn->prepare('SELECT Password FROM TblUsers WHERE Email = "' . $_POST['Email'] . '"');
    $stmt->execute();

    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($arr)){
        echo('empty');// this means that there is no user with that email
    }
    else{
        echo('Password: ' . $arr['Password'] . '<br>');// displays password stored on tblUsers - obviously this is just for testing
    }

    if ($arr['Password'] == $_POST['Password']){
        echo('Passwords match - access granted');
        // query for user details and add to $_SESSION
    }
}
?>