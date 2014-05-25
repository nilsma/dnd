<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/gmsql.class.php';
require_once '../models/utils.class.php';

$gmsql = new Gmsql();
$user_id = $_SESSION['user_id'];
$gm_id = $_SESSION['gm_id'];
$cmp_id = $_SESSION['gm']['campaign']['id'];
$curAlias = strtolower($_SESSION['gm']['details']['alias']);
$newAlias = strtolower(Utils::html(trim($_POST['alias'])));
$title = Utils::html(trim($_POST['campaign_name']));
$editable = true;
$errors = array();

if(empty($newAlias) || empty($title)) {
  $errors[] = 'You must fill in both gamemaster alias and campaign name';
  $editable = false;
}

if(($editable) && ($curAlias != $newAlias)) {
  $exists = $gmsql->aliasExists($user_id, $newAlias);
  if($exists) {
    $errors[] = 'You already have another gamemaster with that alias';
    $editable = false;
  }
}

$_SESSION['errors'] = $errors;

if($editable == true) {
  $gmsql->updateGamemaster($gm_id, $cmp_id, $newAlias, $title);
}
header('Location: ../views/edit-gamemaster.php');
?>