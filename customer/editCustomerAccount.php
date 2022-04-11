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

$query = "SELECT * FROM Customer";
$resultCust = $conn->query($query);
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
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to GARITS.</h1>
    <p>
        <a href="../logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="../<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
    <form action='' method='post'>
    <div class="form-group">
    <label for="CustomerID">Choose Customer</label>
    <select required name="CustomerID"  class="form-control" >
      <option selected disabled>Choose...</option>
    <?php 
    while($row = $resultCust->fetch_assoc()) {
      echo "<option value=$row[customer_id]>$row[name] $row[surname]</option>";
    } 
    ?>
    </select>
</div>
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
        <input type="text" class="form-control"  name="name" placeholder="Name">
        </div>
        <div class="form-group col-md-6">
        <label for="surname">Surname</label>
        <input type="text" class="form-control"  name="surname" placeholder="Surname">
        </div>
    </div>
    <div class= form-row>
    <div class="form-group col-md-6">
        <label for="address">Address</label>
        <input type="text" class="form-control"  name="address" placeholder="address">
      </div>
      <div class="form-group col-md-6">
        <label for="postcode">Post code</label>
        <input type="text" class="form-control"  name="postcode" placeholder="Post code">
      </div>
      <div class="form-group col-md-6">
        <label for="city">City</label>
        <input type="text" class="form-control"  name="city" placeholder="city">
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
    <button type="submit" name = "createAccount" class="btn btn-primary">Edit Account</button>
  <form>
<?php
if (isset($_POST['createAccount'])) {
    $customer_id = $_POST['CustomerID'];
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

    if($companyName!=null){
      $query = "UPDATE Customer SET company_name = '$companyName' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($name!=null){
      $query = "UPDATE Customer SET name = '$name' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($surname!=null){
      $query = "UPDATE Customer SET surname = '$surname' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($email!=null){
      $query = "UPDATE Customer SET email = '$email' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($mobileNumber!=null){
      $query = "UPDATE Customer SET mobile_telephone = '$mobileNumber' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($telephoneNumber!=null){
      $query = "UPDATE Customer SET home_telephone = '$telephoneNumber' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($city!=null){
      $query = "UPDATE Customer SET city = '$city' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($postcode!=null){
      $query = "UPDATE Customer SET post_code = '$postcode' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($address!=null){
      $query = "UPDATE Customer SET address = '$address' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    if($customerType!=null){
      if($customerType=='holder')
      $query = "DELETE FROM AccounHolder where customer_id = '$customer_id' where customer_id='$customer_id'";
      $result = mysqli_query($conn, $query);
    }

    echo "<script language='javascript'>
    alert('Account Updated')
    </script>";
       
}