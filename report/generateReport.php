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
$today = date("Y-m-d");
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
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
        <meta charset="UTF-8">
        <?php
        echo "<h3 class='my-5'>Reports</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";    
                echo "<table class='table table-hover table-inverse'>";
                echo "<tr>";
                echo "<th>Report type</th>";
                echo "<th>Month</th>";
                echo "<th>Year</th>";
                echo "<th>Overall</th>";
                echo "<th>Create</th>";
                echo"<form action = 'processGenerateReport.php' method='get'>";  
                echo "<tr>";
                echo "<td>Vehicle Report</td>";
                echo "<td><input type=number name='month' max=12 min=1></td>";
                echo "<td><input type=number name='year' value=2022 max=2022 min=2020></td>";
                echo "<td><input class='form-check-input' type='radio' name='overall' id='overall'>
                <label class='form-check-label' for='overall'></td>";
                echo "<td><input type='submit' name='CreateJobs'><br/></td>";
                echo "</tr>";
                echo"</form>"; 
                echo "</table>";
                echo "</div>";
                echo "</div>";
    
                
        
        
        
        
        
        ?>