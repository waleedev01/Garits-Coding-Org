<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
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
        <h2 class="my-5">Upload Backup</h2>

    <meta charset="UTF-8">

<?php
//form to get the path of the file to restore
echo"<form action='' method='post' enctype='multipart/form-data'>
<input type='file' name='file'>
<input type='submit' name='restore'>
</form>";


if(isset($_POST['restore'])){
    $dbhost = '127.0.0.1';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'Garits';
    //path where the restore file is saved
    $path= $_FILES["file"]["name"];
    $mysqlImportPath = '/Users/Waleed/db_backups/'.$path;
    $sql = file_get_contents($mysqlImportPath);

    $mysqli = new mysqli("localhost", "root", "", "Garits");

    //executes all the queries inside the file
    $mysqli->multi_query($sql);

    echo "<script language='javascript'>
    alert('Backup Restored');
    window.location.href = '../$role.php';
    </script>";
}


?>