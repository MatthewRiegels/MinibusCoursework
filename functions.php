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
?>