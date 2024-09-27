<?php
include_once("connection.php");
array_map("htmlspecialchars", $_POST);

// conect to db and add userid, isrequestor, isdriver, isadmin, forename, surname to session variable
?>