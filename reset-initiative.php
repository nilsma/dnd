<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include 'db_connect.php';

$party_id = $_POST['party_id'];

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "UPDATE sheets s, members m, parties p SET s.initiative_roll=1 WHERE s.id=m.sheet AND m.party=p.id AND p.id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (update-character)");
  } else {

  $stmt->bind_param('i', $party_id);
  $stmt->execute();

  }



?>
