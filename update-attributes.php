<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'db_connect.php';

$str = $_POST['str'];
$con = $_POST['con'];
$dex = $_POST['dex'];
$intel = $_POST['intel'];
$wis = $_POST['wis'];
$cha = $_POST['cha'];

$myid = 3;

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE attributes SET str=?, con=?, dex=?, intel=?, wis=?, cha=? WHERE id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
  } else {

  $stmt->bind_param('iiiiiii', $str, $con, $dex, $intel, $wis, $cha, $myid);
  $stmt->execute();

  }



?>
