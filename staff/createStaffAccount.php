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
    <form action='' method='post'>    <!-- Form for creating staff account-->
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control"  name="inputEmail" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" required name="inputPassword" placeholder="Password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputUsername">Username</label>
        <input type="text" class="form-control" required name="inputUsername" placeholder="Username">
        </div>
        <div class="form-group col-md-6">
        <label for="inputName">Name</label>
        <input type="text" class="form-control" required name="inputName" placeholder="Name">
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
    <button type="submit" name = "createAccount" class="btn btn-primary">Create Account</button>
  <form>
<?php

//check if form has been submitted
if (isset($_POST['createAccount'])) {
    //get values
    $username = $_POST['inputUsername'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $role = $_POST['inputRole'];
    $name = $_POST['inputName'];

    //check if username already exists in the table
    $query = "SELECT username FROM Staff where username = '$username'";
    $result = $conn->query($query);
    if(mysqli_num_rows($result) > 0){//check if the username already exists
        echo "<script language='javascript'>
                alert('Username is already in the database');
              </script>";
    }

    //inset staff record
    $query = "INSERT INTO Staff (username,password,name,role,email) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss',$username, $hashed_login,$name,$role,$email);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
    //if staff is a mechanic or foreman also create record in the Mechanic table
    if($role=='Mechanic' || $role=='Foreman'){
        $query = "INSERT INTO Mechanic (username,hourly_rate) VALUES (?,?)";
        $stmt = $conn->prepare($query);
        $hourly_rate = null;
        $stmt->bind_param('sd',$username,$hourly_rate);
        /* Execute the statement */
        $stmt->execute();
        $row = $stmt->affected_rows;
    }
    if ($row > 0) { 
        echo "<script type='text/javascript'>alert('Account Created');</script>";
    } else {
        "error";
    }
       
}