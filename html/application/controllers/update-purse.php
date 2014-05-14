<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

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