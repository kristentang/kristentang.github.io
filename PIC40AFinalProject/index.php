#!/usr/local/bin/php
<?php
	session_start(); // start a session
	$_SESSION['output_message'] = ''; // message updated based on user input
	$_SESSION['user'] = 'kristen'; // message updated based on user input

	function validate_registration($email, $password, $username) {
	// 	try { // attempt to establish connection
	//     $mydb = new SQLite3('validated.db');
	//   }
	//   catch(Exception $ex){ // may throw
	//     echo $ex->getMessage();
	//   }
	//
	// 	$statement = 'DROP TABLE IF EXISTS validated;';
	//   $run = $mydb->query($statement);
	//
	// 	$statement = 'CREATE TABLE IF NOT EXISTS validated (username TEXT, email TEXT, password TEXT, highscore INTEGER);';
	// 	$run = $mydb->query($statement);
	//
	// 	$statement = "INSERT INTO schedule (username, password) VALUES ($username, $password);";
	//   $run = $mydb->query($statement); // run the command
	//
	// 	if($run) { // so no errors in the query
	// 		while($row = $run->fetchArray()) { // while still a row to parse
	// 			echo "<script>console.log($row['email'], '--', $row['password']); </script>";
	// 		}
	// 	}
	// }

		$file = fopen('validated.txt', 'r') or die('could not open file'); // store emails of unvalidated users - email address, hashed password, hashed validation token
		$registered = 0; // 0 if user has not already registerd (is on validated list), 1 if user has already registered
		$password_match = 0; // 0 if password does not match to email, 1 if token does not match to email

		$my_rand = rand(100, 50000); // generate random number for token
		$token = hash('md2', $my_rand); // hash random number to create token
		$password_hash = hash('md2', $password); // hash password
		$fields = array();

		while(!feof($file)) { // while still more to read
			$line = fgets($file); // reads every line and stores in $fields array
			$fields[] = explode("\n", $line);
		}
		$num_lines = sizeof($fields)-1;
		for ($x = 0; $x <= $num_lines; $x++) { // look through every line in $fields array
			$entries = explode(" ", $fields[$x][0]); // individual entries in line seprated by a space
			if ($entries[3]==$username) { // if email user input is in unvalidated.txt, flag	$registered
				$registered = 1;
				if ($password_hash==trim($entries[2])) { // if password associated with email is in unvalidated.txt, flag	$password_match
					$password_match = 1;
				}
			}

		}
		fclose($file);

		if ($registered == 1) { // if they are already registered (email in validated.txt)
			$_SESSION['output_message'] = 'Already registered. Please log in.'; // error message asks them to log in
		} else { // otherwise if new user
			$subject_line = "Validation for Balloon Pop";
			$link = 'http://pic.ucla.edu/~kristentang/Final_Project/validate.php?email=' . $email . '&token=' . $token;
			$message = 'Validate by clicking here: ' . $link;
			$message = wordwrap($message, 70, "\r\n");
			mail($email, $subject_line, $message);
			$_SESSION['output_message'] = 'A validation email has been sent to: '. $email. '. Please follow the link.'; // create and send an email message for user to validate
			$file = fopen('unvalidated.txt', 'a') or die('could not open file'); // store emails of unvalidated users - email address, hashed password, hashed validation token
			fwrite($file, $email." ".$token." ".$password_hash." ".$username."\n");
			fclose($file);
		}


	} // end or function validate()

	function validate_login($username, $password) {
		$file = fopen('validated.txt', 'r') or die('could not open file'); // store emails of unvalidated users - email address, hashed password, hashed validation token
		$registered = 0; // 0 if user has not already registerd (is on validated list), 1 if user has already registered
		$password_match = 0; // 0 if password does not match to email, 1 if token does not match to email

		$my_rand = rand(100, 50000); // generate random number for token
		$token = hash('md2', $my_rand); // hash random number to create token
		$password_hash = hash('md2', $password); // hash password
		$fields = array();

		while(!feof($file)) { // while still more to read
			$line = fgets($file); // reads every line and stores in $fields array
			$fields[] = explode("\n", $line);
		}
		$num_lines = sizeof($fields)-1;
		for ($x = 0; $x <= $num_lines; $x++) { // look through every line in $fields array
			$entries = explode(" ", $fields[$x][0]); // individual entries in line seprated by a space
			if ($entries[3]==$username) { // if email user input is in unvalidated.txt, flag	$registered
				$registered = 1;
				if ($password_hash==trim($entries[2])) { // if password associated with email is in unvalidated.txt, flag	$password_match
					$password_match = 1;
				}
			}

		}
		fclose($file);

		if (($registered == 1) && ($password_match == 1)) { // if they are already registered (email in validated.txt) and input the correct password
			$new_url = 'main.php?username=' . $username."&token=".$token;
			header("Location: $new_url"); // send to welcome page

		} else if ($registered == 1){ // if they are already registered (email in validated.txt) by input an incorrect password
			$_SESSION['output_message'] = 'Your password is invalid.'; // Error message for invalid password

		} else { // if not already registered (email not in validated.txt)
			$_SESSION['output_message'] = 'No such email address. Please register or validate.'; // error message to register or validate their email address
		}

	} // end or function validate()

	if (isset($_POST['username'])) { // if something email field filled out
		if (isset($_POST['password'])) { // and if password field filled out
			if (isset($_POST['email'])) { // and if password field filled out
				validate_registration($_POST['email'], $_POST['password'], $_POST['username']); // run through validate() function using email field and password field input
			} else {
				validate_login($_POST['username'], $_POST['password']); // run through validate() function using email field and password field input
			}
		}
	}

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
		<br><br>
		<div class = "two_elements">
			<div class="card_2">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h2>Returning?<br>Login In:</h2>
					<div class = "border">
						<label for="username">Username: </label>
						<input type="username" name="username" pattern = "[A-z, 0-9]{6,}"/>
						<br>
						<label for="password">Password: </label>
						<input type="text" name="password" pattern = "[A-z, 0-9]{6,}"/>
					</div>
					<br>
					<input type="submit" value="Log In" name = "login" class = "button"/><br><br>
					<br>
				</form>
			</div>
			<div class="card_2">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h2>New?<br>Make An Account:</h2>
					<div class = "border">
						<label for="email">Email: </label>
						<input type="email" name="email" pattern = ".+@.+"/>
						<br>
						<label for="username">Username (at least than 6 letters or digits): </label>
						<input type="username" name="username" pattern = "[A-z, 0-9]{6,}"/>
						<br>
						<label for="password">Password (at least than 6 letters or digits): </label>
						<input type="text" name="password" pattern = "[A-z, 0-9]{6,}"/>
					</div>
					<br>
					<input type="submit" value="Register" name = "register" class = "button"/><br><br>
					<br>
				</form>
			</div>
		</div>
		<h2 id = "output_message"> <?php echo $_SESSION['output_message']  ?></h2>
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
