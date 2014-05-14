<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: http://127.0.1.1/dnd/html');
}

require_once '../configs/config.php';
require_once '../models/gmsql.class.php';

$user_id = $_SESSION['user_id'];
$alias = $_POST['alias'];

$gmsql = new Gmsql();
$gm_id = $gmsql->getGamemasterId($alias, $user_id);

if($gm_id > 0) {
  $_SESSION['gm_id'] = $gm_id;
  $_SESSION['chosen'] = true;
} else {
  $_SESSION['gm_id'] = false;
  unset($_SESSION['gm_id']);
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

?>