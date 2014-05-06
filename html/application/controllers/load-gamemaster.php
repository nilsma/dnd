<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: http://127.0.1.1/dnd/html');
}

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'gmsql.class.php';

var_dump($_POST);

$user_id = $_SESSION['user_id'];
$alias = $_POST['gamemaster'];

$gmsql = new Gmsql();
$gm_id = $gmsql->getGamemasterId($alias, $user_id);

if($gm_id > 0) {
  $_SESSION['gm_id'] = $gm_id;
  header('Location: ' . BASE . VIEWS . 'gamemaster.php');
} else {
  header('Location: ' . BASE . VIEWS . 'gamemasters.php');
}

echo '<h1>load-gamemaster controller</h1>';

?>