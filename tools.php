<?php

function getCharacter($mysqli, $myid) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $stmt = $mysqli->prepare("SELECT s.name, s.level, s.class, s.max_hitpoints, s.damage_taken, p.gold, p.silver, p.copper, a.str, a.con, a.dex, a.intel, a.wis, a.cha FROM sheets as s, purse as p, attributes as a, users as u WHERE a.id=s.attributes AND p.id=s.purse AND s.owner=u.id AND u.id=?");
  $stmt->bind_param('i', $myid);

  $stmt->execute();
  $stmt->bind_result($name, $level, $cls, $max_hp, $dmg_taken, $gold, $silver, $copper, $str, $con, $dex, $intel, $wis, $cha);
  $character = array();
  while($stmt->fetch()) {
    $attributes = array(
      'str' => $str,
      'con' => $con,
      'dex' => $dex,
      'intel' => $intel,
      'wis' => $wis,
      'cha' => $cha
    );
    $purse = array(
      'gold' => $gold,
      'silver' => $silver,
      'copper' => $copper
    );
    $character = array(
      'name' => $name,
      'level' => $level,
      'cls' => $cls,
      'max_hitpoints' => $max_hp,
      'damage_taken' => $dmg_taken,
      'attributes' => $attributes,
      'purse' => $purse
    );
    
    return $character;
  }

  $stmt->close();
  $mysqli->close();
}

?>