<?php
session_start();

require_once '../configs/config.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="stylesheet" href="../../public/css/main.css"/>
    <link rel="stylesheet" href="../../public/css/index.css"/>
    <title>DND Helper</title>
  </head>
  <body id="index">
    <div id="main-container">
      <div id="inner-container">
	<h1>Login view</h1>
	<div class="form-entry">
	  <form name="login" action="../controllers/proc-login.php" method="POST">
	    <p><label for="username">Username:</label><input name="username" id="username" type="text" maxlength="30" required></p>
	    <p><label for="password">Password:</label><input name="password" id="password" type="password" maxlength="16" required></p>
	    <p><input type="submit" value="Login"></p>
	  </form>
<?php 
   if(isset($_SESSION['auth_failed'])) {
   $_SESSION['auth_failed'] = false;
   unset($_SESSION['auth_failed']);
   echo '<div class="auth-error">' . "\n";
   echo '<p>Username or password wrong!</p>' . "\n";
   echo '</div>' . "\n";
   } 
?>
	</div> <!-- end .form-entry -->
	<p class="nav-paragraph">Or <a href="register.php">Register New User</a></p>
      </div> <!-- end #inner-container -->
    </div> <!-- end #main-container -->
  </body>
</html>
