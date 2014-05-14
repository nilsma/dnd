<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

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

$gmsql = new Gmsql();

var_dump($_POST);
echo '<br/>';

$membershipExists = $gmsql->membershipExists($sheet_id, $cmp_id);
$invitationExists = $gmsql->invitationExists($gm_id, $sheet_id, $cmp_id);

if(!empty($user_id) && $user_id >= 1 && !empty($sheet_id) && $sheet_id >= 1) {
  if(!$invitationExists && !$membershipExists) {
    $gmsql->createInvite($gm_id, $sheet_id, $cmp_id);
  } else {
    if($invitationExists) {
      $_SESSION['fail_invitation_existence'] = true;
    }

    if($membershipExists) {
      $_SESSION['fail_membership_existence'] = true;
    }
  }
} else {
  $_SESSION['fail_user_existence'] = true;
}

header('Location: ../views/gamemaster-invitations.php');
?>