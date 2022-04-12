<?php
// Initialize the session
session_start();
require_once "../config.php";
$username = $_SESSION['username'];
$role = $_SESSION['role'];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
//get all customers for creating the dropdown menu
$query = "SELECT * FROM Customer";
$resultCust = $conn->query($query);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <!-- Page Heading and Title-->
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <h2 class="my-5">Delete Customer </h2>

    <p>
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
     <!-- Form with input labels-->
    <form action='' method='post'>
    <div class="form-group">
    <label for="CustomerID">Choose Customer</label>
    <select required name="CustomerID"  class="form-control" >
      <option selected disabled>Choose...</option>
    <?php //using customer query results
    while($row = $resultCust->fetch_assoc()) {
      echo "<option value=$row[customer_id]>$row[name] $row[surname]</option>";
    } 
    ?>
    </select>
</div>
    <button type="submit" name = "createAccount" class="btn btn-primary">Delete Account</button>
  <form>
<?php

//check if the form has been submitted
if (isset($_POST['createAccount'])) {
    //get attributes value
    $customer_id = $_POST['CustomerID'];   
    $query = "DELETE FROM Customer where customer_id = '$customer_id'";//make update query
    $result = mysqli_query($conn, $query);
    //create Alert
    echo "<script language='javascript'>
    alert('Account delete')
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}