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

$query = "SELECT * FROM Stock where quantity < threshold_level";
$result = mysqli_query($conn, $query);

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
    <?php
    if(mysqli_num_rows($result) > 0){
        echo"<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Low Stock Alert</strong> Please go to Check Stock Level page.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      ";} ?><p>

        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
        <a href="job/viewJobs.php" class="btn btn-secondary ml-3">Jobs list</a>
        <a href="stock/viewSpareParts.php" class="btn btn-secondary ml-3">Spare Parts</a>
        <a href="customer/viewCustomers.php" class="btn btn-secondary ml-3">Customers</a>
        <a href="vehicle/searchVehicle.php" class="btn btn-secondary ml-3">Vehicle list</a>

        <meta charset="UTF-8">
    <div class=card-deck>
     <!-- Receptionist view -->   
    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Create Customer Account</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="customer/createCustomer.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Edit Customer Account</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="customer/editCustomerAccount.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Delete Customer Account</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="customer/deleteCustomerAccount.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Add Stock Item</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="addStock.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Update Stock Item</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="updateStock.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>
    </div>
    <div class=card-deck>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Add Vehicle</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="addVehicle.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Update Vehicle</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="updateVehicle.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Delete Vehicle</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="deleteVehicle.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Create Job</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="createJob.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Update Job</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="editJobRec.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>
    </div>
    <div class=card-deck>
    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">View Jobs</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="job/viewJobs.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Produce Invoice</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="invoice/produceInvoice.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Check Stock Level</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="stock/replenishmentOrder.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Sell Stock Item</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="stock/stockOrder.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Generate Report</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="report/generateReport.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>
    </div>
    <div class=card-deck>

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">View Invoices</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="invoice/viewInvoices.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>  

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">MoT reminders</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="MoTreminders.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>  

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Annual Service reminders</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="as_reminders.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>  

    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
        <div class="card-header">Confirm delivery</div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
            <a href="deliveryReceived.php" class="btn btn-primary stretched-link">Open</a>
        </div>
    </div>  