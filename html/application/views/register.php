<?php
session_start();

require_once '../configs/config.php';

require_once 'head.php';
?>
  <body id="register">
    <h1>Register view</h1>
    <div id="main-container">
      <div class="form-entry">
	<fieldset>
	  <legend>Register</legend>
	  <form name="register" action="../controllers/proc-registration.php" method="POST">
	    <label for="username">Username:</label><br/>
	    <input name="username" type="text" maxlength="30" required><br/>
	    <label for="email">Email:</label><br/>
	    <input name="email" type="email" maxlength="40" required><br/>
	    <label for="password1">Password:</label><br/>
	    <input name="password1" type="password" maxlength="16" required><br/>
	    <label for="password2">Password:</label><br/>
	    <input name="password2" type="password" maxlength="16" required><br/>
	    <input type="submit" value="Register">
	  </form>
	</fieldset>
<?php
if(isset($_SESSION['reg_failed'])) {
  echo '<div class="reg-error">' . "\n";
  echo '<p>Something went wrong while registering, please try again.</p>' . "\n";
  echo '</div>' . "\n";
  $_SESSION['reg_failed'] = false;
  unset($SESSION['reg_failed']);
}

if(isset($_SESSION['fail_user_details_exists'])) {
  echo '<div class="reg-error">' . "\n";
  echo '<p>Username or email already exists!</p>' . "\n";
  $_SESSION['fail_user_details_exists'] = false;
  unset($_SESSION['fail_user_details_exists']);
}

if(isset($_SESSION['fail_no_password_match'])) {
  echo '<div class="reg-error">' . "\n";
  echo '<p>The passwords does not match!</p>';
  echo '</div>' . "\n";
  $_SESSION['fail_no_password_match'] = false;
  unset($_SESSION['fail_no_password_match']);
}

if(isset($_SESSION['fail_password_format'])) {
  echo '<div class="reg-error">' . "\n";
  echo '<p>Wrong format on your passwords!</p>' . "\n";
  echo '<p>Please make sure that your passwords match is at least 6 characters long, is not longer that 16 characters, has at least one letter, one number and one uppercase letter!</p> . "\n"';
  echo '</div>' . "\n";
  $_SESSION['fail_password_format'] = false;
  unset($_SESSION['fail_password_format']);
}

?>
      </div> <!-- end .form-entry -->
      <section class="sec-nav-container">
	<p class="nav-paragraph">Or <a href="index.php">Go Back To The Home Page</a></p>
      </section>
    </div> <!-- end #main-container -->
  </body>
</html>
