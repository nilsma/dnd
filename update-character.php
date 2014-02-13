<?php

include 'db_connect.php';

$name = $_POST['name'];
$level = $_POST['level'];
$cls = $_POST['cls'];
$injury = $_POST['injury'];

$myid = 3;

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE sheet SET name=?, level=?, class=?, damage_taken=? WHERE id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
  } else {

  $stmt->bind_param('siiii', $name, $level, $cls, $injury, $myid);
  $stmt->execute();

  print('success');
  }



?>
