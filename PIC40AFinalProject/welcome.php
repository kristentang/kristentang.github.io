#!/usr/local/bin/php
<!DOCTYPE html>
<html>
<head>
	<title>Homework 5</title>
	<meta charset = "UTF-8">
	 <link rel="stylesheet" href="HW5.css">

</head>
<body>
	<main>
		<?php
			$email = $_GET['email'];
			echo "Welcome. Your email address is " . $email . "."; // personal welcome based on user email address
		?>
		<br>
		<p>Here is a list of all registered users: <?php
					$file = fopen('validated.txt', 'r') or die('could not open file'); // store emails of validated users - email address, hashed password, hashed validation token
					$found = 0;
					$fields = array();
					while(!feof($file)) { // while still more to read
						$line = fgets($file);
						$fields[] = explode("\t", $line);
					}
					for ($x = 0; $x <= sizeof($fields)-2; $x++) {
						$entries = explode(" ", $fields[$x][0]);
						echo nl2br($entries[0] . " "); // list other users
					}

		?></p>

		<br>
		<a href = 'logout.php'><input id = "button" type = "button" value = "logout" /></a>

	</main>
</body>
</html>
