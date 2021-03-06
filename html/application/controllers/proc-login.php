<?php
/**
 * A controller file for the DND Helper which processes a login attempt
 * @author 130680
 * @created 2014-05-25
 */
session_start();

require_once '../configs/config.php';
require_once '../models/mysql.class.php';
require_once '../models/utils.class.php';

$username = Utils::html(trim($_POST['username']));
$password = $_POST['password'];

if(!empty($username) && !empty($password)) {
  $sql = new Mysql();
  if($sql->checkLogin($username, $password)) {
    $_SESSION['auth'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $sql->getUserId($username);
    $_SESSION['email'] = $sql->getUserEmail($_SESSION['user_id']);
    header('Location: ../views/member.php');
  } else {
    $_SESSION['auth_failed'];
    $_SESSION['auth_failed'] = true;
    header('Location: ../views/index.php');
  }
}

?>