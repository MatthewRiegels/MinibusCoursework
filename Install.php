<?php
// This code creates empty versions of every table the system uses
// This code is not meant to be run regularly; only once when implemented.

header('Location: logout.php');
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
    Password VARCHAR(255) NOT NULL,
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

// TblDeclinedDrivers
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblDeclinedDrivers;
CREATE TABLE TblDeclinedDrivers (
    DriverID INT(4) UNSIGNED NOT NULL,
    RequestID INT(4) UNSIGNED NOT NULL,
    PRIMARY KEY (DriverID, RequestID)
);");
$stmt->execute();
$stmt->closeCursor();

// Adding test data to the database

// TblVehicles
$stmt = $conn->prepare("INSERT INTO TblVehicles (RegNumber, Capacity, NotAvailableFrom) VALUES
('BD15SMR', 10, '2025-11-04'),
('GF24WSN', 18, '2026-06-11')
");
$stmt->execute();
$stmt->closeCursor();

// TblUsers
$stmt = $conn->prepare("INSERT INTO TblUsers (Password, Email, TelephoneNumber, Forename, Surname, IsDriver, IsAdmin, IsRequestor, HoursWorked) VALUES
('" . password_hash('123456', PASSWORD_BCRYPT) . "', 'smith.j@oundleschool.org.uk', '07305712268', 'John', 'Smith', 0, 0, 1, NULL),
('" . password_hash('ABCDEF', PASSWORD_BCRYPT) . "', 'ferret.ro@oundleschool.org.uk', '07305724379', 'Ronald', 'Ferret', 1, 0, 0, 3),
('" . password_hash('P455W0RD', PASSWORD_BCRYPT) . "', 'doe.j@oundleschool.org.uk', '07303836152', 'Jane', 'Doe', 0, 0, 1, NULL),
('" . password_hash('4DM1NPWD', PASSWORD_BCRYPT) . "', 'admin@oundleschool.org.uk', '07538946537', 'Kristian', 'Fewster', 0, 1, 0, NULL),
('" . password_hash('K4CH0W', PASSWORD_BCRYPT) . "', 'bolt.b@oundleschool.org.uk', '07305723845', 'Billy', 'Bolt', 1, 0, 0, 0)
");
$stmt->execute();
$stmt->closeCursor();

// TblRequests
$stmt = $conn->prepare("INSERT INTO TblRequests (DateOfJob, TimeOut, TimeIn, Destination, Postcode, Purpose, ReqCapacity, DriverID, VehicleID, RequestorID) VALUES
('2025-05-17', '10:30', '12:40', 'Uppingham', 'LE159SE', 'Netball', 7, 2, NULL, 1),
('2025-06-03', '12:30', '15:50', 'Old Bailey', 'EC4M 7AN', 'Quad law trip', 10, 1, NULL, 1),
('2025-02-07', '18:00', '22:00', 'Corby Cinema', 'NN171QG', 'House cinema trip', 14, NULL, 1, 1),
('2025-05-08', '13:30', '17:00', 'Henley', 'RG9 3DB', 'Rowing regatta', 12, 1, 1, 1),
('2025-04-10', '14:00', '16:00', 'Bedford modern', 'MK41 7NT', 'Fives away fixture', 5, 2, NULL, 3),
('2025-04-19', '12:00', '17:00', 'Stowe', 'MK185EH', 'Cricket away fixture', 19, 2, 1, 3),
('2022-12-01', '09:00', '13:00', 'Oxford Street', 'W1C 2AU', 'Architecture trip', 8, 2, 1, 3),
('2023-04-13', '07:30', '22:00', 'Edinburgh castle', 'EH1 2NG', 'History trip', 18, 3, 1, 3),
('2024-09-23', '13:30', '16:30', 'Uppingham', 'LE15 9SE', 'Rugby away fixture', 15, 5, 1, 1)
");
$stmt->execute();
$stmt->closeCursor();
?>