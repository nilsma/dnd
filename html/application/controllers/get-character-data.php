<?php

include '../libs/db_connect.php';

$myid = 3;

$return_data = array();

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "SELECT s.init_roll FROM sheets as s, users as u WHERE s.owner=u.id AND u.id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (get character SQL)");
  } else {

  $stmt->bind_param('i', $myid);
  $stmt->execute();
  $stmt->bind_result($init_roll);
  while($stmt->fetch()) {
    $return_data['init_roll'] = $init_roll;
  }
}

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

header('Content-type: application/json');
echo json_encode($return_data['init_roll']);

?>