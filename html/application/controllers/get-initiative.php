<?php
/**
 * A controller file for the DND Helper which gets a character's initiative from the database
 * @author 130680
 * @created 2014-05-25
 */
session_start();
require_once '../configs/config.php';

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: ' . URL . '');
}

require_once '../models/charsql.class.php';

$sheet_id = $_SESSION['sheet_id'];

$csql = new Charsql();
$initiative = $csql->getInitiative($sheet_id);

header('Content-type: application/json');
echo json_encode($initiative, JSON_FORCE_OBJECT);

?>