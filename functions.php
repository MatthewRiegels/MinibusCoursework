<?php
// This function creates a list item out of a TblRequests record
// NB this function calls goToDetails, so that must also be included in the page if this function is used
function showRequest($requestData){
    echo(
        '<div class="list-item-container">' . 
        '<div class="date-container">' . $requestData['DateOfJob'] . '</div>' . 
        '<div class="time-container">' . $requestData['TimeOut'] . '-' . $requestData['TimeIn'] . '</div>' . 
        '<div class="purpose-container">' . $requestData['Purpose'] . '</div>' . 
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
        // The user should be redirected if they fo not have the required role for the page
        $allowed = 'False';
    }
    if ($allowed == 'False'){
        // These two lines should redirect the user to the login page when the function is run (if the user is not allowed)
        header('Location: login.php');
        die('Access denied: incorrect user roles');
    }
}
?>