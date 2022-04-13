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
    <h2 class="my-5">Update Vehicle Details </h2>
    <p>
      <!-- Logout button to end Session -->
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
       <!-- Sumbit button refers to processChangeVehicle to carry out the java script and sql queries using Post -->
        <form action="processChangeVehicle.php" method="post">
  <div class="form-group">
  <label for="InputRegID">Choose Vehicle</label>
    <select required name="InputRegID"  class="form-control" >
      <option selected disabled>Choose...</option>
    <?php 
    while($row = $resultVehic->fetch_assoc()) {
      echo "<option value=$row[registration_number]>$row[registration_number] $row[make]</option>";
    } 
    ?>
    </select>
 <!--   <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
  </div>
  <div class="form-group">
    <label for="CustomerID">Choose Customer</label>
    <select required name="CustomerID"  class="form-control" >
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultCust->fetch_assoc()) {
      echo "<option value=$row[customer_id]>$row[name] $row[surname]</option>";
    } 
    ?>
    </select>
  </div>
    <div>            
    <label for="EMake">Make</label>
    <input type="text" name = "EMake" class="form-control" id="EMake" aria-describedby="MakeHelp" placeholder="Enter Vehicle Make" >

  </div>
  <div class="form-group">
    <label for="EngineSerial">Engine Serial</label>
    <input type="text" name = "EngineSerial" class="form-control" id="EngineSerial" placeholder="Enter Engine Serial">
  </div>
    <div>            
     <label for="Model">Model</label>
    <input type="text" name = "Model" class="form-control" id="Model" aria-describedby="ModelHelp" placeholder="Enter Model">
  
  </div>
  <div class="form-group">
    <label for="ChasisNumber">Chasis Number</label>
    <input type="text" name = "ChasisNumber" class="form-control" id="ChasisNumber" placeholder="Enter Chasis Number" >
  </div> 
    <div class="form-group">
    <label for="NextMOT">Next MOT Date</label>
    <input type="date" name = "NextMOT" class="form-control" id="NextMOT" placeholder="Enter Next MOT Date" >
  </div>
    <div class="form-group">
    <label for="Color">Color</label>
    <input type="text" name = "Color" class="form-control" id="Color" placeholder="Enter Color">
  </div>      
    <div class="form-group">
    <label for="NextAnnualService">Next Annual Service</label>
    <input type="date" name = "NextAnnualService" class="form-control" id="NextAnnualService" placeholder="Enter Next Annual Service Date" >
  </div>           
  <!-- Sumbit Button -->
  <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
