//////////////////////////////////////////
// REPORTING
//////////////////////////////////////////

// Signout all users
function signout() {
    if (window.confirm("Are you sure you want to sign everyone out? 2 hours will be logged for each volunteer.")) {
        window.location.href = "/pages/autosignout.php";
    } else {
        return false;
    }
}
from Jeremiah Weeden - Wright to everyone: 11: 28 AM
// Resets the dashboard
function resetDashboard() {
    document.getElementsByName("vol_name")[0].options[0].selected = "selected";
    document.getElementsByName("task")[0].options[0].selected = "selected";
    document.getElementsByName("location")[0].options[0].selected = "selected";
    document.getElementsByName("endtime")[0].value = "";
    document.getElementsByName("starttime")[0].value = "";
}