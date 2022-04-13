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

$query = "SELECT * FROM Job where status!='completed' and status!='pending' and job_type!='stock_order'";//query for selecting not completed jobs
$resultJobs = $conn->query($query);
?>
<form action = '' method = 'post'><!--Form for adding a job from pending list-->
  <div class="form-group">
    <label for="chooseJob">Choose Job</label>
    <select name="chooseJob"  class="form-control" required>
    <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultJobs->fetch_assoc()) {
      echo "<option value=$row[job_id]>$row[job_id] $row[status] $row[book_in_date] </option>";
    } 
    ?>
    </select>
  </div>
 
  <button type="submit" name='addPendingList' class="btn btn-primary">Submit</button>
</form>
<?php

//check if form has been submitted
if (isset($_POST['addPendingList'])) {
    $job_id = $_POST['chooseJob'];//get job it
    $query = "UPDATE Job SET status='pending' where job_id = '$job_id'";//update that job status to pending
    $result= mysqli_query($conn, $query);
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Job Added to the pending list')
    window.location.href='../$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}