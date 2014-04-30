<?php
session_start();
require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'mysql.class.php';
require_once ROOT . BASE . MODELS . 'utils.class.php';

$username = Utils::html(trim($_POST['username']));
$email = filter_var(Utils::html(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);

$db = new Mysql();

if(!empty($username) && !empty($email) && !empty($password1) && !empty($password2) && ($password1 == $password2) && (Utils::validatePassword($password1)) && (!$db->usernameExistence($username)) && (!$db->emailExistence($email)) ) {
  $db->registerUser($username, $email, $password1);
  $_SESSION['auth'] = true;
  $_SESSION['username'] = $username;
  $_SESSION['user_id'] = $db->getUserId($username);
  header('Location: ' . BASE . VIEWS . 'member.php');
} else {
  $_SESSION['reg_failed'] = true;
  header('Location: ' . BASE . VIEWS . 'register.php');
}

?>