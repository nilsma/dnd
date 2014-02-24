<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include '../lib/db_connect.php';

$str = $_POST['str'];
$con = $_POST['con'];
$dex = $_POST['dex'];
$intel = $_POST['intel'];
$wis = $_POST['wis'];
$cha = $_POST['cha'];

var_dump($con);

$myid = 3;

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE attrs a, sheets s SET a.str=?, a.con=?, a.dex=?, a.intel=?, a.wis=?, a.cha=? WHERE s.id=? AND s.attr=a.id";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-attributes)");
  } else {

  $stmt->bind_param('iiiiiii', $str, $con, $dex, $intel, $wis, $cha, $myid);
  $stmt->execute();

  }



?>
