<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'lib/db_connect.php';

$gold = $_POST['gold'];
$silver = $_POST['silver'];
$copper = $_POST['copper'];

$myid = 3;

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE purse SET gold=?, silver=?, copper=? WHERE id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
  } else {

  $stmt->bind_param('iiii', $gold, $silver, $copper, $myid);
  $stmt->execute();

  }



?>
