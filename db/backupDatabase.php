<?php
session_start();
require_once "../config.php";
$username = $_SESSION['username'];
$role = $_SESSION['role'];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$dbname = 'Garits';
$mysqlExportPath ='backup.sql';

//Export of the database and output of the status


$command = "/Applications/xampp/xamppfiles/bin/mysqldump -u $dbuser -h localhost -p$dbpass $dbname > $mysqlExportPath";
exec($command, $output);
echo "<script language='javascript'>
alert('Backup created');
window.location.href = '../$role.php';
</script>";

?>