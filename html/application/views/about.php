<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=yes">
		<link rel="stylesheet" href="../../public/css/example.css">
		<title>About Us</title>
	</head>
	<body id="index">
		<div id="main-container">
			<h1>About Us</h1>
			<div id="inner-container">
				<div id="info">
					<p> Welcome to the Dungeons &amp; Dragons character sheet app. This is a helping tool designed to be a helping aid for D&amp;D campaigns where you can keep track of the most essential aspects
					found on a D&amp;D character sheet. You can create a Game master and invite users to campaigns, or you can create characters that can be invited to campaigns.</p>
					<p> Feel free to leave us a feedback regarding the app or if you encounter any problems. Please fill out all fields</p>
				</div>
				<form name="email_form" action="../controllers/sendmail.php" method="POST">
				<fieldset>
				username: <input name="user_name" type="text"><br>
				e-mail: <input name="email" type="text"/><br>
				topic: <select name="topic">
							<option value="Feedback">Feedback</option>
							<option value="Suggestions">Suggestions</option>
							<option value="Problems">Problems</option>
							</select><br>
				message:<br>
				<textarea id="message" name="message" rows="15" cols="40">
				</textarea><br>
				<input id="send" type="submit"/>
				<?php
				if(isset($_SESSION['email_errors'])) {
				$errors = array();
				$errors = $_SESSION['email_errors'];
																
				$html = '';
				$html = $html . '<div id="email_errors">' . "\n";
				$html = $html . '<p>Errors that occured:</p>' . "\n";
				$html = $html . '<ul>' . "\n";
				foreach($errors as $error) {
				$html = $html . '<li>' . $error . '</li>';
				}
				$html = $html . '</ul>' . "\n";
				$html = $html . '</div>' . "\n";
											
				$_SESSION['email_errors'] = false;
				unset($_SESSION['email_errors']);
											
				echo $html;
				}
				?>
				</fieldset>
				</form>
			</div>
		</div>
	</body>
</html>