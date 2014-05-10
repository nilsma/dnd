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

//TODO FINISH INSERT INVITE
if(!empty($user_id) && $user_id >= 1 && !empty($sheet_id) && $sheet_id >= 1) {
//  $gmsql = new Gmsql();
//  $gmsql->createInvite($user_id, $sheet_id);
				       

} else {
  echo 'not both user and character exists';

}

//header('Location: ../views/invitations.php');
?>