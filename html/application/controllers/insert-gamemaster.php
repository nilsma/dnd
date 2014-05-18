<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/utils.class.php';
require_once '../models/gmsql.class.php';

$gmsql = new Gmsql();

$gm = array();
$gm['owner'] = $_SESSION['user_id'];
$gm['alias'] = Utils::html(strtolower(trim($_POST['alias'])));
$gm['campaign'] = Utils::html(strtolower(trim($_POST['campaign_name'])));

$gm_id = $gmsql->insertGamemaster($gm);

$_SESSION['gm_id'] = $gm_id;

header('Location: ../views/gamemaster.php');

?>