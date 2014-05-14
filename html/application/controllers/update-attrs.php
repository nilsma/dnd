<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$params = array( 
		'str' => $_POST['str'],
		'str_mod' => $_POST['str_mod'],
		'con' => $_POST['con'],
		'con_mod' => $_POST['con_mod'],
		'dex' => $_POST['dex'],
		'dex_mod' => $_POST['dex_mod'],
		'intel' => $_POST['intel'],
		'intel_mod' => $_POST['intel_mod'],
		'wis' => $_POST['wis'],
		'wis_mod' => $_POST['wis_mod'],
		'cha' => $_POST['cha'],
		'cha_mod' => $_POST['cha_mod']
		 );

$csql = new Charsql();
$csql->updateAttrs($sheet_id, $params);

?>