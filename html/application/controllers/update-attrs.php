<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';
require_once '../models/utils.class.php';

$sheet_id = $_SESSION['sheet_id'];

$params = array( 
		'str' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['str'])))),
		'str_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['str_mod'])))),
		'con' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['con'])))),
		'con_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['con_mod'])))),
		'dex' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['dex'])))),
		'dex_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['dex_mod'])))),
		'intel' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['intel'])))),
		'intel_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['intel_mod'])))),
		'wis' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['wis'])))),
		'wis_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['wis_mod'])))),
		'cha' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['cha'])))),
		'cha_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['cha_mod']))))
		 );

$csql = new Charsql();
$csql->updateAttrs($sheet_id, $params);

?>