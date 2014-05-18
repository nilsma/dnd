<?php
session_start();
require_once '../configs/config.php';
require_once '../models/utils.class.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$params = array( 
		'name' => Utils::html(strtolower(trim($_POST['name']))),
		'class' => Utils::html(strtolower(trim($_POST['cls']))), 
		'level' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['level'])))),
		'xp' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['xp'])))),
		'dmg' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['dmg'])))),
		'hp' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['hp'])))),
		'init_roll' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['init_roll'])))),
		'init_mod' => Utils::checkNumeric(Utils::html(strtolower(trim($_POST['init_mod']))))
		 );

$csql = new Charsql();
$csql->updatePersonalia($sheet_id, $params);


?>