<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$user_id = $_SESSION['user_id'];
$char_name = $_POST['name'];

$csql = new Charsql();
$sheet_id = $csql->getSheetId($char_name, $user_id);

if($sheet_id > 0) {
  $_SESSION['sheet_id'] = $sheet_id;
  $_SESSION['chosen'] = true;
} else {
  $_SESSION['sheet_id'] = false;
  unset($_SESSION['sheet_id']);
  $_SESSION['chosen'] = false;
  unset($_SESSION['chosen']);
}

?>
