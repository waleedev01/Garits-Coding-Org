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

if (isset($_GET['CreateJobs'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];

    if(isset($_GET['month']) && isset($_GET['year'])){
        $query = "SELECT job_id
        FROM Job
        WHERE SUBSTRING(book_in_date,5, 2) = $month";
        $result = mysqli_query($conn, $query);
        $total_jobs_in_month = mysqli_num_rows($result);
    }

        $query = "SELECT job_type, COUNT(*) AS 'count'
        FROM Job
        GROUP BY job_type;";
        $result = mysqli_query($conn, $query);
        $i = 0;
        while ($row = mysqli_fetch_array($result)){
            if($i==0)
                $MoT_count = $row['count'];
            if($i==1)
                $annual_service_count = $row['count'];
            if($i==2)
                $repair_count = $row['count'];
            $i++;
        }  
    

    $query = "SELECT *
    FROM Job j, AccountHolder a
    WHERE j.customer_id IN(SELECT a.customer_id FROM AccountHolder);";
    $result = mysqli_query($conn, $query);
    $total_account_customers = mysqli_num_rows($result);

    $query = "SELECT *
    FROM Job";
    $result = mysqli_query($conn, $query);
    $total_normal_customers = mysqli_num_rows($result)-$total_account_customers;


    $query = "SELECT * FROM Job";
    $result = mysqli_query($conn, $query);
    $total_jobs = mysqli_num_rows($result);
    


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
                    echo "<table id='jobsOverallReport' cellpadding='0' cellspacing='0' class='table table-hover table-inverse'>";
                    echo "<tr>";
                    echo "<th>Total jobs</th>";
                    echo "<th>MoT</th>";
                    echo "<th>Repair</th>";
                    echo "<th>Annual service</th>";
                    echo "<th>Account holder</th>";
                    echo "<th>Normal Customer</th>";
                    echo "</tr>";
                    
                    echo "<tr>";
                    echo "<td>$total_jobs</td>";
                    echo "<td>$MoT_count</td>";
                    echo "<td>$repair_count</td>";
                    echo "<td>$annual_service_count</td>";
                    echo "<td>$total_account_customers</td>";
                    echo "<td>$total_normal_customers</td>";
                    echo "</tr>";

                    

                    echo "</table>";
                    echo"
                    <button onclick=fnExcelReport()>
                       <span class='glyphicon glyphicon-download'></span>
                       Download Report
                    </button>";
                echo "</div>";
                echo "</div>";
        
        if(isset($_GET['month']) && isset($_GET['year'])    && isset($total_jobs_in_month)){
            echo "<h3 class='my-5'>Jobs Report Monthly</h1>";
            echo "<div class='container'>";
            echo "<div class='row-fluid'>";
                echo "<div class='col-xs-12'>";
                echo "<div class='table-responsive'>";    
                    echo "<table class='table table-hover table-inverse'>";
                    echo "<tr>";
                    echo "<th>Total jobs in this month:$month / $year</th>";
                    echo "</tr>";
                    
                    echo "<tr>";
                    echo "<td>$total_jobs_in_month</td>";
                    echo "</tr>";
                    echo"</form>";           
                    echo "</table>";
        
                echo "</div>";
                echo "</div>";
        }
