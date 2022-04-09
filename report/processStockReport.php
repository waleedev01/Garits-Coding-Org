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

if (isset($_GET['CreateStockReport'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    if($endDate<$startDate){
        echo "<script language='javascript'>
                alert('Incorrect Date Range');
                window.location.href = 'generateReport.php';
              </script>";
    }

    $query = "SELECT part_name, s.item_id, manufacturer_name,vehicle_type,year, price, quantity AS 'InitialStockLevel', 
    quantity * price AS 'initial_cost', COUNT(su.item_id) 'Used', 
    delivery, 
    quantity-COUNT(su.item_id) 'New_Stock_Level', (quantity-COUNT(s.item_id)) * price AS 'Stock_cost', threshold_level
    FROM Stock s
    LEFT JOIN Stock_used su ON s.item_id = su.item_id AND (su.date_used>=$startDate AND su.date_used < $endDate)
    GROUP BY s.item_id;";
    $result = mysqli_query($conn, $query);
}

?>

<!DOCTYPE html>
<html lang="en">
<script type="text/javascript" src="print.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css'>
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
        <?php
            echo "<h3 class='my-5'>Jobs Report</h1>";
            echo "<div class='container'>";
            echo "<div class='row-fluid'>";
                echo "<div class='col-xs-12'>";
                echo "<div class='table-responsive'>";    
                    echo "<table id='stockReport' cellpadding='0' cellspacing='0' class='table table-hover table-inverse'>";
                    echo "<tr>";
                    echo "<th>Part Name</th>";
                    echo "<th>item id</th>";
                    echo "<th>manufacturer name</th>";
                    echo "<th>vehicle type</th>";
                    echo "<th>year</th>";
                    echo "<th>price</th>";
                    echo "<th>inital stock level</th>";
                    echo "<th>Initial cost</th>";
                    echo "<th>Stock used</th>";
                    echo "<th>Delivery</th>";
                    echo "<th>New stock level</th>";
                    echo "<th>Stock Cost</th>";
                    echo "<th>Threshold</th>";
                    echo "</tr>";
                    
                    echo "<tr>";
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result ->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["part_name"] . "</td>";
                            echo "<td>" . $row["item_id"] . "</td>";
                            echo "<td>" . $row["manufacturer_name"] . "</td>";
                            echo "<td>" . $row["vehicle_type"] . "</td>";
                            echo "<td>" . $row["year"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["InitialStockLevel"] . "</td>";
                            echo "<td>" . $row["initial_cost"] . "</td>";
                            echo "<td>" . $row["Used"] . "</td>";
                            echo "<td>" . $row["delivery"] . "</td>";
                            echo "<td>" . $row["New_Stock_Level"] . "</td>";
                            echo "<td>" . $row["Stock_cost"] . "</td>";
                            echo "<td>" . $row["threshold_level"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    echo "</table>";
                    echo"
                    <button onclick=fnExcelReport6()>
                       <span class='glyphicon glyphicon-download'></span>
                       Download Report
                    </button>";
                echo "</div>";
                echo "</div>";
