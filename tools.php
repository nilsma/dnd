<?php

function getMyHitpoints($mysqli, $myid) {
  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT username FROM users WHERE id=1");

  $stmt = $mysqli->stmt_init();
  if(!$stmt->prepare($query)) {
    print("Failed statement");
  } else {
    $stmt->execute();
    $stmt->bind_param('i', $myid);
    $stmt->bind_result($hp);
    while($stmt->fetch()) {
      echo $hp;
    }

  }

  mysqli_stmt_close($stmt);
  mysqli_close($mysqli);
}

?>