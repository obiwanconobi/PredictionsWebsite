<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

session_start();
// Change this to your connection info.
$DATABASE_HOST = 'connerpanaro.com';
$DATABASE_USER = 'connowte_admin';
$DATABASE_PASS = 'pedersen-tugay-dunn';
$DATABASE_NAME = 'connowte_predictionsapp';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);



//check connection
if ($con->connect_error){
  die("Connection failed: " . $con->connect_error);
}

//$username = mysqli_real_escape_string($con, $_POST['username']);
$username = test_input($_POST['username']);
$email = test_input($_POST['email']);
$password = test_input($_POST['password_1']);

$sql = "INSERT INTO pa_users (username, email, password)
VALUES ('$username', '$email', '$password')";

if($con->query($sql) === TRUE){
  echo "New User Added";
}else{
  echo "Error: " . $sql . "<br />" . $con->error;
}

$con->close();
 ?>
