<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'lib/db_connect.php';

$name = $_POST['name'];
$level = $_POST['level'];
$cls = $_POST['cls'];
$injury = $_POST['injury'];
$hp = $_POST['hp'];
$init_roll = $_POST['init_roll'];

$myid = 3;

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE sheets SET name=?, level=?, class=?, dmg=?, hp=?, init_roll=? WHERE id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
  } else {

  $stmt->bind_param('sisiiii', $name, $level, $cls, $injury, $hp, $init_roll, $myid);
  $stmt->execute();

  }



?>
