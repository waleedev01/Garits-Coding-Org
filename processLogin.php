<?php
//Code from lab sample solution
if(!isset($_SESSION)) {
    session_start(); 
}
require_once "config.php";

$username = $conn->real_escape_string($_POST["username"]);
$password = $conn->real_escape_string($_POST["password"]);
$hashed_login = md5($password);

$query_username = "SELECT username FROM Staff WHERE username = '$username'";
$res_username = mysqli_query($conn, $query_username);
$query = "SELECT username,password,role FROM Staff WHERE username = '$username' AND password = '$hashed_login'";
// execute the query
$result = $conn->query($query);
// store the results in $row variable
$row = mysqli_fetch_row($result);


if (!isset($row[0] ) || !isset($row[1])) {
    if(mysqli_num_rows($res_username) > 0){//code by me to check if the username exists
        echo "<script language='javascript'>
                alert('Incorrect Password');
                window.location.href = 'login.php';
              </script>";
    }
    else{
        echo "<script language='javascript'>
                alert('Please enter valid credentials.');
                window.location.href = 'login.php';
              </script>";
    }
}
else{
    $query_role = "SELECT role FROM Staff WHERE username = '$username'";
    $res_role= mysqli_query($conn,$query_role) or die(mysql_error());
    while ($row = mysqli_fetch_assoc($res_role)) 
            $role = $row['role'];

    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    $_SESSION["loggedin"] = true;
    $location="$role.php"; // If role is admin this will be admin.php, if student this will be student.php and more.
    header("location: $location"); 
}
?>
