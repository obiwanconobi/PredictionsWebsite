<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

function test_input($data) {

  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$user_id = $_SESSION['user_id'];

$event_id = $_SESSION['event_id_1'];

// Change this to your connection info.
$DATABASE_HOST = 'panaro.uk';
$DATABASE_USER = 'root';
$DATABASE_PASS = '68p$t?x0V_';
$DATABASE_NAME = 'predictionsApp';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($con->connect_error){
  die("Connection failed: " . $con->connect_error);
}
$x = 1;

//$match1 = ${"_SESSION['match_" . $x . "']"};
while($x <= $_SESSION['count']){
  //checks if the session match_number is set
  $tempvar1 = isset($_SESSION['match_' . $x]);
    if($tempvar1){
      $match_id = $_SESSION["match_" . $x];

      $selection = test_input($_POST[$match_id]);
    }

  $sql = "SELECT match_selection FROM pa_predictions WHERE user_id=$user_id AND match_id=$match_id";
  $result = $con->query($sql);

  if($result->num_rows > 0){
    //output data of each row
    while($row = $result->fetch_assoc()){

      $sql1 = "UPDATE pa_predictions SET match_selection='$selection' WHERE user_id='$user_id' AND match_id='$match_id'";
      if($con->query($sql1) === TRUE){
			  echo "Predictions Updated";
      }else{
        echo "Error: " . $sql1 . "<br />" . $con->error;
      }

    }
  }ELSE{
    $sql2 = "INSERT INTO pa_predictions (user_id, match_id, event_id, match_selection)
     VALUES ('$user_id', '$match_id', '$event_id', '$selection')";

     if($con->query($sql2) === TRUE){
       echo "Predictions Added";
     }else{
       echo "Error: " . $sql2 . "<br />" . $con->error;
     }
  }



  $x++;
}
sleep(5);
header('Location: selectionsupdated.php');
echo '<p>' . $event_id . '</p>'
/*IF EXISTS (SELECT * FROM pa_predictions
WHERE custid=@custid AND dayofweek=@dayofweek)
UPDATE pa_predictions
SET datebackup=@datebackup
WHERE custid=@custid AND dayofweek=@dayofweek
ELSE INSERT INTO tblbackupdata (custid, dayofweek, datebackup) VALUES (@custid, @dayofweek, @datebackup)", Conn);

SELECT IF ( EXISTS (SELECT ALL FROM pa_predictions WHERE user_id='$user_id' AND match_id='$match_id') UPDATE pa_predictions SET match_selection='$selection'
WHERE user_id='$user_id' AND match_id='$match_id'
ELSE
*/

?>
