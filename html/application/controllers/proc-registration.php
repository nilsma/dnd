<?php
session_start();
//require_once $_SESSION['config'];
require_once '../configs/config.php';

//require_once ROOT . BASE . MODELS . 'mysql.class.php';
//require_once ROOT . BASE . MODELS . 'utils.class.php';
require_once '../models/mysql.class.php';
require_once '../models/utils.class.php';

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
//  header('Location: ' . ROOT . VIEWS . 'member.php');
  header('Location: ../views/member.php');
} else {
  $_SESSION['reg_failed'] = true;
//  header('Location: ' . VIEWS . 'register.php');
  header('Location: ../views/register.php');
}

?>