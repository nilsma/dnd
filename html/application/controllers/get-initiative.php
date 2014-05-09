<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$initiative = $csql->getInitiative($sheet_id);

header('Content-type: application/json');
echo json_encode($initiative, JSON_FORCE_OBJECT);

?>