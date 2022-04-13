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

    $query = "SELECT item_id,part_name FROM Stock";
    $resultParts = $conn->query($query);
?>
<form action = 'processEditJob.php' method = 'post'><!-- Form for editing jobs with only the mechanic view columns -->
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
  <button type="submit" class="btn btn-primary">Submit</button>
</form>