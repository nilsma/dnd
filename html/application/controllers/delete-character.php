<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
//    header('Location: http://127.0.1.1/dnd/html/index.php');
    header('Location: http://dnd.nima-design.net');
}

//require_once $_SESSION['config'];
//require_once ROOT . BASE . MODELS . 'charsql.class.php';
require_once '../configs/config.php';
require_once '../models/charsql.class.php';

$csql = new Charsql();

$sheet_id = $_SESSION['sheet_id'];

$csql->deleteCharacter($sheet_id);

//header('Location: ' . BASE . VIEWS . 'characters.php');
header('Location: ../views/characters.php');


?>