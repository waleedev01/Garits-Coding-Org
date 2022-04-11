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
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <meta charset="UTF-8">

<?php
if (isset($_POST['update'])) {
    $pick_job_id = $_POST['update'];   
}
    $query = "SELECT customer_id,name,surname FROM Customer";
    $resultCustomers = $conn->query($query);

    $query = "SELECT item_id,part_name FROM Stock";
    $resultParts = $conn->query($query);
?>
<form action = '' method = 'get'>
  
    <div class="form-group">
    <label for="name">Select user</label>
    <select name="name" required class="form-control" required>
      <option selected disabled>Choose...</option>
    <?php 
    while($row = $resultCustomers->fetch_assoc()) {
      echo "<option value=$row[customer_id]>$row[name] $row[surname]</option>";
    }
    ?>  </select>
    </select>
  </div>  
    <div class="form-group">
    <label for="addStock">Add Part</label>
    <select name="addStock" required class="form-control" required>
      <option selected disabled>Choose...</option>
    <?php 
    while($row = $resultParts->fetch_assoc()) {
      echo "<option value=$row[item_id]>$row[part_name]</option>";
    } 
    ?>
    </select>
    </select>
  </div>
  <button type="submit" name='stockOrder' class="btn btn-primary">Submit</button>
</form>

<?php

if (isset($_GET['stockOrder'])) {
    $customer_id = $_GET['name'];
    $item_id = $_GET['addStock'];
    $job_type = 'stock_order';
    $status = 'completed';
    $estimate_amount = null;
    $book_in_date = null;
    $time_spent = null;
    $registration_number = null;
    $username = null;

    $query = "INSERT INTO Job (job_type,status,estimate_amount,book_in_date,time_spent,customer_id,registration_number,username) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssdsdiss', $job_type, $status,$estimate_amount,$book_in_date,$time_spent,$customer_id,$registration_number,$username);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;

    $last_id = mysqli_insert_id($conn);
    
    $query = "INSERT INTO Stock_used (job_id,item_id,date_used) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $date = date("Y-m-d");
    $stmt->bind_param('iis', $last_id, $item_id,$date);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
   
    $query_stock_quantity = "SELECT quantity FROM Stock WHERE item_id = '$item_id'";
    $res_stock= mysqli_query($conn,$query_stock_quantity) or die(mysql_error());
    while ($row = mysqli_fetch_assoc($res_stock)) 
            $quantity = $row['quantity'];
    $newQuantity = $quantity-1;
    $query = "UPDATE Stock SET quantity = '$newQuantity' where item_id = '$item_id'";
    $result = mysqli_query($conn, $query);

    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Stock Order Created')
    window.location.href='../$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}