<?php
session_start();

require_once $_SESSION['config'];
include ROOT . BASE . MODELS . 'mysql.class.php';

$username = trim($_POST['username']);
$password = $_POST['password'];

if(!empty($username) && !empty($password)) {
  $sql = new Mysql();
  if($sql->checkLogin($username, $password)) {
    $_SESSION['auth'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $sql->getUserId($username);
    header('Location: ' . BASE . VIEWS . 'member.php');
  } else {
    $_SESSION['auth'] = false;
    unset($_SESSION['auth']);
    $_SESSION['auth_failed'] = true;
    header('Location: ' . BASE . VIEWS . 'index.php');
  }
}

?>