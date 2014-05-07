<?php
session_start();

require_once $_SESSION['config'];

$css_path = BASE . CSS;
$js_path = BASE . JS;
$ctrls_path = BASE . CONTROLLERS;
$libs_path = BASE . LIBS;
$views_path = BASE . VIEWS;

if(isset($_SESSION['reg_failed'])) {
  $_SESSION['reg_failed'] = false;
  unset($_SESSION['reg_failed']);
}

require_once ROOT . BASE . VIEWS . 'head.php';
?>

<?php 
if(isset($_SESSION['auth_failed'])) {
  $_SESSION['auth_failed'] = false;
  unset($_SESSION['auth_failed']);
  echo 'username or password wrong!';
} 
?>
  <body id="index">
    <div id="main-container">
      <div class="form-entry">
	<h1>Login view</h1>
	<fieldset>
	  <legend>Login form</legend>
	  <form name="login" action="<?php echo $ctrls_path . 'proc-login.php' ?>" method="POST">
	    <label for="username">Username:</label><br/>
	    <input name="username" id="username" type="text" maxlength="30" required><br/>
	    <label for="password">Password:</label><br/>
	    <input name="password" id="password" type="password" maxlength="16" required><br/>
	    <input type="submit" value="Login">
	  </form>
	</fieldset>
      </div> <!-- end .formEntry -->
      <section class="sec-nav-container">
	<p class="nav-paragraph">Or <a href="<?php echo $views_path . 'register.php' ?>">Register New User</a></p>
      </section> <!-- end .sec-nav-container -->
    </div> <!-- end #main-container -->
  </body>
</html>
