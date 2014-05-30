<?php
/**
 * A controller file for the DND Helper which inserts a new character's sheet to the database
 * @author 130680
 * @created 2014-05-25
 */
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
$attrs['str'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['str']))));
$attrs['strMod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['strMod']))));
$attrs['con'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['con']))));
$attrs['conMod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['conMod']))));
$attrs['dex'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['dex']))));
$attrs['dexMod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['dexMod']))));
$attrs['intel'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['intel']))));
$attrs['intelMod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['intelMod']))));
$attrs['wis'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['wis']))));
$attrs['wisMod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['wisMod']))));
$attrs['cha'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['cha']))));
$attrs['chaMod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['chaMod']))));

$purse = array();
$purse['gold'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['gold']))));
$purse['silver'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['silver']))));
$purse['copper'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['copper']))));

$sheet = array();
$sheet['name'] = Utils::html(strtolower(trim($_POST['name'])));
$sheet['level'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['level']))));
$sheet['xp'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['xp']))));
$sheet['class'] = Utils::html(strtolower(trim($_POST['class'])));
$sheet['hp'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['hp']))));
$sheet['dmg'] = Utils::checkNumeric(Utils::html(strtolower(trim(0))));
$sheet['init_mod'] = Utils::checkNumeric(Utils::html(strtolower(trim($_POST['init_mod']))));
$sheet['init_roll'] = Utils::checkNumeric(Utils::html(strtolower(trim(0))));

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
