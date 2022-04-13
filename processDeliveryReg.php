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
$today = date("Y-m-d");

//if delivery order has been delivered
if (isset($_POST['saveDelivery'])) {
    $item_id = $_POST['saveDelivery'];//get item data
    $query = "SELECT * from Stock where item_id = '$item_id'";//get current qty
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)){//save jobs information
        $currentQuantity = $row['quantity'];
        $delivered = $row['delivery'];
    }    
    $newQuantity = $currentQuantity+$delivered;
    $query = "UPDATE Stock set quantity = $newQuantity where item_id = '$item_id'";//update quantity
    $result = mysqli_query($conn, $query);
    $query = "UPDATE Stock set delivery = 0 where item_id    = '$item_id'";//update delivery
    $result = mysqli_query($conn, $query);


    $query = "UPDATE Stock_ordered set date_completed = '$today' where item_id = '$item_id'";//update order 
    $result = mysqli_query($conn, $query);

    $location="$role.php"; // If role is admin this will be admin.php, if receptionist this will be receptionist.php and more.

    
    echo "<script language='javascript'>
    alert('Delivery registered')
    window.location.href='$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}

