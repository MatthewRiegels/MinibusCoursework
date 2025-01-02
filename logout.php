<?php
// This is the scripting page for a user logging out

header('Location: login.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 0);

// get rid of session variables
session_unset();
session_destroy();
?>