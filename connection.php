<?php
// this file is to set up the connection between the website and the database
// this will be included in any page that needs to query the database

// assign variables at the start for easy maintenance
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transport_coursework";

// use try/catch to ensure failed connection can be dealt with properly
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully<br>";// remove this line once testing is complete for aesthetic purposes
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage() . "<br>";
    }
?>