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
?>

<!DOCTYPE html>
<html>
  <body>
    <h1>Login view</h1>
<?php 
if(isset($_SESSION['auth_failed'])) {
  $_SESSION['auth_failed'] = false;
  unset($_SESSION['auth_failed']);
  echo 'username or password wrong!';
} 
?>
    <form name="login" action="<?php echo $ctrls_path . 'proc-login.php' ?>" method="POST">
      <p id="username">Username: <label for="username"><input name="username" type="text" maxlength="30" required></label></p>
      <p id="password">Password: <label for="password"><input name="password" type="password" maxlength="16" required></label></p>
      <input type="submit" value="login">
    </form>
  <br/>
  <p>Or <a href="<?php echo $views_path . 'register.php' ?>">Register</a></p>
  </body>
</html>
