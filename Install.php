<?php
// this code creates empty versions of every table the system uses
// this code is not meant to be run regularly; only once when implemented.

include_once("connection.php");

// TblVehicles
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblVehicles;
CREATE TABLE TblVehicles (
    VehicleID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    RegNumber VARCHAR(7) NOT NULL,
    Capacity INT(2) UNSIGNED NOT NULL,
    NotAvailableFrom DATE
);");
$stmt->execute();
$stmt->closeCursor();

// TblUsers
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblUsers;
CREATE TABLE TblUsers (
    UserID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Password VARCHAR(60) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    TelephoneNumber Varchar(11) NOT NULL,
    Forename VARCHAR(30) NOT NULL,
    Surname VARCHAR(30) NOT NULL,
    IsDriver TINYINT(1) NOT NULL,
    IsAdmin TINYINT(1) NOT NULL,
    IsRequestor TINYINT(1) NOT NULL,
    HoursWorked INT(3) UNSIGNED
);");
$stmt->execute();
$stmt->closeCursor();

// TblRequests
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblRequests;
CREATE TABLE TblRequests (
    RequestID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DateOfJob DATE NOT NULL,
    TimeOut TIME NOT NULL,
    TimeIn TIME NOT NULL,
    Destination VARCHAR(20) NOT NULL,
    Postcode VARCHAR(8) NOT NULL,
    Purpose VARCHAR(20) NOT NULL,
    ReqCapacity INT(2) NOT NULL,
    DriverID INT(6),
    VehicleID INT(6),
    RequestorID INT(6)
);");
$stmt->execute();
$stmt->closeCursor();