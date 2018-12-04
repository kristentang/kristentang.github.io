#!/usr/local/bin/php
<?php
	$email = $_GET['email'];
	$token = $_GET['token'];
	$fields = array();
	$unvalidated_string = "";

	$file = fopen('unvalidated.txt', 'r') or die('could not open file'); // store emails of unvalidated users - email address, hashed password, hashed validation token
	while(!feof($file)) { // while still more of file to read
		$line = fgets($file);
		$fields[] = explode("\n", $line);
	}
	for ($x = 0; $x <= sizeof($fields)-1; $x++) {
		$entries = explode(" ", $fields[$x][0]);
		if ($entries[0]===$email) { // if email matches email from unvalidated.txt
			if ($token===trim($entries[1])) { // and if corresponding password matches corresponding password from unvalidated.txt
				$validated_string = ($fields[$x][0]."\n"); // add line to string of information to add to validated.txt
			}
		} else { // if email and password information does not match line
			$unvalidated_string = $unvalidated_string . ($fields[$x][0]."\n"); // add line to string of information to keep in unvalidated.txt
		}

	}
	fclose($file);

	$file = fopen('unvalidated.txt', 'w') or die('could not open file'); // store emails of unvalidated users - email address, hashed password, hashed validation token
	fwrite($file, $unvalidated_string);
	fclose($file);

	$file = fopen('validated.txt', 'a') or die('could not open file'); // store emails of validated users - email address, hashed password, hashed validation token
	fwrite($file, $validated_string);
	fclose($file);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kristen Tang</title>
  <meta charset = "UTF-8">
  <link rel="stylesheet" href="final.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma:light|Lovers+Quarrel|Roboto:thin|Open+Sans+Condensed:300|Open+Sans:300|Lora">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<header>
		<div class="topnav">
				<div class = "dropdown">
					<a href = "" class= "active">PLAY</a>
				</div>
				<div class = "dropdown">
					<a href = "" class= "active">LEADERBOARD</a>
				</div>
		</div>

		<div class = "banner_out">
			<p></p>
		</div>

		<div class = "banner_in">
			<br><br><br><br>
			<p1>BALLOON&nbsp;&nbsp;&nbsp;POP</p1>
			<br><br><br><br><br>
		</div>
	</header>
	<main>
		<h1>Thank you for registering.
		<center><button class="button" onclick="location.href='index.php'" target = "_blank" rel="noopener">Log In Page</button></center>
		</h1>
	</main>
	<footer>
		<br>
		<small>
			&copy; This website was created by Kristen Tang and last updated on December 10, 2018.
			<br><br>
			Photos by <a href = "https://www.pexels.com/@spemone-62171" target = "_blank" rel = "noopener">spemone</a> on <a href = "https://www.pexels.com" target = "_blank" rel = "noopener">Pexels</a> and <a href = "https://unsplash.com/photos/zvBT4eOtlkY?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText" target = "_blank" rel = "noopener">Carl Raw</a> on <a href = "https://unsplash.com" target = "_blank" rel = "noopener">Unsplash</a>.
		</small>
		<br>
	</footer>
</body>
</html>
