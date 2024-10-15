<!DOCTYPE html>
<html>
    <head>
        <title>Submit a Request</title>
    </head>
    <body>
        <h1>Submit a Request</h1>
        <!-- form for adding requests -->
        <form action='submission_action.php' method = 'post'>
            <!--  code to ensure DateOfJob is in future -->
            <?php echo('Date of Job:<input type="date" name="DateOfJob", min="' . date("Y-m-d") . '"><br>'); ?>
            Time out:<input type='time' name='TimeOut'><br>
            Time in:<input type='time' name='TimeIn'><br>
            Destination:<input type='text' name='Destination'><br>
            Postcode:<input type='text' name='Postcode' minlength='5' maxlength='8'><br>
            Required Capacity:<input type='number' name='RequiredCapacity' min='1'><br>
            Purpose:<input type='text' name='Purpose'><br>
            Driver Required?<input type='checkbox' name='DriverRequired'><br>
            <input type='submit' value='Submit Request'>
        </form>
    </body>
</html>