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
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <form action='' method='post'>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputUsername">Username</label>
        <input type="text" class="form-control" required name="inputUsername" placeholder="Username">
        </div>
        <div class="form-group col-md-6">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" required name="inputPassword" placeholder="Password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" required name="inputEmail" placeholder="Email">
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
    <button type="submit" name = "createAccount" class="btn btn-primary">Edit Account</button>
  <form>
<?php
if (isset($_POST['createAccount'])) {
    $username = $_POST['inputUsername'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $role = $_POST['inputRole'];
    $name = $_POST['inputName'];

    $hashed_login = md5($password);
    $query = "SELECT username FROM Staff where username = '$username'";
    $result = $conn->query($query);
    if(mysqli_num_rows($result) < 1){//code by me to check if the username exists
        echo "<script language='javascript'>
                alert('Username does not exist in the database');
              </script>";
    }
    else{
        $query = "UPDATE Staff SET password='$hashed_login', name='$name', role = '$role', email = '$email' where username = '$username'";
        $result = $conn->query($query);
        echo "<script type='text/javascript'>alert('Account Updated');</script>";
    }
       
}