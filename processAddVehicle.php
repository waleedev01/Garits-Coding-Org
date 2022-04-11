<?php
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


// Initializing the variables in the text field and assinging them to variables 
$registrationID = $conn->real_escape_string($_POST["InputRegID"]);
$customerID = $conn->real_escape_string($_POST["CustomerID"]);
$make =  $conn->real_escape_string($_POST["EMake"]);
$engineSerial =  $conn->real_escape_string($_POST["EngineSerial"]);
$chasisNumber =  $conn->real_escape_string($_POST["ChasisNumber"]);
$model =  $conn->real_escape_string($_POST["Model"]);
$nextMOT =  $conn->real_escape_string($_POST["NextMOT"]);
$color =  $conn->real_escape_string($_POST["Color"]);
$nextAnnualService =  $conn->real_escape_string($_POST["NextAnnualService"]);
 
if($nextMOT== null )
    $nextMot='';
if($nextAnnualService== null )
    $nextAnnualService='';


// Check to see that no fields are left empty
if(!empty($registrationID) ||!empty($customerID) || !empty($make) || !empty($engineSerial) || !empty($chasisNumber) || !empty($model) || !empty($nextMOT) || !empty($color) || !empty($nextAnnualService) ){
    // Check the Database to see if Registration number already exists
$ID_check_query = "SELECT * FROM vehicle WHERE registration_number = '$registrationID' LIMIT 1";
$res_ID = mysqli_query($conn,$ID_check_query) or die(mysql_error());
$Reg = mysqli_fetch_assoc($res_ID);
}

    if($Reg['registration_number'] == $registrationID){
    echo "<script language='javascript'>
    alert('Registration number already exists ')
    window.location.href='addVehicle.php';
    </script>";
    die();
}
// If Registration number doesnt exist add the details to the databse
else {
    $query = "INSERT INTO Vehicle (registration_number,make,engine_serial,model,chassis_num,next_MoT_date,color,next_annual_service_date,customer_id) Values ('$registrationID','$make','$engineSerial','$model','$chasisNumber','$nextMOT','$color','$nextAnnualService','$customerID')";
    mysqli_query($conn,$query);
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Vehicle record Created')
    window.location.href='$location';
    </script>";
    } 
    echo "<meta http-equiv='refresh' content='0'>";

?>
