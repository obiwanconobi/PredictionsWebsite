<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$eventId = $_GET['eventId'];
$_SESSION['event_id_1'] = $eventId;
$user_id = $_SESSION['user_id'];


$DATABASE_HOST = 'panaro.uk';
$DATABASE_USER = 'root';
$DATABASE_PASS = '68p$t?x0V_';
$DATABASE_NAME = 'predictionsApp';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ($con->connect_error){
  die("Conncetion Failed: " . $con->connect_error);
}

$sql = "SELECT event_name FROM pa_events WHERE event_id = $eventId";

$result = $con->query($sql);

if($result->num_rows > 0){
  //output data of each row
  while($row = $result->fetch_assoc()){
    $eventname = $row["event_name"];
  }
}

 ?>


 <script>

//used to identify empty option boxes

 $('.dropdown-option span:empty').parent().hide()
 </script>


 <!DOCTYPE html>
 <html>
 	<head>
 		<meta charset="utf-8">
 		<title>Profile Page</title>
 		<link href="style.css" rel="stylesheet" type="text/css">
 		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<style>

		</style>
	 	</head>
 	<body class="loggedin">
 		<nav class="navtop">
 			<div>
 				<h1>Website Title</h1>
         <a href="home.php"><i class='fas fa-home' style='font-size:16px'></i>Home</a>
 				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
 				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
 			</div>
 		</nav>
 		<div class="content">
 			<h2><?php echo $eventname; ?></h2>
 			<div class="outerboutdiv">
          <form method="post" action="selections.php">
        <?php

        $sql2 = "SELECT match_id, stipulation, participant1, participant2, participant3 FROM pa_bout WHERE event_id = $eventId";
				$sql3 = "SELECT event_date FROM pa_events WHERE event_id = $eventId";

				$result3 = $con->query($sql3);
				$count = 1;
        if($result3->num_rows > 0){

						while($row = $result3->fetch_assoc()){
							$event_date = $row["event_date"];
						}



				}

				date_default_timezone_set('Europe/London');
				$currentdate = date('Y-m-d', time());

				//Checks if the event has run by checking event_date with current date
			//	echo $event_date;
		//		echo $date;



				$result2 = $con->query($sql2);
				$count = 1;
				if($result2->num_rows > 0){
					//output data of each row
					while($row = $result2->fetch_assoc()){

						$participant1 = $row["participant1"];
						$participant2 = $row["participant2"];
						$participant3 = $row["participant3"];
						$match_id = $row["match_id"];

						$_SESSION['match_'. $count] = $match_id;
						$count++;
						$_SESSION['count'] = $count;

						echo '<div class="boutdiv">    <select name="' . $match_id .  '" class="select-winner" id="winner">
							 <option value="' . $participant1 .  '">' . $participant1 . '</option>
							 <option value="' . $participant2 .  '">' . $participant2 . '</option>
							 <option value="' . $participant3 .  '">' . $participant3 . '</option>

							 </select>
							</div>';
						//  echo '<p>' . $_SESSION['match_'. $count]. '</p>';
				}
				}



         ?>

         <input type="submit" value="submit">
         </form>
 			</div>
			<div class="outerresultsdiv">
				<div class="selectionname" style="color:red;">
					<h2>Selection</h2>
				</div>
				<div class="selectionresult">
					<h2>Result</h2>
				</div>
				<?php

				if ($event_date < $currentdate){

					echo '<style>.outerboutdiv{display:none!important;}.outerresultsdiv{display:grid;}</style>';

					$sql4 = "SELECT match_selection, selection_correct FROM pa_predictions WHERE event_id = $eventId AND user_id = $user_id";
					$result4 = $con->query($sql4);
					$count = 1;
					if($result4->num_rows > 0){
						while($row = $result4->fetch_assoc()){
							$matchresult1 = $row["match_selection"];
							$matchresult2 = $row["selection_correct"];

							if($matchresult2 = 1){
								$correctincorrect = "Correct";
							}else{
								$correctincorrect = "Incorrect";
							}

							echo '<div class="selectionname"><h2>' . $matchresult1 . '</h2></div><div class="selectionresult"><h2>' . $correctincorrect . '</h2></div>';
						}
					}


				}else{
				echo 	'<style>.outerboutdiv{display:grid!important;}.outerresultsdiv{display:none!important;}</style>';
				//	$style = '.outerboutdiv{display:block!important;.outerresultsdiv{display:none!important;}';
				}


				 ?>

			</div>
 		</div>
 	</body>
 </html>
