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
        <?php //select all low stock elements
            $query = "SELECT * FROM Stock where (quantity < 1 or quantity < threshold_level) and delivery is not null or delivery !=0 ";
            $result = mysqli_query($conn, $query);
            //select all spare parts
            $query_all = "SELECT * FROM Stock";
            $result_all = mysqli_query($conn, $query_all);
        echo "<h3 class='my-5'>Low Stock Orders</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
        
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";
                //table to show the low stock items
                echo "<table class='table table-hover table-inverse'>";
                
                echo "<tr>";
                echo "<th>Item id</th>";
                echo "<th>Part name</th>";
                echo "<th>Quantity</th>";
                echo "<th>Year</th>";
                echo "<th>Price</th>";
                echo "<th>Manufacturer Name</th>";
                echo "<th>Vehicle Type</th>";
                echo "<th>Threshold</th>";
                echo "<th>Delivery</th>";
                echo "<th>Mark as delivered</th>";
                echo "</tr>";
          
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo"<form action = 'processDeliveryReg.php' method='POST'>";//form for order spare parts
                        echo "<tr>";
                        echo "<td>" . $row["item_id"] . "</td>";
                        echo "<td>" . $row["part_name"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>" . $row["year"] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['manufacturer_name'] . "</td>";
                        echo "<td>" . $row['vehicle_type'] . "</td>";
                        echo "<td>" . $row['threshold_level'] . "</td>";
                        echo "<th>". $row['delivery'] ."</th>";
                        echo "<td><input type='submit' value='" . $row['item_id'] ."' name='saveDelivery'><br/></td>";

                        echo "</tr>";
                        echo"</form>";           
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
           