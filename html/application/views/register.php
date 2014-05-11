<?php
session_start();

require_once '../configs/config.php';

require_once 'head.php';
?>
  <body id="register">
    <h1>Register view</h1>

<?php
if(isset($_SESSION['reg_failed'])) {
  echo 'Something went wrong while registering, please try again.';
  $_SESSION['reg_failed'] = false;
  unset($SESSION['reg_failed']);
}

if(isset($_SESSION['fail_user_details_exists'])) {
  echo 'Username or email already exists!';
  $_SESSION['fail_user_details_exists'] = false;
  unset($_SESSION['fail_user_details_exists']);
}

if(isset($_SESSION['fail_no_password_match'])) {
  echo 'The password does not match!';
  $_SESSION['fail_no_password_match'] = false;
  unset($_SESSION['fail_no_password_match']);
}

if(isset($_SESSION['fail_password_format'])) {
  echo 'Wrong format on your passwords!<br/>';
  echo 'Please make sure that your passwords match,<br/>';
  echo 'is at least 6 characters long,<br/>';
  echo 'is not longer that 16 characters,<br/>';
  echo 'has at least one letter, one number and one uppercase letter!';
  $_SESSION['fail_password_format'] = false;
  unset($_SESSION['fail_password_format']);
}

?>
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
      </div> <!-- end .form-entry -->
      <section class="sec-nav-container">
	<p class="nav-paragraph">Or <a href="index.php">Go Back To The Home Page</a></p>
      </section>
    </div> <!-- end #main-container -->
  </body>
</html>
