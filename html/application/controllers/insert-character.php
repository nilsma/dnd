<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'utils.class.php';
require_once ROOT . BASE . MODELS . 'charsql.class.php';

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
$sheet['name'] = $_POST['name'];
$sheet['level'] = $_POST['level'];
$sheet['class'] = $_POST['class'];
$sheet['hp'] = $_POST['hp'];
$sheet['dmg'] = 0;
$sheet['init_mod'] = $_POST['init_mod'];
$sheet['init_roll'] = 0;

$csql->insertSheet($sheet, $attrs, $purse);

header('Location: ' . BASE . VIEWS . 'new-character.php');


?>