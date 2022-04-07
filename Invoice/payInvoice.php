<?php
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

if (isset($_POST['pay'])) {
    $job_id = $_POST['pay'];
}
$today = date("Y/m/d");
$query3 = "UPDATE Invoice SET is_paid = '1', date_paid = '$today' where job_id = '$job_id'";
$result3 = mysqli_query($conn, $query3);
echo "<script type='text/javascript'>alert('Payment Recorded');</script>";
$location="/invoice/produceInvoice.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
header("location: $location");
?>