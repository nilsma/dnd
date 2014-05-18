<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/mysql.class.php';
require_once '../models/charsql.class.php';
require_once '../models/gmsql.class.php';
require_once '../models/utils.class.php';

$users_name = Utils::html(strtolower(trim($_POST['users-name'])));
$chars_name = Utils::html(strtolower(trim($_POST['characters-name'])));

$db = new Mysql();
$csql = new Charsql();
$gmsql = new Gmsql();

$user_id = $db->getUserId($users_name);
$sheet_id = $csql->getSheetId($chars_name, $user_id);
$cmp_id = $_SESSION['gm']['campaign']['id'];
$gm_id = $_SESSION['gm_id'];

$credentials = true;
$inv_errors = array();
if(empty($user_id) || $user_id < 1 || empty($sheet_id) || $sheet_id < 1) {
  $inv_errors[] = 'Username or character name does not exist';
  $credentials = false;
}

if($gmsql->invitationExists($gm_id, $sheet_id, $cmp_id)) {
  $inv_errors[] = 'That character has already been invited to campaign';
  $credentials = false;
}

if($gmsql->membershipExists($sheet_id, $cmp_id)) {
  $inv_errors[] = 'That character is already part of the campaign';
  $credentials = false;
}

if($credentials) {
  $gmsql->createInvite($gm_id, $sheet_id, $cmp_id);
} else {
  $_SESSION['inv_errors'] = $inv_errors;
  $_SESSION['inv_failed'] = true;
}

header('Location: ../views/gamemaster-invitations.php');
?>