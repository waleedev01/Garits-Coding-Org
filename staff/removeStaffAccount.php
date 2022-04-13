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

$query = "SELECT * FROM Staff";//get all users
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
            <!-- Page Heading and Title-->
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <p>
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <form action='' method='post'>
    <div class="form-group">        <!--Form for getting user id-->
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
    <button type="submit" name = "createAccount" class="btn btn-primary">Delete Account</button>
  <form>
<?php

//if form has been submitted
if (isset($_POST['createAccount'])) {
    $username = $_POST['inputUsername'];//get username
    $query = "SELECT username FROM Staff where username = '$username'";//delete query
    $result = $conn->query($query);
    if(mysqli_num_rows($result) < 1){//code to check if the username exists
        echo "<script language='javascript'>
                alert('Username does not exist in the database');
              </script>";
    }
    else{
        $query = "DELETE from Staff where username = '$username'";
        $result = $conn->query($query);
        echo "<script type='text/javascript'>alert('Account Deleted');</script>";
    }

       
}