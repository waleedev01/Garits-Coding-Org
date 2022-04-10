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
    $query = "SELECT * FROM Customer";
    $resultCustomers = $conn->query($query);
?>
<form action = '' method = 'post'>
  <div class="form-group">
    <label for="addCustomer">Choose customer</label>
    <select name="addCustomer"  class="form-control" required>
      <option selected disabled>Choose...</option>
    <?php 
    while($row = $resultCustomers->fetch_assoc()) {
      echo "<option value=$row[customer_id]>$row[name] $row[surname]</option>";
    } 
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="payLate">Can pay late?</label>
    <select  name="payLate"  class="form-control" required>
      <option selected disabled>Choose...</option>
      <option value=1>Yes</option>
      <option value=0>No</option>
      </select>
  </div>
 
  <button type="submit" name='payLateConfiguration' class="btn btn-primary">Submit</button>
</form>
<?php
if (isset($_POST['payLateConfiguration'])) {
    $payLate = $_POST['payLate'];
    $customer_id = $_POST['addCustomer'];

    $query = "UPDATE Customer SET pay_late='$payLate' where customer_id = '$customer_id'";
    $result= mysqli_query($conn, $query);
    if ($row > 0) { 
        echo "<script language='javascript'>
        alert('Pay late configured');";
    }

}