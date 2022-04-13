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


$itemID = $conn->real_escape_string($_POST["InputID"]);
$partName = $conn->real_escape_string($_POST["PartName"]);
$quantity =  $conn->real_escape_string($_POST["quantity"]);
$yearS =  $conn->real_escape_string($_POST["year"]);
$price =  $conn->real_escape_string($_POST["price"]);
$manufacturerName =  $conn->real_escape_string($_POST["manufacturerName"]);
$vehicle_type =  $conn->real_escape_string($_POST["vehicleType"]);
$threshold_level =  $conn->real_escape_string($_POST["thresholdLevel"]);


// changed variable name of year in the database to year_made(change in orignal code to work)
// Check to see that no fields are left empty
 if(!empty($itemID) ){

    $ID_check_query = "SELECT * FROM stock WHERE item_id = '$itemID' LIMIT 1";
    $item_ID = mysqli_query($conn,$ID_check_query) or die(mysql_error());
    $Reg = mysqli_fetch_assoc($item_ID);


if($Reg['item_id'] == $itemID){
     if(!empty($partName)){
         $partQuery = "UPDATE Stock SET part_name = '$partName' WHERE item_id = '$itemID' LIMIT 1 ";
         mysqli_query($conn,$partQuery);
     }
     if(!empty($quantity)){
        try {
            // First of all, let's begin a transaction
            $conn->begin_transaction();
            
            // A set of queries; if one fails, an exception should be thrown
            $conn->query("SELECT quantity FROM Stock WHERE item_id = '$itemID'");
            $conn->query("UPDATE Stock SET quantity = '$quantity' where item_id = '$itemID'");
            
            // If we arrive here, it means that no exception was thrown
            // i.e. no query has failed, and we can commit the transaction
            $conn->commit();
        } catch (\Throwable $e) {
            // An exception has been thrown
            // We must rollback the transaction
            $conn->rollback();
            throw $e; // but the error must be handled anyway
        }
    }
    if(!empty($yearS)){
        $yearSQuery = " START TRANSACTION;
        SELECT quantity FROM Stock WHERE item_id = '$itemID';
        UPDATE Stock SET quantity = 1000 WHERE item_id = '$itemID';
        COMMIT";
      
        mysqli_query($conn,$yearSQuery);
    }
    if(!empty($price)){
        $priceQuery = "UPDATE Stock SET price = '$price' WHERE item_id = '$itemID' LIMIT 1 ";
        mysqli_query($conn,$priceQuery);
       
    }
    if(!empty($manufacturerName)){
        $manufacturerNameQuery = "UPDATE Stock SET manufacturer_name = '$manufacturerName' WHERE item_id = '$itemID' LIMIT 1 ";
        mysqli_query($conn,$manufacturerNameQuery);
    }
    if(!empty($vehicle_type)){
        $vehicle_typeQuery = "UPDATE Stock SET vehicle_type = '$vehicle_type' WHERE item_id = '$itemID' LIMIT 1 ";
        mysqli_query($conn,$vehicle_typeQuery);
    }
    if(!empty($threshold_level)){
        $threshold_levelQuery = "UPDATE Stock SET threshold_level = '$threshold_level' WHERE item_id = '$itemID' LIMIT 1 ";
        mysqli_query($conn,$threshold_levelQuery);
    }
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Stock item Updated')
    window.location.href='$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}
else{
    echo "Item doesnt Exist";
    die();
}
    }
    
    else{
        echo "Item field invalid ";
    die();
    }

    ?>