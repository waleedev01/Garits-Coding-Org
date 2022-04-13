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
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <meta charset="UTF-8">

<?php
    $query = "SELECT * FROM Customer";//select all the customers for the dropdown menu
    $resultCustomers = $conn->query($query);
?>
<!-- Form for gettin the customer id and the pay late configuration-->
<form action = '' method = 'post'>
  <div class="form-group">
    <label for="addCustomer">Choose customer</label>
    <select name="addCustomer"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
    <?php 
    while($row = $resultCustomers->fetch_assoc()) {//dropdown menu
      echo "<option value=$row[customer_id]>$row[name] $row[surname]</option>";
    } 
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="payLate">Can pay late?</label>
    <select  name="payLate"  class="form-control" required>
      <option selected disabled value="">Choose...</option>
      <option value=1>Yes</option>
      <option value=0>No</option>
      </select>
  </div>
 
  <button type="submit" name='payLateConfiguration' class="btn btn-primary">Submit</button>
</form>
<?php
//if form has been submitted
if (isset($_POST['payLateConfiguration'])) {
    $payLate = $_POST['payLate'];
    $customer_id = $_POST['addCustomer'];
    //update the customre paylate column
    $query = "UPDATE Customer SET pay_late='$payLate' where customer_id = '$customer_id'";
    $result= mysqli_query($conn, $query);
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Pay late option configured')
    window.location.href='../$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}