<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include '../lib/db_connect.php';
include 'tools.php';

$return_data = array();

$party_id = 1; //SESSION variable

$ids = getPartyMembersId($mysqli, $party_id);

$html = buildGMScreen($mysqli, $ids);

echo $html;

//$return_data['result'] = $html;

//header('Content-type: application/json');
//echo json_encode($return_data);


?>
