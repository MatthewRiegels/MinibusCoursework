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
?>