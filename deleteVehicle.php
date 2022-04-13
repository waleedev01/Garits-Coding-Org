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

$query = "SELECT * FROM Vehicle";
$resultVehicle = $conn->query($query);
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
    <h2 class="my-5">Delete Vehicle</h2>
    <p>
       <!-- Logout button to end Session -->
       <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
       <a href="<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
       <!-- Sumbit button refers to processDeleteVehicle to carry out the java script and sql queries using Post -->
        <form action="processDeleteVehicle.php" method="post">
        <div class="form-group">
    <label for="InputRegID">Choose Vehicle</label>
    <select required name="InputRegID"  class="form-control" >
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultVehicle->fetch_assoc()) {
      echo "<option value=$row[registration_number]>$row[registration_number]</option>";
    } 
    ?>
    </select>
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>