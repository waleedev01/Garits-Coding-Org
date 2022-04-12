<?php
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
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="<?php echo $role ?>.php" class="btn btn-info ml-3">Open Dashboard</a>
        <a href="vehicle/searchVehicle.php" class="btn btn-secondary ml-3">Vehicle list</a>

        <?php
        /*
            $query = "SELECT job_id,job_type,status,book_in_date,customer_id,registration_number FROM Job where status = 'pending' AND username != '$username'"; //You don't need a ; like you do in SQL
            $result = mysqli_query($conn, $query);
        echo "<h3 class='my-5'>You can pick a job from this list</h1>";
        echo "<div class='container'>";
        echo "<div class='row-fluid'>";
        
            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";
            
                echo "<table class='table table-hover table-inverse'>";
                
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Job Type</th>";
                echo "<th>Status</th>";
                echo "<th>Book in date</th>";
                echo "<th>Registration number</th>";
                echo "<th>Customer id</th>";
                echo "<th> Pick Job</th>";
                echo "</tr>";
          
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo"<form action = '' method='POST'>";  
                        echo "<tr>";
                        echo "<td>" . $row["job_id"] . "</td>";
                        echo "<td>" . $row["job_type"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["book_in_date"] . "</td>";
                        echo "<td>" . $row['registration_number'] . "</td>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td><input type='submit' name='pick' value='" . $row['job_id'] . "' /><br/></td>";
                        echo "</tr>";
                        echo"</form>";           
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";
*/
            /*
             * second table
             */
            $query = "SELECT job_id,job_type,status,book_in_date,customer_id,registration_number,time_spent FROM Job where username ='$username'"; //You don't need a ; like you do in SQL
            $result = mysqli_query($conn, $query);
            echo "<h3 class='my-5'>Update one of your existing jobs</h1>";

            echo "<div class='col-xs-12'>";
            echo "<div class='table-responsive'>";
            
                echo "<table class='table table-hover table-inverse'>";
                
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Job Type</th>";
                echo "<th>Status</th>";
                echo "<th>Book in date</th>";
                echo "<th>Time spent</th>";
                echo "<th>Registration number</th>";
                echo "<th>Customer id</th>";
                echo "<th> Update Job</th>";
                echo "</tr>";
          
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo"<form action = 'editJob.php' method='POST'>";  
                        echo "<tr>";
                        echo "<td>" . $row["job_id"] . "</td>";
                        echo "<td>" . $row["job_type"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["book_in_date"] . "</td>";
                        echo "<td>" . $row['time_spent'] . "</td>";
                        echo "<td>" . $row['registration_number'] . "</td>";
                        echo "<td>" . $row['customer_id'] . "</td>";
                        echo "<td><input type='submit' name='update' value='" . $row['job_id'] . "' /><br/></td>";
                        echo "</tr>";  
                        echo "</form>";         
                    }
                } else {
                    echo "0 results";
                }
                
                echo "</table>";
    
            echo "</div>";
            echo "</div>";

        echo "</div>";
        
    echo "</div>";
    if (isset($_POST['pick'])) {
        $pick_job_id = $_POST['pick'];
        $pick_job_query = "UPDATE Job SET username = '$username'WHERE job_id = '$pick_job_id'";
        $result = mysqli_query($conn, $pick_job_query);
        echo "<meta http-equiv='refresh' content='0'>";
    }
?>


    </p>
</body>
</html>