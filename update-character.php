<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'db_connect.php';

$name = $_POST['name'];
$level = $_POST['level'];
$cls = $_POST['cls'];
$injury = $_POST['injury'];

$myid = 3;

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE sheets SET name=?, level=?, class=?, damage_taken=? WHERE id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
  } else {

  $stmt->bind_param('sisii', $name, $level, $cls, $injury, $myid);
  $stmt->execute();

  }



?>
