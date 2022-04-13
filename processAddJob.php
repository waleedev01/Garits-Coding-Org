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

// Initializing the variables in the text field and assinging them to variables 
$customer_id = $conn->real_escape_string($_GET["customerID"]);
$job_type =  $conn->real_escape_string($_GET["jobType"]);
$status  = $conn->real_escape_string($_GET["Status"]);
$estimate_amount =  $conn->real_escape_string($_GET["estimateAmount"]);
$book_in_date =  $conn->real_escape_string($_GET["bookInDate"]);
$time_spent =  $conn->real_escape_string($_GET["timeSpent"]);
$registration_number =  $conn->real_escape_string($_GET["registrationID"]);
$username= null;
// Check to see that no fields are left empty
   
    $query = "INSERT INTO Job (job_type,status,estimate_amount,book_in_date,time_spent,customer_id,registration_number,username) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssdsdiss', $job_type, $status,$estimate_amount,$book_in_date,$time_spent,$customer_id,$registration_number,$username);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
    
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Job Created')
    window.location.href='../$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

?>