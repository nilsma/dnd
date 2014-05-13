<?php
session_start();

require_once '../configs/config.php';

if(isset($_SESSION['reg_failed'])) {
  $_SESSION['reg_failed'] = false;
  unset($_SESSION['reg_failed']);
}

//require_once 'head.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
<!--    <script type="text/javascript" src="../../public/js/main.js"></script> -->
<!--    <script type="text/javascript" src="../../public/js/gm.js"></script> -->
    <title>DND Helper</title>
  </head>
  <body id="index">
    <div id="main-container">
      <h1>Login view</h1>
      <div id="inner-container">
	<div class="form-entry">
	  <fieldset>
	    <legend>Login form</legend>
	    <form name="login" action="../controllers/proc-login.php" method="POST">
	    <label for="username">Username:</label><br/>
	    <input name="username" id="username" type="text" maxlength="30" required><br/>
	    <label for="password">Password:</label><br/>
	    <input name="password" id="password" type="password" maxlength="16" required><br/>
	    <input type="submit" value="Login">
	    </form>
	  </fieldset>
<?php 
if(isset($_SESSION['auth_failed'])) {
  $_SESSION['auth_failed'] = false;
  unset($_SESSION['auth_failed']);
  echo '<div class="auth-error">' . "\n";
  echo '<p>username or password wrong!</p>' . "\n";
  echo '</div>' . "\n";
} 
?>
      </div> <!-- end .formEntry -->
      <section class="sec-nav-container">
	<p class="nav-paragraph">Or <a href="register.php">Register New User</a></p>	
      </section> <!-- end .sec-nav-container -->
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>
