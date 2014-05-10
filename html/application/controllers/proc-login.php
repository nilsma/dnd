<?php
session_start();

//require_once $_SESSION['config'];
//require_once ROOT . BASE . MODELS . 'mysql.class.php';
require_once '../configs/config.php';
require_once '../models/mysql.class.php';

$username = trim($_POST['username']);
$password = $_POST['password'];

if(!empty($username) && !empty($password)) {
  $sql = new Mysql();
  if($sql->checkLogin($username, $password)) {
    $_SESSION['auth'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $sql->getUserId($username);
//    header('Location: ' . ROOT . VIEWS . 'member.php');
      header('Location: ../views/member.php');
  } else {
    $_SESSION['auth'] = false;
    unset($_SESSION['auth']);
    $_SESSION['auth_failed'] = true;
//    header('Location: ' . ROOT . VIEWS . 'index.php');
      header('Location: ../views/index.php');
  }
}

?>