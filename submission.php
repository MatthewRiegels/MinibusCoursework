<!DOCTYPE html>
<html>
    <head>
        <title>Submit a Request</title>
    </head>
    <body>
        <h1>Submit a Request</h1>
        <!-- form for adding requests -->
        <form action="submission_add.php" method = "post">
            Date of Job:<input type="date" name="DateOfJob"><br>
            Time out:<input type="time" name="TimeOut"><br>
            Time in:<input type="time" name="TimeIn"><br>
            Destination:<input type="text" name="Destination"><br>
            Postcode:<input type="text" name="Postcode"><br>
            Required Capacity:<input type="number" name="RequiredCapacity"><br>
            Purpose:<input type="text" name="Purpose"><br>
            Driver Required?<input type="checkbox" name="DriverRequired"><br>
            <input type="submit" value="Submit Request">
        </form>
    </body>