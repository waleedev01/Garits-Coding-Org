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
$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$dbname = 'Garits';
date_default_timezone_set('Europe/London');

$date = date('Y-m-d-H-i-s');
//path where the back up will be exported
$mysqlExportPath ='/Users/Waleed/db_backups/garits_backup_'.$date.'.sql';
//mysql dump for saving the backup
$command = "/Applications/xampp/xamppfiles/bin/mysqldump -u $dbuser -h localhost -p$dbpass $dbname > $mysqlExportPath";
exec($command, $output);
echo "<script language='javascript'>
alert('Backup created');
window.location.href = '../$role.php';
</script>";

?>