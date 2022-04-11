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
    <label for="discountType">Discount Type</label>
    <select reequired name="discountType"  class="form-control" required>
      <option selected disabled>Choose...</option>
      <option value='flexible'>Flexible</option>
      <option value='variable'>Variable</option>
      <option value='fixed'>Fixed</option>
      </select>
  </div>
  <div class="form-group">
    <label for="addCustomer">Add Discount to Customer</label>
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
    <label required for="discountValue">Discount Value</label>
    <input type="number" class="form-control" min= 0 max = 100 name="discountValue" placeholder="Enter discount Value">
  </div>
  <button type="submit" name='createDiscount' class="btn btn-primary">Submit</button>
</form>
<?php
if (isset($_POST['createDiscount'])) {
    $discountType = $_POST['discountType'];
    $customer_id = $_POST['addCustomer'];
    $discountValue = $_POST['discountValue'];

    $query = "INSERT INTO Discount (discount_type,value) VALUES (?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $discountType, $discountValue);

    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
    $last_id = mysqli_insert_id($conn);

    $query = "UPDATE Customer SET DiscountID = '$last_id' where customer_id = '$customer_id'";
    $result2= mysqli_query($conn, $query);
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    echo "<script language='javascript'>
    alert('Discount Plan Created')
    window.location.href='../$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}