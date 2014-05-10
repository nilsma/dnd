<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
//  header('Location: http://127.0.1.1/dnd/html');
  header('Location: http://dnd.nima-design.net');
}


//require_once $_SESSION['config'];
//require_once ROOT . BASE . MODELS . 'utils.class.php';
//require_once ROOT . BASE . MODELS . 'gmsql.class.php';
require_once '../configs/config.php';
require_once '../models/utils.class.php';
require_once '../models/gmsql.class.php';

$gmsql = new Gmsql();

$gm = array();
$gm['owner'] = $_SESSION['user_id'];
$gm['alias'] = Utils::html(strtolower(trim($_POST['alias'])));
$gm['campaign'] = Utils::html(strtolower(trim($_POST['campaign_name'])));

$gm_id = $gmsql->insertGamemaster($gm);

$_SESSION['gm_id'] = $gm_id;

//header('Location: ' . BASE . VIEWS . 'gamemaster.php');
header('Location: ../views/gamemaster.php');


?>