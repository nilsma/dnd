<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';

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