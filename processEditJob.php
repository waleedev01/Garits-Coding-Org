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


$pick_job_id = $conn->real_escape_string($_POST["job_id"]);
$newStatus = $conn->real_escape_string($_POST["updateStatus"]);
$stockId = $conn->real_escape_string($_POST["addStock"]);
$taskId = $conn->real_escape_string($_POST["addTask"]);
$timeSpent = $conn->real_escape_string($_POST["timeSpent"]);

if($taskId!=null){
    $query = "UPDATE Task_Used SET job_id = '$pick_job_id', task_id = '$taskId'";
    $result = mysqli_query($conn, $query);
}

if($stockId!=null){
    $query = "INSERT INTO Stock_used (job_id,item_id,date_used) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $date = date("Y-m-d");
    $stmt->bind_param('iis', $pick_job_id, $stockId,$date);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
    if ($row > 0) { 
        echo "data inserted";
    } else {
        "error";
    }
    $query_stock_quantity = "SELECT quantity FROM Stock WHERE item_id = '$stockId'";
    $res_stock= mysqli_query($conn,$query_stock_quantity) or die(mysql_error());
    while ($row = mysqli_fetch_assoc($res_stock)) 
            $quantity = $row['quantity'];
    $newQuantity = $quantity-1;
    echo $newQuantity;
    $query = "UPDATE Stock SET quantity = '$newQuantity' where item_id = '$stockId'";
    $result = mysqli_query($conn, $query);
}

if($newStatus != null){
    $query = "UPDATE Job SET status = '$newStatus' where job_id ='$pick_job_id'";
    $result = mysqli_query($conn, $query);
}

if($timeSpent != null){
    $query = "UPDATE Job SET time_spent = '$timeSpent' where job_id ='$pick_job_id'";
    $result = mysqli_query($conn, $query);
    ECHO $result;
}

if($taskId!=null){
    $today = date("Y-m-d");
    $query = "INSERT INTO Task_performed (job_id,task_id,date_performed) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $pick_job_id, $taskId,$today);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
    if ($row > 0) { 
        echo "data inserted";
    } else {
        "error";
    }
}

$location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
header("location: $location");



?>