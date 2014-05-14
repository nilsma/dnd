<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/utils.class.php';
require_once '../models/charsql.class.php';
require_once '../models/membersql.class.php';

$msql = new Membersql();
$csql = new Charsql();

$attrs = array();
$attrs['str'] = $_POST['str'];
$attrs['strMod'] = $_POST['strMod'];
$attrs['con'] = $_POST['con'];
$attrs['conMod'] = $_POST['conMod'];
$attrs['dex'] = $_POST['dex'];
$attrs['dexMod'] = $_POST['dexMod'];
$attrs['intel'] = $_POST['intel'];
$attrs['intelMod'] = $_POST['intelMod'];
$attrs['wis'] = $_POST['wis'];
$attrs['wisMod'] = $_POST['wisMod'];
$attrs['cha'] = $_POST['cha'];
$attrs['chaMod'] = $_POST['chaMod'];

$purse = array();
$purse['gold'] = $_POST['gold'];
$purse['silver'] = $_POST['silver'];
$purse['copper'] = $_POST['copper'];

$sheet = array();
$sheet['name'] = strtolower($_POST['name']);
$sheet['level'] = $_POST['level'];
$sheet['xp'] = $_POST['xp'];
$sheet['class'] = strtolower($_POST['class']);
$sheet['hp'] = $_POST['hp'];
$sheet['dmg'] = 0;
$sheet['init_mod'] = $_POST['init_mod'];
$sheet['init_roll'] = 0;

if(!$msql->alreadyOwnsName($_SESSION['user_id'], $sheet['name'])) {
  $sheet_id = $csql->insertSheet($sheet, $attrs, $purse);
  $_SESSION['sheet_id'] = $sheet_id;
  header('Location: ../views/characters.php');
} else {
  //TODO define else rule
  //give user feedback upon error on creating
  //new character, i.e. when alreadyOwnsName function
  //returns true
  header('Location: ../views/create-character.php');
}

?>
