<?php
session_start();

require_once '../configs/config.php';
require_once '../models/gmsql.class.php';
require_once '../models/charsql.class.php';

$gmsql = new Gmsql();
$mysqli = $gmsql->connect();

$members = $_SESSION['gm']['members'];

$characters = array();

if(count($members) > 0) {
  foreach($members as $key => $val) {
    $character = $gmsql->getCharacterStats($val);
    $characters[] = $character;
  }
}

header('Content-type: application/json');
echo json_encode($characters, JSON_FORCE_OBJECT);

?>
