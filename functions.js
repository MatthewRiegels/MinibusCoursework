// This js function handles the onclick event to redirect to request_details.php and post the chosen request id and this page's url
// NB this function requires a html form on the page with these ids to work properly
function goToDetails($chosenID){
    document.getElementById('hiddenInput').value = $chosenID;
    document.getElementById('goToDetailsForm').submit();
}