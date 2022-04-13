<?php
// Initialize the session and check if the user is logged in
session_start();
require_once "../config.php";
$username = $_SESSION['username'];
$role = $_SESSION['role'];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
      <!-- Page Heading and Title-->
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <h2 class="my-5">Create Customer </h2>

    <p>
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <!-- Form with input labels-->
    <form action='' method='post'>
        <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control"  name="inputEmail" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
        <label for="companyName">Company name</label>
        <input type="text" class="form-control" name="companyName" placeholder="Company name">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="name">Name</label>
        <input type="text" class="form-control" required name="name" placeholder="Name">
        </div>
        <div class="form-group col-md-6">
        <label for="surname">Surname</label>
        <input type="text" class="form-control" required name="surname" placeholder="Surname">
        </div>
    </div>
    <div class= form-row>
    <div class="form-group col-md-6">
        <label for="address">Address</label>
        <input type="text" class="form-control" required name="address" placeholder="address">
      </div>
      <div class="form-group col-md-6">
        <label for="postcode">Post code</label>
        <input type="text" class="form-control" required name="postcode" placeholder="Post code">
      </div>
      <div class="form-group col-md-6">
        <label for="city">City</label>
        <input type="text" class="form-control" required name="city" placeholder="city">
      </div>
      <div class="form-group col-md-6">
        <label for="mobileNumber">Mobile number</label>
        <input type="text" class="form-control"  name="mobileNumber" placeholder="Mobile Number">
      </div>
      <div class="form-group col-md-6">
        <label for="telephoneNumber">Telephone number</label>
        <input type="text" class="form-control"  name="telephoneNumber" placeholder="Telephone number">
      </div>
    </div>
    <div class="form-group col-md-6">
    <label for="customerType">Customer Type</label>
        <select name="customerType"  class="form-control" required>
            <option disabled>Choose...</option>
            <option value="normal">Occasional</option>
            <option value="holder">Account Holder</option>
        </select>
    </div>
    </div>
    <button type="submit" name = "createAccount" class="btn btn-primary">Create Account</button>
  <form>
<?php
//check if the form has been submitted
if (isset($_POST['createAccount'])) {
  //get attributes value
    $companyName = $_POST['companyName'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['inputEmail'];
    $telephoneNumber = $_POST['telephoneNumber'];
    $mobileNumber = $_POST['mobileNumber'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $address = $_POST['address'];
    $customerType = $_POST['customerType'];
    $discountId = null;
    $payLate = null;
    //make insert into query
    $query = "INSERT INTO Customer (company_name,name,surname,address,post_code,city,mobile_telephone,home_telephone,email,pay_late,DiscountID) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssssssii',$companyName,$name,$surname,$address,$postcode,$city,$mobileNumber,$telephoneNumber,$email,$payLate,$discountId);
    /* Execute the statement */
    $stmt->execute();
    $row = $stmt->affected_rows;
    $last_id = $conn->insert_id;

    //if customer has an account then a new record is created in the AccountHolder table
    if($customerType=='holder'){
      $query = "INSERT INTO AccountHolder (customer_id,pay_late) VALUES (?,?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('ii',$last_id,$payLate);
      /* Execute the statement */
      $stmt->execute();
      $row = $stmt->affected_rows;
    }
    //alert
    echo "<script language='javascript'>
    alert('Account Created')
    </script>";
    echo "<meta http-equiv='refresh' content='0'>";

}