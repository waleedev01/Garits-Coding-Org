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
        <?php
            $query = "SELECT * FROM Invoice";
            $result2 = mysqli_query($conn, $query);
        echo "<h3 class='my-5'>Invoices</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
        
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";
            
                echo "<table class='table table-hover table-inverse'>";
                
                echo "<tr>";
                echo "<th>Invoice id</th>";
                echo "<th>Date created</th>";
                echo "<th>Is paid?</th>";
                echo "<th>Date Paid</th>";
                echo "<th>Amount</th>";
                echo "<th>Customer id</th>";
                echo "<th>Job Id</th>";
                echo "</tr>";
          
                if ($result2->num_rows > 0) {
                    // output data of each row
                    while($row = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["invoice_id"] . "</td>";
                        echo "<td>" . $row["date_created"] . "</td>";
                        echo "<td>" . $row["is_paid"] . "</td>";
                        echo "<td>" . $row["date_paid"] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td>" . $row['job_id'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";
