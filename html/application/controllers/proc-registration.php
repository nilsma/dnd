<?php
session_start();
require_once '../configs/config.php';

require_once '../models/mysql.class.php';
require_once '../models/utils.class.php';

$username = Utils::html(trim($_POST['username']));
$email = filter_var(Utils::html(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);

$db = new Mysql();

if(!empty($username) && !empty($email) && !empty($password1) && !empty($password2)) {
  if(!$db->usernameExistence($username) && !$db->emailExistence($email)) {
    if($password1 == $password2) {
      if(Utils::validatePassword($password1)) {
        $db->registerUser($username, $email, $password1);
	$_SESSION['auth'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['user_id'] = $db->getUserId($username);
	header('Location: ../views/member.php');
      } else {
        $_SESSION['fail_password_format'] = true;
        header('Location: ../views/register.php');
      }
    } else {
      $_SESSION['fail_no_password_match'] = true;
      header('Location: ../views/register.php');
    }
  } else {
    $_SESSION['fail_user_details_exists'] = true;
    header('Location: ../views/register.php');
  }
} else {
  $_SESSION['reg_failed'] = true;
  header('Location: ../views/register.php');
}


/**
if(!empty($username) && !empty($email) && !empty($password1) && !empty($password2) && ($password1 == $password2) && (Utils::validatePassword($password1)) && (!$db->usernameExistence($username)) && (!$db->emailExistence($email)) ) {
  $db->registerUser($username, $email, $password1);
  $_SESSION['auth'] = true;
  $_SESSION['username'] = $username;
  $_SESSION['user_id'] = $db->getUserId($username);
  header('Location: ../views/member.php');
} else {
  $_SESSION['reg_failed'] = true;
  header('Location: ../views/register.php');
}
*/
?>