<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
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

$query = "SELECT * FROM Staff";
$result = $conn->query($query);
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
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <p>
        <!-- Page Heading and Title-->
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <form action='' method='post'><!-- Form for editing the staff account -->
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputUsername">Choose User</label>
        <select name="inputUsername"  class="form-control" required>
        <option selected required disabled value="">Choose...</option>
        <?php 
        while($row = $result->fetch_assoc()) {
        echo "<option value=$row[username]>$row[username]</option>";
        } 
        ?>
    </select>
        </div>
        <div class="form-group col-md-6">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control"  name="inputPassword" placeholder="Password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control"  name="inputEmail" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
        <label for="inputName">Name</label>
        <input type="text" class="form-control"  name="inputName" placeholder="Name">
        </div>
    </div>
    <div class="form-group">
        <label for="inputRole">Role</label>
        <select name="inputRole"  class="form-control" required>
            <option disabled>Choose...</option>
            <option value="Mechanic">Mechanic</option>
            <option value="Receptionist">Receptionist</option>
            <option value="Foreman">Foreman</option>
            <option value="Franchisee">Franchisee</option>
        </select>
        </div>
    </div>
    <button type="submit" name = "createAccount" class="btn btn-primary">Edit Account</button>
  <form>
<?php

//if form has been submitted
if (isset($_POST['createAccount'])) {
    //get all the values
    $username = $_POST['inputUsername'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $role = $_POST['inputRole'];
    $name = $_POST['inputName'];
    $hashed_login = md5($password);

     //update queries that updates columns that has been inputted. Check if input is not null.
     if($email!=null){
        $query = "UPDATE Staff SET email = '$email' where username='$username'";
        $result = mysqli_query($conn, $query);
      }
  
      if($password!=null){
        $query = "UPDATE Staff SET password = '$hashed_login' where username='$username'";
        $result = mysqli_query($conn, $query);
      }

      if($role!=null){
        $query = "UPDATE Staff SET role = '$role' where username='$username'";
        $result = mysqli_query($conn, $query);
      }

      if($name!=null){
        $query = "UPDATE Staff SET name = '$name' where username='$username'";
        $result = mysqli_query($conn, $query);
      }
    
      //alert
      echo "<script language='javascript'>
      alert('Account Updated')
      </script>";
      echo "<meta http-equiv='refresh' content='0'>";

       
}