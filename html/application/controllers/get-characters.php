<?php
session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . MODELS . 'charsql.class.php';
require_once ROOT . BASE . MODELS . 'gmsql.class.php';

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
