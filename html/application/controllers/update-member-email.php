<?php
/**
 * A controller file for the DND Helper which updates the members (user) email in the database
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

$first_email = Utils::html(strtolower(trim($_POST['new-email-first'])));
$second_email = Utils::html(strtolower(trim($_POST['new-email-second'])));
$current_email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$errors = array();
$valid = true;

if($first_email != $second_email) {
  $errors[] = 'The email addresses does not match';
  $valid = false;
}

if(($first_email == $second_email) && ($current_email == $first_email)) {
  $errors[] = 'That is already your email';
  $valid = false;
}

if(($first_email == $second_email) && ($current_email != $first_email) && ($sql->emailExistence($first_email))) {
  $errors[] = 'Email already exists';
  $valid = false;
}

if($valid) {
  $sql->setEmail($user_id, $first_email);
  $_SESSION['email'] = $first_email;
  $success = array();
  $success[] = 'Email updated';
  $_SESSION['success'] = $success;
  header('Location: ../views/edit-member.php');
} else {
  $_SESSION['errors'] = $errors;
  header('Location: ../views/change-member-email.php');
}

?>