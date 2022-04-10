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
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>

    <div class=card-deck>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Create Staff Account</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="staff/createStaffAccount.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Edit Staff Account</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="staff/editStaffAccount.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Remove Staff Account</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="staff/removeStaffAccount.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Add Standard Task</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="task/standardTask.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Backup database</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="db/backupDatabase.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Restore database</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="db/restoreDatabase.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

