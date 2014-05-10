<?php
session_start();

require_once '../configs/config.php';
require_once '../models/mysql.class.php';
require_once '../models/charsql.class.php';
require_once '../models/gmsql.class.php';

$users_name = $_POST['users-name'];
$chars_name = $_POST['characters-name'];

$db = new Mysql();
$csql = new Charsql();

$user_id = $db->getUserId($users_name);
$sheet_id = $csql->getSheetId($chars_name, $user_id);
$cmp_id = $_SESSION['gm']['campaign']['id'];
$gm_id = $_SESSION['gm_id'];

if(isset($_SESSION['invite_failed'])) {
  $_SESSION['invite_failed'] = false;
  unset($_SESSION['invite_failed']);
}

if(!empty($user_id) && $user_id >= 1 && !empty($sheet_id) && $sheet_id >= 1) {
  $gmsql = new Gmsql();
  $gmsql->createInvite($gm_id, $sheet_id, $cmp_id);

} else {
  $_SESSION['invite_failed'] = true;

}

header('Location: ../views/invitations.php');
?>