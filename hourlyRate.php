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
    $query = "SELECT * FROM Mechanic";//select all mechanics
    $resultMec = $conn->query($query);
?>
<form action = '' method = 'post'><!-- Form for assigning a hourly rate to a mechanic -->
  <div class="form-group">
    <label for="chooseMec">Choose Mechanic</label>
    <select name="chooseMec"  class="form-control" required>
    <option selected required disabled>Choose...</option>
    <?php 
    while($row = $resultMec->fetch_assoc()) {
      echo "<option value=$row[username]>$row[username]</option>";
    } 
    ?>
    </select>
  </div>
  <div class="form-group">
        <label for="hourlyRate">Hourly Rate</label>
        <input type="number" class="form-control"  min=1 name="hourlyRate" required placeholder="Hourly Rate">
  </div>
 
  <button type="submit" name='addHourlyRate' class="btn btn-primary">Submit</button>
</form>
<?php

//if form has been submitted
if (isset($_POST['addHourlyRate'])) {
    $username = $_POST['chooseMec'];
    $hourlyRate = $_POST['hourlyRate'];

    $query = "UPDATE Mechanic SET hourly_rate='$hourlyRate' where username = '$username'";//update the hourly rate column
    $result= mysqli_query($conn, $query);
    $location="$role.php"; // If role is admin this will be admin.php, if receptionist this will be receptionist.php and more.
    echo "<script language='javascript'>
    alert('Hourly rate recorded')
    window.location.href='$location';
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}