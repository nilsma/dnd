<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';
require_once '../models/gmsql.class.php';

$csql = new Charsql();
$gmsql = new Gmsql();

$alias = $_POST['alias'];
$char_name = $_POST['char_name'];
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];

$sheet_id = $csql->getSheetId($char_name, $user_id);
$cmp_id = $gmsql->getCampaignId($alias, $title);

var_dump($_SESSION);

$csql->acceptInvitation($alias, $char_name, $user_id, $title, $sheet_id, $cmp_id);
?>