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
		'gold' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['gold'])))),
		'silver' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['silver'])))),
		'copper' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['copper']))))
		 );

$csql = new Charsql();
$csql->updatePurse($sheet_id, $params);


?>