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
$tmp = false;//check if it has invoice
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
    <!-- Page Heading and Title-->
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <p>
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
        <meta charset="UTF-8">
        <?php
            //select all the jobs that has been completed
            $query = "SELECT job_id,job_type,status,estimate_amount,book_in_date, time_spent, customer_id, registration_number, username FROM Job  WHERE status = 'completed' ORDER BY job_id ASC";
            $result = mysqli_query($conn, $query);
            //queries to check if a completed job has an invoice or not
            $query_invoice = "SELECT job_id
            FROM   Job
            WHERE  status = 'completed' and NOT EXISTS (SELECT job_id 
                               FROM   Invoice 
                               WHERE  Job.job_id = Invoice.job_id);";
            $result_invoice = mysqli_query($conn, $query_invoice);
            while ($row = mysqli_fetch_array($result_invoice)){
                $jobWithoutInvoice[] = $row['job_id']; 
            }
        //table to show completed jobs
        echo "<h3 class='my-5'>Completed Jobs</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";    
                echo "<table class='table table-hover table-inverse'>";
                
                echo "<tr>";
                echo "<th>Job id</th>";
                echo "<th>Job type</th>";
                echo "<th>Status</th>";
                echo "<th>Estimate amount</th>";
                echo "<th>Book in date</th>";
                echo "<th>Time spent</th>";
                echo "<th>Customer Id</th>";
                echo "<th>Registration Number</th>";
                echo "<th>Mechanic Id</th>";
                echo "<th>Invoice</th>";

                echo "</tr>";
          
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo"<form action = 'processProduceInvoice.php' method='POST'>";  
                        echo "<tr>";
                        echo "<td>" . $row["job_id"] . "</td>";
                        echo "<td>" . $row["job_type"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["estimate_amount"] . "</td>";
                        echo "<td>" . $row['book_in_date'] . "</td>";
                        echo "<td>" . $row['time_spent'] . "</td>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td>" . $row['registration_number'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        //if a job has an iovoice then tmp will be false
                        for($i = 0;$i<count($jobWithoutInvoice);$i++){
                            if($row["job_id"] == $jobWithoutInvoice[$i]){
                                $tmp = true;
                            }
                            else
                                $tmp = false;
                            if($tmp)
                                break;
                        }
                        if($tmp)
                            echo "<td><input type='submit' name='Create' value='" . $row['job_id'] . "' /><br/>Create</td>";
                        else
                            echo "<td><input type='submit' name='View' value='" . $row['job_id'] . "' /><br/>View</td>";
                        echo "</tr>";
                        echo"</form>";           
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";
