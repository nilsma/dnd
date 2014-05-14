<?php
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$params = array( 
		'name' => $_POST['name'],
		'class' => $_POST['cls'],
		'level' => $_POST['level'],
		'xp' => $_POST['xp'],
		'dmg' => $_POST['dmg'],
		'hp' => $_POST['hp'],
		'init_roll' => $_POST['init_roll'],
		'init_mod' => $_POST['init_mod']
		 );

$csql = new Charsql();
$csql->updatePersonalia($sheet_id, $params);


?>