<?php
// This function creates a list item out of a TblRequests record
// NB this function calls goToDetails, so that must also be included in the page if this function is used
function showRequest($requestData){
    echo(
        '<div class="list-item-container">' . 
        '<div class="bold-container">' . $requestData['DateOfJob'] . '</div>' . 
        '<div class="italics-container">' . $requestData['TimeOut'] . '-' . $requestData['TimeIn'] . '</div>' . 
        '<div class="plain-container">' . $requestData['Purpose'] . '</div>' . 
        '<button class="details-button" onclick=\'goToDetails("' . $requestData['RequestID'] . '")\'>--></button>' . 
        '</div>'
    );
}

// This function creates a list item out of a TblVehicles record (similar to above)
// NB this function calls goToDetails, so that must be included in the page if this function is to be used
function showVehicle($vehicleData){
    echo(
        '<div class="list-item-container">' . 
        '<div class="bold-container">' . $vehicleData['RegNumber'] . '</div>' . 
        '<div class="plain-container">Capacity ' . $vehicleData['Capacity'] . '</div>' . 
        '<div class="italics-container">Available until ' . $vehicleData['NotAvailableFrom'] . '</div>' . 
        '<button class="details-button" onclick=\'goToDetails("' . $vehicleData['VehicleID'] . '")\'>--></button>' . 
        '</div>'
    );
}

// This function creates a list item out of a TblUsers record FOR A DRIVER (similar to above)
// NB as above, goToDetails must be included in the page if this function is to be used
function showDriver($driverData){
    echo(
        '<div class="list-item-container">' . 
        '<div class="bold-container">' . $driverData['Forename'] . ' ' . $driverData['Surname'] . '</div>' . 
        '<div class="italics-container">' . $driverData['TelephoneNumber'] . '</div>' . 
        '<div class="plain-container">(' . $driverData['HoursWorked'] . ' unpaid hours)</div>' . 
        '<button class="details-button" onclick=\'goToDetails("' . $driverData['UserID'] . '")\'>--></button>' . 
        '</div>'
    );
}

// This function creates a list item out of a TblUsers record FOR A STAFF MEMBER (similar to above)
// NB as above, goToDetails must be included in the page if this function is to be used
function showStaffMember($staffMemberData){
    echo(
        '<div class="list-item-container">' . 
        '<div class="bold-container">' . $staffMemberData['Forename'] . ' ' . $staffMemberData['Surname'] . '</div>' . 
        '<div class="italics-container">' . $staffMemberData['Email'] . '</div>' . 
        '<button class="details-button" onclick=\'goToDetails("' . $staffMemberData['UserID'] . '")\'>--></button>' . 
        '</div>'
    );
}

// This function is an alternative to showRequest that shows the number of drivers that have declined the request
// goToDetails is required, and connection.php must be included
function showRequestAlternative($requestData, $conn){
    $numDrivers = countDrivers($conn);// Get total number of drivers
    $numDeclined = countDeclinedDrivers($requestData['RequestID'], $conn);// Get number of drivers that have declined this request

    echo(
        '<div class="list-item-container">' . 
        '<div class="bold-container">' . $requestData['DateOfJob'] . '</div>' . 
        '<div class="plain-container">' . $requestData['Purpose'] . '</div>' . 
        '<div class="italics-container">(' . $numDeclined . '/' . $numDrivers . ' declined)</div>' . 
        '<button class="details-button" onclick=\'goToDetails("' . $requestData['RequestID'] . '")\'>--></button>' . 
        '</div>'
    );
}

// This function is another alternative to showRequest with a different style that indicates that the request has been declined by all drivers
// goToDetails is required
function showRequestDeclined($requestData){
    echo(
        '<div class="list-item-container-declined">' . 
            '<div class="bold-container">' . $requestData['DateOfJob'] . '</div>' . 
            '<div class="plain-container">' . $requestData['Purpose'] . '</div>' . 
            '<div class="italics-container"><b>Declined!</b></div>' . 
            '<button class="details-button" onclick=\'goToDetails("' . $requestData['RequestID'] . '")\'>--></button>' . 
        '</div>'
    );
}

// This function checks if the user is logged in and if they have the right roles to access a page
// This is run at the top of every page
function checkRole($sessionData, $isRequestorReq, $isDriverReq, $isAdminReq){
    $allowed = 'True';
    if (empty($sessionData)){
        // The user should be recirected if they are not logged in (no session data --> no user logged in)
        $allowed = 'False';
    }
    elseif ($sessionData['IsRequestor'] < $isRequestorReq || $sessionData['IsDriver'] < $isDriverReq || $sessionData['IsAdmin'] < $isAdminReq){
        // The user should be redirected if they do not have the required role for the page
        $allowed = 'False';
    }
    if ($allowed == 'False'){
        // These two lines should redirect the user to the login page when the function is run (if the user is not allowed)
        header('Location: login.php');
        die('Access denied: incorrect user roles');
    }
}

// This function creates the hidden form for the js function goToDetails
// the values are autofilled and the form is submitted by the js function
function hiddenDetailForm($actionPage, $redirect_url){
    echo('
        <form id="goToDetailsForm" method="post" action="' . $actionPage . '">
            <input type="hidden" name="chosenID" id="hiddenInput">
            <input type="hidden" name="redirectURL" value="' . $redirect_url . '">
        </form>
    ');
}

// This function produces the sidebar on every page
// It will write out the links based on the current user's role
function loadSidebar($sessionData){
    echo('
        <div id="sidebar">
            <header>
                <div width="100%" style="padding: 10%">
                    <img src="oundle_enterprises_logo_white.png", width="100%">
                </div>
            </header>
            <ul class="nav">
    ');
    if (!empty($sessionData)){
        if ($sessionData["IsRequestor"] == 1){
            echo('
                <li>
                    <a href="submission.php">
                        Submit a request
                    </a>
                </li>
                <li>
                    <a href="active_requests.php">
                        Your requests
                    </a>
                </li>
            ');
        }
        elseif ($sessionData["IsDriver"] == 1){
            echo('
                <li>
                    <a href="pending_requests.php">
                        View available jobs
                    </a>
                </li>
                <li>
                    <a href="accepted_jobs.php">
                        Your accepted jobs
                    </a>
                </li>
                <li>
                    <a href="declined_jobs.php">
                        Your declined jobs
                    </a>
                </li>
            ');
        }
        elseif ($sessionData["IsAdmin"] == 1){
            echo('   
                <li>
                    <a href="pending_requests_admin.php">
                        Pending jobs
                    </a>
                </li>
                <li>
                    <a href="active_jobs.php">
                        Active jobs
                    </a>
                </li>
                <li>
                    <a href="job_history.php">
                        Job history
                    </a>
                </li>
                <li>
                    <a href="vehicle_overview.php">
                        Vehicle overview
                    </a>
                </li>
                <li>
                    <a href="driver_profiles.php">
                        Driver profiles
                    </a>
                </li>
                <li>
                    <a href="staff_profiles.php">
                        Staff profiles
                    </a>
                </li>
                <li>
                    <a href="add_user.php">
                        Add new user
                    </a>
                </li>
            ');
        }
    }
        echo('
            </ul>
        </div>
        ');
}

// This function is included in every page and loads in the navbar at the top
function loadNavbar($sessionData){
    echo('
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-right">
    ');
    if (!empty($sessionData)){
        echo('
                    <li>
                        <a href="account_details.php">' . $sessionData["Forename"] . ' ' . $sessionData["Surname"] . '</a>
                    </li>
                    <li>
                        <a href="logout.php">Log out</a>
                    </li>
        ');
    }
    echo('
                </ul>
            </div>
        </nav>
    ');
}

// This function returns the total number of drivers on the system
function countDrivers($conn){
    $stmt = $conn->prepare('SELECT UserID FROM TblUsers
                            WHERE IsDriver = 1');
    $stmt->execute();
    $totalDrivers = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $totalDrivers = $totalDrivers + 1;
    }
    $stmt->closeCursor();
    return $totalDrivers;
}

// This function returns the number of drivers that have declined a particluar request
function countDeclinedDrivers($requestID, $conn){
    $stmt = $conn->prepare('SELECT DriverID FROM TblDeclinedDrivers
                            WHERE RequestID = "' . $requestID . '"');
    $stmt->execute();
    $totalDeclinedDrivers = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $totalDeclinedDrivers = $totalDeclinedDrivers + 1;
    }
    $stmt->closeCursor();
    return $totalDeclinedDrivers;
}
?>