<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';

$csql = new Charsql();

$sheet_id = $_SESSION['sheet_id'];

$csql->deleteCharacter($sheet_id);

header('Location: ' . BASE . VIEWS . 'characters.php');


?>