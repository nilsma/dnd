<?php
session_start();

require_once $_SESSION['config'];

$css_path = BASE . CSS;
$js_path = BASE . JS;
$ctrls_path = BASE . CONTROLLERS;
$libs_path = BASE . LIBS;
$views_path = BASE . VIEWS;
?>
<html>
  <head>
    <!-- some code here -->
  </head>
  <body>
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

    <form name="register" action="<?php echo $ctrls_path . 'proc-registration.php' ?>" method="POST">
      <p id="username">Username: <label for="username"><input name="username" type="text" maxlength="30" required></label></p>
      <p id="email">Email: <label for="email"><input name="email" type="email" maxlength="40" required></label></p>
      <p id="password1">Password: <label for="password1"><input name="password1" type="password" maxlength="16" required></label></p>
      <p id="password2">Password: <label for="password2"><input name="password2" type="password" maxlength="16" required></label></p>
      <input type="submit" value="Register">
    </form>
  </body>
</html>
