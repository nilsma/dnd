<?php
session_start();

//require_once $_SESSION['config'];
//require_once ROOT . BASE . MODELS . 'charsql.class.php';
require_once '../configs/config.php';
require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$params = array( 
		'gold' => $_POST['gold'],
		'silver' => $_POST['silver'],
		'copper' => $_POST['copper'],
		 );

$csql = new Charsql();
$csql->updatePurse($sheet_id, $params);


?>