<?php
/**
 * A file representing the view for the DND Helper register page
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();

require_once '../configs/config.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/register.css"/>
    <title>DND Helper</title>
  </head>
  <body id="register">
    <div id="main-container">
      <div id="inner-container">
	<h1>Register view</h1>
	<div class="form-entry">
	  <form name="register" action="../controllers/proc-registration.php" method="POST">
	    <p><label for="username">Username:</label><input id="username" name="username" type="text" maxlength="30" <?php if(isset($_SESSION['reg_values'])) { echo 'value="' . $_SESSION['reg_values']['username'] . '"'; } ?> required></p>
	    <p><label for="email">Email:</label><input id="email" name="email" type="email" maxlength="40" <?php if(isset($_SESSION['reg_values'])) { echo 'value="' . $_SESSION['reg_values']['email'] . '"'; } ?> required></p>
	    <p><label for="password1">Password:</label><input id="password1" name="password1" type="password" maxlength="16" required></p>
	    <p><label for="password2">Repeat password:</label><input id="password2" name="password2" type="password" maxlength="16" required></p>
	    <p><input type="submit" value="Register"></p>
	  </form>
<?php
if(isset($_SESSION['reg_failed'])) {
  $html = '';
  $html = $html . '<div class="reg-error">' . "\n";
  $html = $html . '<p>The following errors occured:</p>' . "\n";
  $html = $html . '<ul>' . "\n";
  foreach($_SESSION['reg_errors'] as $error) {
    $html = $html . '<li>' . $error . '</li>' . "\n";
  }
  $html = $html . '</ul>' . "\n";
  $html = $html . '</div> <!-- end .reg-errors -->' . "\n";
  
  echo $html;

  $_SESSION['reg_failed'] = false;
  unset($_SESSION['reg_failed']);
  $_SESSION['reg_errors'] = false;
  unset($_SESSION['reg_errors']);
  $_SESSION['reg_values'] = false;
  unset($_SESSION['reg_values']);
}

?>
	</div> <!-- end .form-entry -->
	<p class="nav-paragraph">Or <a href="index.php">Go Back To The Login Page</a></p>
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>
