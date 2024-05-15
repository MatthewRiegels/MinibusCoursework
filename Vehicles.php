<!DOCTYPE html>
<html>
    <head>
        <title>Add Vehicles</title>
    </head>
    <body>
        <!-- form for adding vehicles -->
        <form action="vehicles_add.php" method = "post">
            Reg number:<input type="text" name="RegNumber"><br>
            Capacity:<input type="text" name="Capacity"><br>
            NotAvailableFrom:<input type="text" name="NotAvailableFrom"><br>
            <input type="submit" value="Add Vehicle">
        </form>

        <!-- show all vehicles -->
        <?php
        include_once('connection.php');
        // iterates over TblVehicles, printing out information from each record
        // effectively provides a summary of the entire table on the page
        $stmt = $conn->prepare("SELECT * FROM TblVehicles");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo($row["VehicleID"] . ': ' . $row["RegNumber"] . ', ' . $row['Capacity'] . ', ' . $row['NotAvailableFrom'] . '<br>');
        }
        ?>
    </body>
</html>