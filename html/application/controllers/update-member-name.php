<?php
/**
 * A controller file for the DND Helper which updates the members (user) name in the database
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

$new_name = Utils::html(strtolower(trim($_POST['new-name'])));
$user_id = $_SESSION['user_id'];
$cur_name = $_SESSION['username'];
$errors = array();
$valid = true;

if(empty($new_name)) {
  $errors[] = 'You forgot to enter a name';
  $valid = false;
}

if($cur_name == $new_name) {
  $errors[] = 'You cannot change to the same name';
  $valid = false;
}

if(($cur_name != $new_name) && ($sql->usernameExistence($new_name))) {
  $errors[] = 'Username already exists';
  $valid = false;
}

if($valid) {
  $sql->setUsername($user_id, $new_name);
  $_SESSION['username'] = $new_name;
  $success = array();
  $success[] = 'Username updated';
  $_SESSION['success'] = $success;
  header('Location: ../views/edit-member.php');
} else {
  $_SESSION['errors'] = $errors;
  header('Location: ../views/change-member-name.php');
}

?>