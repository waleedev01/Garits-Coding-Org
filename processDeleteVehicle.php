<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
// Initialize the session
session_start();
require_once "config.php";
$username = $_SESSION['username'];
$role = $_SESSION['role'];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$registrationID = $conn->real_escape_string($_POST["InputRegID"]);

if(!empty($registrationID)   ){
    // Check the Database to see if Reegistration number already exists
$ID_check_query = "SELECT * FROM vehicle WHERE registration_number = '$registrationID' LIMIT 1";
$res_ID = mysqli_query($conn,$ID_check_query) or die(mysql_error());
$Reg = mysqli_fetch_assoc($res_ID);

if($Reg['registration_number'] == $registrationID){  
    $delete_query = "DELETE FROM Vehicle WHERE registration_number = '$registrationID' ";
    mysqli_query($conn,$delete_query);
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Vehicle record deleted')
    window.location.href='$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}


}
?>