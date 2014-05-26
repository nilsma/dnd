<?php
session_start();

require_once '../configs/config.php';
require_once '../models/mysql.class.php';
require_once '../models/utils.class.php';

$username = Utils::html(trim($_POST['username']));
$email = filter_var(Utils::html(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);

$credentials = true;
$reg_errors = array();
$reg_values = array();
$db = new Mysql();


if(empty($username) || empty($email) || empty($password1) || empty($password2)) {
  $reg_errors[] = 'Please fill out all the required fields';
  $credentials = false;
}

if($db->usernameExistence($username) || $db->emailExistence($email)) {
  $reg_errors[] = 'Username or email already exists';
  $credentials = false;
}

if($password1 != $password2) {
  $reg_values['username'] = $username;
  $reg_values['email'] = $email;
  $reg_errors[] = 'The passwords does not match';
  $credentials = false;
}

if(!Utils::validatePassword($password1)) {
  $reg_values['username'] = $username;
  $reg_values['email'] = $email;
  $reg_errors[] = 'Bad password. Your password must be 8-16 characters long and must contain one upper and one lower case, and one number';
  $credentials = false;
}

if($credentials == true) {
  $db->registerUser($username, $email, $password1);
  $_SESSION['auth'] = true;
  $_SESSION['username'] = $username;
  $_SESSION['user_id'] = $db->getUserId($username);
  $_SESSION['email'] = $email;
  header('Location: ../views/member.php');
} else {
  $_SESSION['reg_errors'] = $reg_errors;
  $_SESSION['reg_values'] = $reg_values;
  $_SESSION['reg_failed'] = true;
  header('Location: ../views/register.php');
}

?>