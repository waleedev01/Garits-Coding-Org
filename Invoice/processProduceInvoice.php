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
if (isset($_POST['Create'])) {
    $job_id = $_POST['Create'];

$query3 = "SELECT job_id,job_type,status,estimate_amount,book_in_date, time_spent, customer_id, registration_number, username FROM Job  WHERE job_id = '$job_id'";
$result3 = mysqli_query($conn, $query3);
while ($row = mysqli_fetch_array($result3)){
    $mechanicUsername = $row['username'];
    $time_spent = $row['time_spent'];
    $customer_id = $row['customer_id'];
    $job_type = $row['job_type'];
}

$query = "SELECT hourly_rate FROM Mechanic  WHERE username = '$mechanicUsername'";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)){
    $hourly_rate = $row['hourly_rate'];
}  

$totalMechanic = $hourly_rate * $time_spent;
if($job_type=='repair' || $job_type == 'stock_order'){
    $query = "SELECT item_id FROM Stock_used  WHERE job_id = '$job_id'";
    $result = mysqli_query($conn, $query);
    if($job_type=='repair'){
    while ($row = mysqli_fetch_array($result))
        $item_id[] = $row['item_id'];

    for($i = 0;$i<count($item_id);$i++){
        $query = "SELECT price FROM Stock  WHERE item_id = '$item_id[$i]'";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)){
            $prices[] = $row['price'];
        }
    }

    for($i = 0;$i<count($prices);$i++){
        if($i<count($prices)-1)
            $totalPartsPrice = $prices[$i]+$prices[$i+1];
    }
    $totalPartsPrice *= 1.30;
    $totalPartsPrice *= 1.20;
    $totalMechanic *= 1.20;
    $totalJobWithVat = $totalMechanic+$totalPartsPrice;
    }
    else{
        while ($row = mysqli_fetch_array($result))
            $item_id = $row['item_id'];
        $query9 = "SELECT price FROM Stock  WHERE item_id = '$item_id'";
        $result9= mysqli_query($conn, $query9);
        while ($row = mysqli_fetch_array($result9))
            $priceStockOrder = $row['price'];
        $totalPartsPrice = $priceStockOrder;
        $totalPartsPrice *= 1.30;
        $totalPartsPrice *= 1.20;
        $totalJobWithVat = $totalPartsPrice;

    }
   
}
$query2 = "SELECT job_id,job_type,status,estimate_amount,book_in_date, time_spent, customer_id, registration_number, username FROM Job  WHERE job_id = '$job_id'";
$result2 = mysqli_query($conn, $query2);
$today = date("Y/m/d");
$query = "INSERT INTO Invoice (date_created,is_paid,amount,job_id,customer_id) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($query);
$MoT_price = 66;
$anual_price = 114;
$is_paid = 0;
if($job_type=='repair' || $job_type == 'stock_order')
    $stmt->bind_param('sidii',$today,$is_paid,$totalJobWithVat,$job_id,$customer_id);
if($job_type=='MoT')
    $stmt->bind_param('sidii',$today,$is_paid,$MoT_price,$job_id,$customer_id);
if($job_type=='annual service')
    $stmt->bind_param('sidii',$today,$is_paid,$anual_price,$job_id,$customer_id);
/* Execute the statement */
$stmt->execute();
$row = $stmt->affected_rows;
if ($row > 0) { 
    echo "<script type='text/javascript'>alert('Invoice Created');</script>";
} else {
    "error";
}
$query5 = "SELECT invoice_id,is_paid, date_paid, date_created FROM Invoice  WHERE job_id = '$job_id'";
$result5 = mysqli_query($conn, $query5);
while ($row = mysqli_fetch_array($result5)){
    $is_paid = $row['is_paid'];
    $date_paid = $row['date_paid'];
    $date_created = $row['date_created'];
    $invoice_id = $row['invoice_id'];

}  
?>

<!DOCTYPE html>
<html lang="en">
<script type="text/javascript" src="print.js"></script>

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
        if($job_type == 'repair' || $job_type == 'stock_order'){
        echo "<h3 class='my-5'>Completed Jobs</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";    
                echo "<table class='table table-hover table-inverse'>";
                echo "<tr>";
                echo "<th>Job id</th>";
                echo "<th>Job type</th>";
                echo "<th>Time Spent</th>";
                echo "<th>Total parts price</th>";
                echo "<th>Mechanic rate</th>";
                echo "<th>Total mechanic</th>";
                echo "<th>Total with VAT</th>";
                echo "<th>Customer Id</th>";
                echo "<th>Registration Number</th>";
                echo "<th>Mechanic Id</th>";
                echo "<th>Date Created</th>";
                echo "<th>Cash</th>";
                echo "<th>Card</th>";
                echo "<th>Paid</th>";
                echo "</tr>";
                if ($result2->num_rows > 0) {
                    // output data of each row
                    while($row = $result2->fetch_assoc()) {
                        echo"<form action = 'payInvoice.php' method='POST'>";  
                        echo "<tr>";
                        echo "<td>" . $row["job_id"] . "</td>";
                        echo "<td>" . $row["job_type"] . "</td>";
                        echo "<td>" . $row['time_spent'] . "</td>";
                        echo "<td>" . $totalPartsPrice. "</td>";
                        echo "<td>" . $hourly_rate. "</td>";
                        echo "<td>" . $totalMechanic. "</td>";
                        echo "<td>" . $totalJobWithVat. "</td>";
                        echo "<td>".$row['customer_id']."</td>";
                        echo "<td>".$row['registration_number']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>$date_created</td>";
                        if($is_paid==0){
                            echo "<td><input class='form-check-input' type='radio' value = 'cash' checked name='payment_type' id='cash'>
                            <label class='form-check-label' for='cash'></td>";
                            echo "<td><input class='form-check-input' type='radio' value = 'card' name='payment_type' id='card'>
                            <label class='form-check-label' for='card'></td>";
                            echo "<td><input type='submit' name='pay' value='$invoice_id' /><br/>Pay</td>";
                        }
                        else
                            echo "<td>Yes on.$date_paid.</td>";
                        echo "</tr>";
                echo"</form>";           
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";
        }
        else{
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
                echo "<th>Total with VAT</th>";
                echo "<th>Customer Id</th>";
                echo "<th>Registration Number</th>";
                echo "<th>Mechanic Id</th>";
                echo "<th>Date Created</th>";
                echo "<th>Cash</th>";
                echo "<th>Card</th>";
                
                echo "<th>Paid</th>";
                echo "</tr>";

                if ($result2->num_rows > 0) {
                    // output data of each row
                    while($row = $result2->fetch_assoc()) {
                        echo"<form action = 'payInvoice.php' method='POST'>";  
                        echo "<tr>";
                        echo "<td>" . $row["job_id"] . "</td>";
                        echo "<td>" . $row["job_type"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["estimate_amount"] . "</td>";
                        echo "<td>" . $row['book_in_date'] . "</td>";
                        if($job_type=='MoT')
                            echo "<td>66£</td>";
                        else
                            echo "<td>114£</td>";
                        echo "<td>".$row['customer_id']."</td>";
                        echo "<td>".$row['registration_number']."</td>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>$date_created</td>";
                        if($is_paid==0){
                            echo "<td><input class='form-check-input' type='radio' value = 'cash' checked name='payment_type' id='cash'>
                            <label class='form-check-label' for='cash'></td>";
                            echo "<td><input class='form-check-input' type='radio' value = 'card' name='payment_type' id='card'>
                            <label class='form-check-label' for='card'></td>";
                            echo "<td><input type='submit' name='pay' value='$invoice_id' /><br/>Pay</td>";
                        }
                        else
                            echo "<td>Yes on.$date_paid.</td>";
                        echo "</tr>";
                        echo"</form>";           
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";
        }

    }

    else{
        $job_id = $_POST['View'];

        $query3 = "SELECT job_id,job_type,status,estimate_amount,book_in_date, time_spent, customer_id, registration_number, username FROM Job  WHERE job_id = '$job_id'";
    $result3 = mysqli_query($conn, $query3);
    while ($row = mysqli_fetch_array($result3)){
        $mechanicUsername = $row['username'];
        $time_spent = $row['time_spent'];
        $customer_id = $row['customer_id'];
        $job_type = $row['job_type'];
    }

    $query = "SELECT hourly_rate FROM Mechanic  WHERE username = '$mechanicUsername'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)){
        $hourly_rate = $row['hourly_rate'];
    }  
 
    $totalMechanic = $hourly_rate * $time_spent;
    if($job_type=='repair'){
        $query = "SELECT item_id FROM Stock_used  WHERE job_id = '$job_id'";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result))
            $item_id[] = $row['item_id'];

        for($i = 0;$i<count($item_id);$i++){
            echo "Item id\n";
            echo $item_id[$i];
            $query = "SELECT price FROM Stock  WHERE item_id = '$item_id[$i]'";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($result)){
                $prices[] = $row['price'];
            }
        }

        for($i = 0;$i<count($prices);$i++){
            if($i<count($prices)-1)
                $totalPartsPrice = $prices[$i]+$prices[$i+1];
        }
        $totalPartsPrice *= 1.30;
        $totalPartsPrice *= 1.20;
        $totalMechanic *= 1.20;
        $totalJobWithVat = $totalMechanic+$totalPartsPrice;

    }
    $query2 = "SELECT job_id,job_type,status,estimate_amount,book_in_date, time_spent, customer_id, registration_number, username FROM Job  WHERE job_id = '$job_id'";
    $result2 = mysqli_query($conn, $query2);

    $query5 = "SELECT invoice_id,is_paid, date_paid, date_created FROM Invoice  WHERE job_id = '$job_id'";
    $result5 = mysqli_query($conn, $query5);
    while ($row = mysqli_fetch_array($result5)){
        $is_paid = $row['is_paid'];
        $date_paid = $row['date_paid'];
        $date_created = $row['date_created'];
        $invoice_id = $row['invoice_id'];
        
    }  
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
            if($job_type == 'repair' || $job_type == 'stock_order'){
            echo "<h3 class='my-5'>Completed Jobs</h1>";
            echo "<div class='container'>";
            echo "<div class='row-fluid'>";
                echo "<div class='col-xs-12'>";
                echo "<div class='table-responsive'>";    
                    echo "<table class='table table-hover table-inverse' id='invoiceRepair'>";
                    echo "<tr>";
                    echo "<th>Job id</th>";
                    echo "<th>Job type</th>";
                    echo "<th>Time Spent</th>";
                    echo "<th>Total parts price</th>";
                    echo "<th>Mechanic rate</th>";
                    echo "<th>Total mechanic</th>";
                    echo "<th>Total with VAT</th>";
                    echo "<th>Customer Id</th>";
                    echo "<th>Registration Number</th>";
                    echo "<th>Mechanic Id</th>";
                    echo "<th>Date Created</th>";
                    echo "<th>Cash</th>";
                    echo "<th>Card</th>";
                    echo "<th>Paid</th>";
                    echo "</tr>";
                    if ($result2->num_rows > 0) {
                        // output data of each row
                        while($row = $result2->fetch_assoc()) {
                            echo"<form action = 'payInvoice.php' method='POST'>";  
                            echo "<tr>";
                            echo "<td>" . $row["job_id"] . "</td>";
                            echo "<td>" . $row["job_type"] . "</td>";
                            echo "<td>" . $row['time_spent'] . "</td>";
                            echo "<td>" . $totalPartsPrice. "</td>";
                            echo "<td>" . $hourly_rate. "</td>";
                            echo "<td>" . $totalMechanic. "</td>";
                            echo "<td>" . $totalJobWithVat. "</td>";
                            echo "<td>".$row['customer_id']."</td>";
                            echo "<td>".$row['registration_number']."</td>";
                            echo "<td>".$row['username']."</td>";
                            echo "<td>$date_created</td>";
                            if($is_paid==0){
                            echo "<td><input class='form-check-input' type='radio' value = 'cash' checked name='payment_type' id='cash'>
                            <label class='form-check-label' for='cash'></td>";
                            echo "<td><input class='form-check-input' type='radio' value = 'card' name='payment_type' id='card'>
                            <label class='form-check-label' for='card'></td>";
                            echo "<td><input type='submit' name='pay' value='$invoice_id' /><br/>Pay</td>";
                            }
                             else
                            echo "<td>Yes on.$date_paid.</td>";
                        echo "</tr>";
                            echo "</tr>";
                    echo"</form>";           
                        }
                    } else {
                        echo "0 results";
                    }
                    
                    echo "</table>";
                    echo"
                    <button onclick=fnExcelReport7()>
                       <span class='glyphicon glyphicon-download'></span>
                       Download Report
                    </button>";
                echo "</div>";
                echo "</div>";
            }
            else{
                echo "<h3 class='my-5'>Completed Jobs</h1>";
            echo "<div class='container'>";
            echo "<div class='row-fluid'>";
                echo "<div class='col-xs-12'>";
                echo "<div class='table-responsive'>";    
                    echo "<table id='invoiceOther' class='table table-hover table-inverse'>";
                    echo "<tr>";
                    echo "<th>Job id</th>";
                    echo "<th>Job type</th>";
                    echo "<th>Status</th>";
                    echo "<th>Estimate amount</th>";
                    echo "<th>Book in date</th>";
                    echo "<th>Total with VAT</th>";
                    echo "<th>Customer Id</th>";
                    echo "<th>Registration Number</th>";
                    echo "<th>Mechanic Id</th>";
                    echo "<th>Date Created</th>";
                    echo "<th>Cash</th>";
                    echo "<th>Card</th>";
                    echo "<th>Paid</th>";
                    echo "</tr>";

                    if ($result2->num_rows > 0) {
                        // output data of each row
                        while($row = $result2->fetch_assoc()) {
                            echo"<form action = 'payInvoice.php' method='POST'>";  
                            echo "<tr>";
                            echo "<td>" . $row["job_id"] . "</td>";
                            echo "<td>" . $row["job_type"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>" . $row["estimate_amount"] . "</td>";
                            echo "<td>" . $row['book_in_date'] . "</td>";
                            if($job_type=='MoT')
                                echo "<td>66£</td>";
                            else
                                echo "<td>114£</td>";
                            echo "<td>".$row['customer_id']."</td>";
                            echo "<td>".$row['registration_number']."</td>";
                            echo "<td>".$row['username']."</td>";
                            echo "<td>$date_created</td>";
                            if($is_paid==0){
                                echo "<td><input class='form-check-input' type='radio' value = 'cash' checked name='payment_type' id='cash'>
                            <label class='form-check-label' for='cash'></td>";
                            echo "<td><input class='form-check-input' type='radio' value = 'card' name='payment_type' id='card'>
                            <label class='form-check-label' for='card'></td>";
                            echo "<td><input type='submit' name='pay' value='$invoice_id' /><br/>Pay</td>";
                            }
                             else
                            echo "<td>Yes on.$date_paid.</td>";
                            echo "</tr>";
                            echo"</form>";           
                        }
                    } else {
                        echo "0 results";
                    }
                    
                    echo "</table>";
                    echo"
                    <button onclick=fnExcelReport7()>
                       <span class='glyphicon glyphicon-download'></span>
                       Download Report
                    </button>";
                echo "</div>";
                echo "</div>";
            }

        }
        
