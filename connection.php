<?php
// this file is to set up the connection between the website and the database
// this will be included in any page that needs to query the database (virtually all of them)

// assign variables at the start for easy maintenance
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MinibusCoursework";

// use try/catch to ensure failed connection can be dealt with properly
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully<br>"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage() . "<br>";
    }
?>