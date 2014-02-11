<?php
include 'db_connect.php';
include 'tools.php';

$myid = 3;

echo '<br/>------------------------<br/>';

$character = array();
$character = getCharacter($mysqli, $myid);

echo 'Name: ', $character['name'],'<br/>';
echo 'Level ', $character['level'],' ',$character['class'],'<br/>';
echo 'Hitpoints: ',$character['damage_taken'] ,'/',$character['max_hitpoints'];


?>