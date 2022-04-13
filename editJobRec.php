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
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<head>
<style>
        body{text-align: center; }
</style>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <meta charset="UTF-8">

<?php
    $query = "SELECT task_id,description FROM Task";
    $resultTasks = $conn->query($query);

    $query = "SELECT * FROM Job";
    $resultJobs = $conn->query($query);

    $query = "SELECT item_id,part_name FROM Stock";
    $resultParts = $conn->query($query);
?>
<form action = '' method = 'post'><!-- Form for editing jobs with all columns -->
<div class="form-group">

<label for="addJob">Choose job</label>
    <select name="addJob"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultJobs->fetch_assoc()) {
      echo "<option value=$row[job_id]>$row[job_id] $row[job_type] $row[status]</option>";
    } 
    ?>
    </select>
</div>

  <div class="form-group">
    <label for="timeSpent">Time Spent</label>
    <input type="number" class="form-control" name="timeSpent" placeholder="Enter time spent in job">
  </div>
  <div class="form-group">
    <label for="updateStatus">Update Status</label>
    <select name="updateStatus"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
      <option value='pending'>pending</option>
      <option value='progress'>progress</option>
      <option value='completed'>completed</option>
      </select>
  </div>
  <div class="form-group">
    <label for="addStock">Add Part</label>
    <select name="addStock"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultParts->fetch_assoc()) {
      echo "<option value=$row[item_id]>$row[part_name]</option>";
    } 
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="addTask">Add Task</label>
    <select name="addTask"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultTasks->fetch_assoc()) {
      echo "<option value=$row[task_id]>$row[description]</option>";
    } 
    ?>
    </select>
  </div>
  <button type="submit" name="createJob" class="btn btn-primary">Submit</button>
</form>

<?php

//if form has been submitted
if(isset($_POST['createJob'])){
    $pick_job_id = $conn->real_escape_string($_POST["addJob"]);//get values
    $newStatus = $conn->real_escape_string($_POST["updateStatus"]);
    $stockId = $conn->real_escape_string($_POST["addStock"]);
    $taskId = $conn->real_escape_string($_POST["addTask"]);
    $timeSpent = $conn->real_escape_string($_POST["timeSpent"]);

    //update columns that has been inputted
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
        try {
            // First of all, let's begin a transaction
            $conn->begin_transaction();
            
            // A set of queries; if one fails, an exception should be thrown
            $conn->query("SELECT quantity FROM Stock WHERE item_id = '$stockId'");
            $conn->query("UPDATE Stock SET quantity = '$newQuantity' where item_id = '$stockId'");
            
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

    $location="$role.php"; // If role is admin this will be admin.php, if receptionist this will be receptionist.php and more.
    echo "<script language='javascript'>
    alert('Job Updated')
    window.location.href='$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}

?>