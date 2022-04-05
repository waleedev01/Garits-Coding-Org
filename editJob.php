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


if (isset($_POST['update'])) {
    $pick_job_id = $_POST['update'];   
}

?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<form action = 'processEditJob.php' method = 'post'>
  <div class="form-group">
    <label for="exampleInputEmail1">Job Id: <?php echo $pick_job_id; ?></label>
    <input type="hidden" class="form-control" name="job_id" value= <?php echo $pick_job_id; ?> placeholder="Enter time spent in job">
  </div>
  <div class="form-group">
    <label for="timeSpent">Time Spent</label>
    <input type="number" class="form-control" name="timeSpent" placeholder="Enter time spent in job">
  </div>
  <div class="form-group">
    <label for="updateStatus">Update Status</label>
    <input type="text" class="form-control" name="updateStatus" placeholder="Job status">
  </div>
  <div class="form-group">
    <label for="addStock">Add Stock Id</label>
    <input type="text" class="form-control" name="addStock" placeholder="Enter stock id">
  </div>
  <div class="form-group">
    <label for="addTask">Add Task Id</label>
    <input type="text" class="form-control" name="addTask" placeholder="Enter task id">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>