<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$DATABASE_HOST = 'smcse-stuproj00.city.ac.uk';
$DATABASE_USER = 'in2018t12';
$DATABASE_PASS = '35VPanSH';
$DATABASE_NAME = 'in2018t12';

/* Attempt to connect to MySQL database */
$conn = mysqli_connect("127.0.0.1", "root", "", "Garits");
if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>