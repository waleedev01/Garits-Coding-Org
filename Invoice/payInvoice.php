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
//if pay button has been clicked
if (isset($_POST['pay'])) {//get the invoice id and payment type (cash or card)
    $invoice_id = $_POST['pay'];
    $payment_type = $_POST['payment_type'];
}
$today = date("Y-m-d");
//query to update the invoice table, set that invoice has been paid and the date
$query3 = "UPDATE Invoice SET is_paid = '1', date_paid = '$today' where invoice_id = '$invoice_id'";
$result3 = mysqli_query($conn, $query3);
//create payment record
$query = "INSERT INTO Payment (invoice_id,payment_type,date_paid) VALUES (?,?,?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iss', $invoice_id, $payment_type,$today);
/* Execute the statement */
$stmt->execute();
$row = $stmt->affected_rows;


echo "<script language='javascript'>
alert('Payment recorded ')
window.location.href='produceInvoice.php';
</script>";
echo "<meta http-equiv='refresh' content='0'>";
 

?>