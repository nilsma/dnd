<?php

/**
 * A function to build a HTML representation of the given character
 * @param $char array - the array of the characters properties
 * @return $result string - a string of HTML code
 */
function buildCharacter($char) {
  $html = '';

  $name = '		<h2 class="char_name">' . $char['name'] . '</h2>' . "\n";
  $hitpoints = '	    <p class="hitpoints">' . $char['damage_taken'] . ' / ' . $char['max_hitpoints'] . '</p>' . "\n";
  $attributes = buildAttributes($char['attributes']);

  $html = $html . '<div class="party_member">' . "\n";
  $html = $html . '	  <div class="personalia">' . "\n";
  $html = $html . $name;
  $html = $html . $hitpoints;
  $html = $html . '	  </div>' . "\n";
  $html = $html . $attributes;
  $html = $html . '  </div>' . "\n";
  
  return $html;
  
}

function buildAttributes($array) {
  $html = '';

  $table = '<table>' . "\n";
  $table = '  	      <tr>' . "\n";
  $table = $table . '            <td>Strength</td><td class="value">' . $array['str'] . '</td>'. "\n";
  $table = $table . '            <td>Constitution</td><td class="value">' . $array['con'] . '</td>' . "\n";
  $table = $table . '            <td>Dexterity</td><td class="value">' . $array['dex'] . '</td>' . "\n";
  $table = $table . '            <td>Intelligence</td><td class="value">' . $array['intel'] . '</td>' . "\n";
  $table = $table . '            <td>Wisdom</td><td class="value">' . $array['wis'] . '</td>' . "\n";
  $table = $table . '            <td>Charisma</td><td class="value">' . $array['cha'] . '</td>' . "\n";
  $table = $table . '          </tr>' . "\n";
  $table = $table . '        </table>' . "\n";

  $html = $html . '      <div class="char_attributes">' . "\n";
  $html = $html . '        <table>' . "\n";
  $html = $html . $table;
  $html = $html . '	</div>' . "\n";

  return $html;

}

/**
 * A function to display all the member characters of a party on the 
 * gamemaster screen
 * @param $mysqli mysqli - the database connection object
 * @param $ids array  - an array of int holding the members sheets.id
 */
function buildGMScreen($mysqli, $ids) {
  $result = '';
  foreach($ids as $id) {
    $char_array = getCharacter($mysqli, $id);
    $character = buildCharacter($char_array);
    $result = $result . $character;
  }

  return $result;

}

/**
 * A function to get the sheets.id value of all members of the given party
 * @param $mysqli mysqli - the database connection object
 * @param $partyid int - the id of the party of which to the member ids
 * @return $ids array - an array holding the ids of the party's members
 */
function getPartyMembersId($mysqli, $party_id) {
  if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
  }

  $stmt = $mysqli->prepare("SELECT s.id FROM sheets as s, members as m, parties as p, gamemasters as g WHERE s.id=m.sheet AND m.party=p.id AND p.id=?");

  $stmt->bind_param('i', $party_id);

  $stmt->execute();
  $stmt->bind_result($id);
  $array = array();
  while($stmt->fetch()) {
    $array[] = $id;
  }

  return $array;

  $stmt->close();
  $mysqli->close();
}

/**
 * A function to get the sheet of the given character
 * @param $mysqli mysqli - the database connection object
 * @param $char_id int - the sheets.id of the character to retrieve
 * @return $character array - an array containing the characters personalia, attributes as an array 
 * 	   and purse as an array 
 */
function getCharacter($mysqli, $char_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $stmt = $mysqli->prepare("SELECT s.name, s.level, s.class, s.max_hitpoints, s.damage_taken, p.gold, p.silver, p.copper, a.str, a.con, a.dex, a.intel, a.wis, a.cha FROM sheets as s, purse as p, attributes as a, users as u WHERE a.id=s.attributes AND p.id=s.purse AND s.owner=u.id AND u.id=?");
  $stmt->bind_param('i', $char_id);

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