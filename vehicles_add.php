<?php
//header('Location: vehicles.php'); // for testing comment this line out

include_once("connection.php");

array_map("htmlspecialchars", $_POST);

// print these out onto the page for the sake of debugging
// these lines are effectively useless unless the header is commented out so they wont affect user experience
echo("RegNumber: " . $_POST["RegNumber"] . "<br>");
echo("Capacity: " . $_POST["Capacity"] . "<br>");
echo("NotAvailableFrom: " . $_POST["NotAvailableFrom"] . "<br>");

// Convert NotAvailableFrom from string to DateTime object
$NotAvailableFrom_converted = DateTime::createFromFormat('Y-m-d', $_POST["NotAvailableFrom"]);

// validation for each data entry
// since every item must be correcly entered, $valid starts true and become false if anything is wrong
$valid = true;
// validation for RegNumber
// checks that: the string is 7 characters long
//              the first two characters are letters
//              the next two characters are numbers
//              the final three characters are letters
// if any of these are not true then the entry will be conisdered invalid
if (!(
    strlen($_POST["RegNumber"]) == 7 and
    ctype_alpha(substr($_POST["RegNumber"], 0, 2)) and
    is_numeric(substr($_POST["RegNumber"], 2, 2)) and
    ctype_alpha(substr($_POST["RegNumber"], 4, 3))
    ))
{
    $valid = false;
    echo("RegNumber is invalid<br>");// this is irrelevant unless header line is commented out
}
// validation for NotAvailableFrom
// date is invalid if it is not in the future
$current_date = new DateTime();
if ($NotAvailableFrom_converted <= $current_date)
{
    $valid = false;
    echo("NotAvailableFrom is invalid<br>");// this is irrelevant unless header line is commented out
}

// if entry is valid, insert a record with the appropraite information into TblVehicles
if ($valid == true)
{
    $stmt = $conn->prepare("INSERT INTO TblVehicles (VehicleID,RegNumber,Capacity,NotAvailableFrom)VALUES (null,:RegNumber,:Capacity,:NotAvailableFrom)");
    $stmt->bindParam(':RegNumber', $_POST["RegNumber"]);
    $stmt->bindParam(':Capacity', $_POST["Capacity"]);
    $stmt->bindParam(':NotAvailableFrom', $_POST["NotAvailableFrom"]);
    $stmt->execute();
    $conn=null;
}