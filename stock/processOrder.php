<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
// Initialize the session
session_start();
require_once "../config.php";
$username = $_SESSION['username'];
$role = $_SESSION['role'];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
$today = date("Y-m-d");

//if delivery order has been requested
if (isset($_POST['CreateOrder'])) {
    $item_id = $_POST['CreateOrder'];//get item data
    $orderQuantity = $_POST['orderQuantity'];
    $supplierid = 1;
    $query = "INSERT INTO Stock_ordered (item_id,supplier_id,date_ordered,quantity) VALUES (?,?,?,?)";//create order record in the db
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iisi', $item_id, $supplierid,$today,$orderQuantity);

    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;

    $query = "UPDATE Stock SET delivery = '$orderQuantity' where item_id = '$item_id'";//update the delivery quantity
    $result2= mysqli_query($conn, $query);
 
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Stock Order Created')
    window.location.href='../$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}

