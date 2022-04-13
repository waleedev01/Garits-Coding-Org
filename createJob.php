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

$query = "SELECT * FROM Customer";
$resultCust = $conn->query($query);

$query = "SELECT * FROM Vehicle";
$resultVehic = $conn->query($query);
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
  <!-- Session Login displayed with the user name and account used to logged in -->
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <!-- Page Heading and Title-->
    <h2 class="my-5">Create Job </h2>
    <p>
      <!-- Logout button to end Session -->
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
       <!-- Sumbit button refers to processAddJob to carry out the java script and sql queries using Post -->
        <form action="processAddJob.php" method="get">
     <div class="form-group">
       <!-- All the input fields -->
     <!--   <label for="jobID">Job ID</label>
    <input type="text" name = "jobID" class="form-control" id="jobID" placeholder="Enter Job ID" required="required">
  </div>
  <div class="form-group"> 
    <label for="jobDescription">Job Description</label>
    <input type="text" name = "jobDescription" class="form-control" id="jobDescription" placeholder="Enter Job Description" required="required">
  </div> -->
    <div>            
    <label for="jobType">Job Type</label>
    <select name="jobType"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
      <option value='MoT'>MoT</option>
      <option value='repair'>repair</option>
      <option value='annual service'>Annual Service</option>
      </select>

  </div>
  <div class="form-group">
  <label for="Status">Status</label>
    <select name="Status"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
      <option selected value='new'>new</option>
      <option value='pending'>pending</option>
      <option value='progress'>progress</option>
      <option value='completed'>completed</option>
      </select>
  </div>
    <div>            
     <label for="estimateAmount">Estimate Amount</label>
    <input type="text" name = "estimateAmount" class="form-control" id="estimateAmount" placeholder="Enter Estimate Amount">
  
  </div>
  <div class="form-group">
    <label for="bookInDate">Book In Date</label>
    <input type="date" name = "bookInDate" class="form-control" id="bookInDate" placeholder="Enter Book In Date" required="required">
  </div> 
    <div class="form-group">
    <label for="timeSpent">Time Spent</label>
    <input type="text" name = "timeSpent" class="form-control" id="timeSpent" placeholder="Enter Time Spent">
  </div>  
    <div class="form-group">
    <label for="customerID">Choose Customer</label>
    <select name="customerID"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultCust->fetch_assoc()) {
      echo "<option value=$row[customer_id]>$row[customer_id] $row[name] $row[surname]</option>";
    } 
    ?>
    </select>
  </div>
  <div class="form-group">
  <label for="registrationID">Choose Vehicle</label>
    <select name="registrationID"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultVehic->fetch_assoc()) {
      echo "<option value=$row[registration_number]>$row[registration_number] $row[make] $row[model]</option>";
    } 
    ?>
    </select>
  </div> 
  
  
  <!-- Sumbit Button -->
  <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
