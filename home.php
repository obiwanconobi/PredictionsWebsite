<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
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
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
      <?php


      // Change this to your connection info.
      $DATABASE_HOST = 'localhost';
      $DATABASE_USER = 'root';
      $DATABASE_PASS = '';
      $DATABASE_NAME = 'predictionsApp';
      // Try and connect using the info above.
      $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

      if ($con->connect_error){
        die("Conncetion Failed: " . $con->connect_error);
      }

      $sql = "SELECT promotion, event_name, event_date, event_id FROM pa_events";

      $result = $con->query($sql);

      if($result->num_rows > 0){
        //output data of each row
        while($row = $result->fetch_assoc()){
          $imgsource = "img/promo-logos/";
          $promotion = $row["promotion"];
          $imgfiletype = '.png';
          $b = "$imgsource$promotion$imgfiletype";
          $a = '<img src="';
          $c = '" alt="promotion-logo" width="70" height="60">';
          $imgpath = $a . $b . $c;

          $aa = "";
          $ab = $row["event_name"];
          $ac = $aa . $ab;

          $ba = "";
          $bb = $row["event_date"];
          $bc = $ba . $bb;

          $linka = 'event.php?eventId=';
          $linkb = $row["event_id"];
          $linkc = $linka . $linkb;
        //  echo '<p>Link B:</p><p>' . $linkb . '</p>';
          echo '<div class="outereventdiv"><a href="' . $linkc . '"> <div class="eventdiv"><div class="eventimagediv">' . $imgpath . '</div><div class="eventnamediv"><p>' . $ac . "</p></div>" . '<div class="eventdatediv"><p>' . $bc .  "</p></div></div></a></div>";






        }

      }

       ?>
		</div>
	</body>
</html>
