<?php

function getCharacter($mysqli, $myid) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $stmt = $mysqli->prepare("SELECT s.name, s.level, s.class, s.max_hitpoints, s.damage_taken FROM sheets as s, users as u WHERE s.owner=u.id AND u.id=$myid");
  $stmt->bind_param('i', $myid);

  $stmt->execute();
  $stmt->bind_result($name, $level, $class, $max_hp, $dmg_taken);
  $character = array();
  while($stmt->fetch()) {
    $character = array(
      'name' => $name,
      'level' => $level,
      'class' => $class,
      'max_hitpoints' => $max_hp,
      'damage_taken' => $dmg_taken
    );
    
    return $character;
  }

  $stmt->close();
  $mysqli->close();
}

?>