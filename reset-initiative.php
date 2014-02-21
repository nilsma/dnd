<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'lib/db_connect.php';

$campaign_id = $_POST['campaign_id'];

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE sheets s, members m, campaigns c SET s.init_roll=1 WHERE s.id=m.sheet AND m.campaign=c.id AND c.id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
    echo False;
  } else {

  $stmt->bind_param('i', $campaign_id);
  $stmt->execute();
    echo True;
  }



?>
