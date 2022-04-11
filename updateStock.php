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
$query = "SELECT * FROM Stock";
$result = $conn->query($query);
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
    <h2 class="my-5">Update Stock </h2>
    <p>
      <!-- Logout button to end Session -->
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
       <!-- Sumbit button refers to processUpdateStock to carry out the java script and sql queries using Post -->
        <form action="processUpdateStock.php" method="post">
  <div class="form-group">
    <!-- All the input fields -->
    <select required name="InputID"  class="form-control" >
      <option selected disabled>Choose...</option>
    <?php 
    while($row = $result->fetch_assoc()) {
      echo "<option value=$row[item_id]>$row[item_id] $row[part_name]</option>";
    } 
    ?>
    </select>
  </div>
  <div class="form-group"> 
    <label for="PartName">Part Name</label>
    <input type="text" name = "PartName" class="form-control" id="PartName" placeholder="Enter Part Name" >
  </div>
    <div class = "form-group">            
    <label for="quantity">Quantity</label>
    <input type="number" name = "quantity" class="form-control" id="quantity" aria-describedby="quantityHelp" placeholder="Enter Quantity" >
  </div>
  <div class="form-group">
    <label for="year">Year</label>
    <input type="text" name = "year" class="form-control" id="year" placeholder="Enter Year">
  </div>
    <div>            
     <label for="price">Price</label>
    <input type="number" name = "price" class="form-control" id="price" aria-describedby="priceHelp" placeholder="Enter price">
  
  </div>
  <div class="form-group">
    <label for="manufacturerName">Manufacturer Name</label>
    <input type="text" name = "manufacturerName" class="form-control" id="manufacturerName" placeholder="Enter Manufacturer Name" >
  </div> 
    <div class="form-group">
    <label for="vehicleType">Vehicle Type</label>
    <input type="text" name = "vehicleType" class="form-control" id="vehicleType" placeholder="Enter Vehicle Type" >
  </div>
    <div class="form-group">
    <label for="thresholdLevel">Threshold Level</label>
    <input type="number" name = "thresholdLevel" class="form-control" id="thresholdLevel" placeholder="Enter Threshold Level" >
  </div>      
  <!-- Sumbit Button -->
  <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
