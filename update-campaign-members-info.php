<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'lib/db_connect.php';
include 'tools.php';

$return_data = array();

$campaign_id = 1; //SESSION VARIABLE

$ids = getCampaignMembersIds($mysqli, $campaign_id);


buildGMScreen($mysqli, $ids);

//$return_data['result'] = $html;

//header('Content-type: application/json');
//echo json_encode($return_data);


?>
