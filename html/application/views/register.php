<?php
session_start();

require_once $_SESSION['config'];

$css_path = BASE . CSS;
$js_path = BASE . JS;
$ctrls_path = BASE . CONTROLLERS;
$libs_path = BASE . LIBS;
$views_path = BASE . VIEWS;

require_once ROOT . BASE . VIEWS . 'head.php';

?>
  <body id="register">
    <h1>Register view</h1>

<?php 
if(isset($_SESSION['reg_failed'])) {
  echo 'Your registration did not pass.<br/>';
  echo 'Please make sure that your passwords match,<br/>';
  echo 'is at least 6 characters long,<br/>';
  echo 'is not longer that 16 characters,<br/>';
  echo 'has at least one letter, one number and one uppercase letter!';
  $_SESSION['reg_failed'] = false;
  unset($_SESSION['reg_failed']);
}

?>
    <div id="main-container">
      <div class="form-entry">
	<fieldset>
	  <legend>Register</legend>
	  <form name="register" action="<?php echo $ctrls_path . 'proc-registration.php' ?>" method="POST">
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
