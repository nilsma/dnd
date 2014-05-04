<?php
session_start();
require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';

$user_id = $_SESSION['user_id'];
$char_name = $_POST['character'];

$csql = new Charsql();
$sheet_id = $csql->getSheetId($char_name, $user_id);

if($sheet_id > 0) {
  $_SESSION['sheet_id'] = $sheet_id;
  header('Location: ' . BASE . VIEWS . 'character.php');
} else {
  header('Location: ' . BASE . VIEWS . 'characters.php');
}

?>
