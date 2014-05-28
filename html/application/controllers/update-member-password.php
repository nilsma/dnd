<?php
/**
 * A controller file for the DND Helper which updates the members (user) password in the database
 * @author Nils Martinussen
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/mysql.class.php';
require_once '../models/utils.class.php';

$sql = new Mysql();

$cur = Utils::html(trim($_POST['password-current']));
$pwd1 = Utils::html(trim($_POST['password-first']));
$pwd2 = Utils::html(trim($_POST['password-repeat']));
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$errors = array();
$valid = true;

if(!$sql->checkLogin($username, $cur)) {
  $errors[] = 'Wrong password';
  $valid = false;
}

if($pwd1 != $pwd2) {
  $errors[] = 'The passwords does not match';
  $valid = false;
}

if(($pwd1 == $pwd2) && ($pwd1 == $cur)) {
  $errors[] = 'You cannot change to your old password';
  $valid = false;
}

if(($cur != $pwd1) && ($pwd1 == $pwd2) && (!Utils::validatePassword($pwd1))) {
  $errors[] = 'The password is not valid';
  $valid = false;
}

if($valid) {
  $new_pwd = Utils::hashPassword($pwd1);
  $sql->setPassword($user_id, $new_pwd);
  $success = array();
  $success[] = 'Password updated';
  $_SESSION['success'] = $success;
  header('Location: ../views/edit-member.php');
} else {
  $_SESSION['errors'] = $errors;
  header('Location: ../views/change-member-password.php');
}

?>