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


$registrationID = $conn->real_escape_string($_POST["InputRegID"]);
$customerID = $conn->real_escape_string($_POST["CustomerID"]);
$make =  $conn->real_escape_string($_POST["EMake"]);
$engineSerial =  $conn->real_escape_string($_POST["EngineSerial"]);
$chasisNumber =  $conn->real_escape_string($_POST["ChasisNumber"]);
$model =  $conn->real_escape_string($_POST["Model"]);
$nextMOT =  $conn->real_escape_string($_POST["NextMOT"]);
$color =  $conn->real_escape_string($_POST["Color"]);
$nextAnnualService =  $conn->real_escape_string($_POST["NextAnnualService"]);
 
// Check to see that Registration isnt empty
if(!empty($registrationID)   ){
    // Check the Database to see if Reegistration number already exists
$ID_check_query = "SELECT * FROM vehicle WHERE registration_number = '$registrationID' LIMIT 1";
$res_ID = mysqli_query($conn,$ID_check_query) or die(mysql_error());
$Reg = mysqli_fetch_assoc($res_ID);

// If Registration number is in the Database
    if($Reg['registration_number'] == $registrationID){
        // And the customr ID field is not empty we update the customer coloumn with the value in the customer field
         if(!empty($customerID)){
             $customer_query = "UPDATE vehicle SET customer_id ='$customerID' WHERE registration_number = '$registrationID'";
             mysqli_query($conn,$customer_query);
         }
         // And the make field is not empty we update the make coloumn with the value in the make field
         if(!empty($make)){
            $make_query = "UPDATE vehicle SET make ='$make' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$make_query);
        }
        // And the engine serial field is not empty we update the engine serial coloumn with the value in the engineserial field
        if(!empty($engineSerial)){
            $engineSerial_query = "UPDATE vehicle SET engine_serial ='$engineSerial' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$engineSerial_query);
        }
        // And the chasis Number field is not empty we update the chasis Number coloumn with the value in the chasis Numberfield
        if(!empty($chasisNumber)){
            $chasisNumber_query = "UPDATE vehicle SET chassis_num ='$chasisNumber' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$chasisNumber_query);
        }
        // And the model field is not empty we update the model coloumn with the value in the model field
        if(!empty($model)){
            $model_query = "UPDATE vehicle SET model ='$model' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$model_query);
        }
        // And the next MOT field is not empty we update the next MOT coloumn with the value in the next MOT field
        if(!empty($nextMOT)){
            $nextMOT_query = "UPDATE vehicle SET next_MoT_date ='$nextMOT' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$nextMOT_query);
        }
        // And the color field is not empty we update the color coloumn with the value in the color field
        if(!empty($color )){
            $color_query = "UPDATE vehicle SET color ='$color' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$color_query);
        }
        // And the next  Annual Service field is not empty we update the next Annual Service coloumn with the value in the next Annual Service field
        if(!empty($nextAnnualService)){
            $nextAnnualService_query = "UPDATE vehicle SET next_annual_service_date ='$nextAnnualService' WHERE registration_number = '$registrationID'";
            mysqli_query($conn,$nextAnnualService_query);
        }
        $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
        echo "<script language='javascript'>
        alert('Vehicle Updated')
        window.location.href='$location';
        </script>";
        echo "<meta http-equiv='refresh' content='0'>";

    }
    else {
        echo "<script language='javascript'>
        alert('Registration number does not exist in the database')
        window.location.href='updateVehicle.php';
        </script>";
        die();
}
 
}
?>