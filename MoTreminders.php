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
$today = date("Y-m-d");
$week =  date('Y-m-d', strtotime("+7 days"));
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
        <?php
            $query = "SELECT * FROM Vehicle where next_MoT_date between '$today' and '$week'";//query for getting vehicles that have a MoT in the next 7 days 
            $result = mysqli_query($conn, $query);
        echo "<h3 class='my-5'>Vehicle with MoT in the next 7 days</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
        
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";
            
                echo "<table class='table table-hover table-inverse'>";//table with vehicle details
                
                echo "<tr>";
                echo "<th>Registration Number</th>";
                echo "<th>Make</th>";
                echo "<th>Engine Serial</th>";
                echo "<th>Model</th>";
                echo "<th>Chassis number</th>";
                echo "<th>Next MoT date</th>";
                echo "<th>Color</th>";
                echo "</tr>";
          
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo"<form action = '' method='POST'>";  
                        echo "<tr>";
                        echo "<td>" . $row["registration_number"] . "</td>";
                        echo "<td>" . $row["make"] . "</td>";
                        echo "<td>" . $row["engine_serial"] . "</td>";
                        echo "<td>" . $row["model"] . "</td>";
                        echo "<td>" . $row['chassis_num'] . "</td>";
                        echo "<td>" . $row['next_MoT_date'] . "</td>";
                        echo "<td>" . $row['color'] . "</td>";
                        echo "</tr>";
                        echo"</form>";           
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";
