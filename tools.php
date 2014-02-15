<?php

/**
 * A function to build a HTML representation of the given character
 * @param $char array - the array of the characters properties
 * @return $result string - a string of HTML code
 */
function buildCharacter($char) {
  $html = '';

  $name = '		<h2 class="char_name">' . $char['name'] . '</h2>' . "\n";
  $hitpoints = '	    <p class="hitpoints">HP: ' . $char['damage_taken'] . ' / ' . $char['max_hitpoints'] . '</p>' . "\n";
  $attributes = buildAttributes($char['attributes']);
  $purse = buildPurse($char['purse']);

  $html = $html . '<div class="party_member">' . "\n";
  $html = $html . '	  <div class="personalia">' . "\n";
  $html = $html . $name;
  $html = $html . $hitpoints;
  $html = $html . '        <p>Initiative: ' . $char['initiative_roll'] . '</p>' . "\n";
  $html = $html . '	  </div>' . "\n";
  $html = $html . '       <div class="char_attributes">' . "\n";
  $html = $html . $attributes;
  $html = $html . '       </div>' . "\n";
  $html = $html . '       <div class="char_purse">' . "\n";
  $html = $html . $purse;
  $html = $html . '       </div>' . "\n";
  $html = $html . '  </div>' . "\n";
  
  return $html;
  
}

/**
 * A function to build a table of the characters attributes
 * @param $array array - an assosciative array holding the characters attributes
 * @return $html string - a string of HTML code
 */
function buildPurse($array) {

  $table = '';
  $table = $table . '<tr>' . "\n";
  $table = $table . '<td>Gold<td><td class="purse_amount">' . $array['gold'] . "\n";
  $table = $table . '</tr>' . "\n";
  $table = $table . '<tr>' . "\n";
  $table = $table . '<td>Silver<td><td class="purse_amount">' . $array['silver'] . "\n";
  $table = $table . '</tr>' . "\n";
  $table = $table . '<tr>' . "\n";
  $table = $table . '<td>Copper<td><td class="purse_amount">' . $array['copper'] . "\n";
  $table = $table . '</tr>' . "\n";

  $html = '';
  $html = $html . '<table>' . "\n";
  $html = $html . $table;
  $html = $html . '</table>' . "\n";

  return $html;
}

/**
 * A function to build a table of the characters attributes
 * @param $array array - an assosciative array holding the characters attributes
 * @return $html string - a string of HTML code
 */
function buildAttributes($array) {

  $headers = '';
  $headers = $headers . '		  <tr>' . "\n";
  $headers = $headers . '		    <th></th>' . "\n";
  $headers = $headers . '		    <th></th>' . "\n";
  $headers = $headers . '		    <th>Mod</th>' . "\n";
  $headers = $headers . '		  </tr>' . "\n";

  $table = '';
  $table = $table . '  	      <tr>' . "\n";
  $table = $table . '            <td>STR</td><td class="value">' . $array['str'] . '</td><td>' . $array['str_mod']  . '</td>'. "\n";
  $table = $table . '         </tr>' . "\n";
  $table = $table . '         <tr>' . "\n";
  $table = $table . '            <td>CON</td><td class="value">' . $array['con'] . '</td><td>' . $array['con_mod'] . '</td>' . "\n";
  $table = $table . '         </tr>' . "\n";
  $table = $table . '         <tr>' . "\n";
  $table = $table . '            <td>DEX</td><td class="value">' . $array['dex'] . '</td><td>' . $array['dex_mod'] . '</td>' . "\n";
  $table = $table . '         </tr>' . "\n";
  $table = $table . '         <tr>' . "\n";
  $table = $table . '            <td>INT</td><td class="value">' . $array['intel'] . '</td><td>' . $array['intel_mod'] . '</td>' . "\n";
  $table = $table . '         </tr>' . "\n";
  $table = $table . '         <tr>' . "\n";
  $table = $table . '            <td>WIS</td><td class="value">' . $array['wis'] . '</td><td>' . $array['wis_mod'] . '</td>' . "\n";
  $table = $table . '         </tr>' . "\n";
  $table = $table . '         <tr>' . "\n";
  $table = $table . '            <td>CHA</td><td class="value">' . $array['cha'] . '</td><td>' . $array['cha_mod'] . '</td>' . "\n";
  $table = $table . '          </tr>' . "\n";

  $html = '';
  $html = $html . '        <table>' . "\n";
  $html = $html . $headers;
  $html = $html . $table;
  $html = $html . '        </table>' . "\n";

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

  $stmt = $mysqli->prepare("SELECT s.name, s.level, s.class, s.max_hitpoints, s.damage_taken, s.initiative_mod, s.initiative_roll, p.gold, p.silver, p.copper, a.str, a.str_mod, a.con, a.con_mod, a.dex, a.dex_mod, a.intel, a.intel_mod, a.wis, a.wis_mod, a.cha, a.cha_mod FROM sheets as s, purse as p, attributes as a, users as u WHERE a.id=s.attributes AND p.id=s.purse AND s.owner=u.id AND u.id=?");
  $stmt->bind_param('i', $char_id);

  $stmt->execute();
  $stmt->bind_result($name, $level, $cls, $max_hp, $dmg_taken, $initiative_mod, $initiative_roll, $gold, $silver, $copper, $str, $str_mod, $con, $con_mod, $dex, $dex_mod, $intel, $intel_mod, $wis, $wis_mod, $cha, $cha_mod);
  $character = array();
  while($stmt->fetch()) {
    $attributes = array(
      'str' => $str,
      'str_mod' => $str_mod,
      'con' => $con,
      'con_mod' => $con_mod,
      'dex' => $dex,
      'dex_mod' => $dex_mod,
      'intel' => $intel,
      'intel_mod' => $intel_mod,
      'wis' => $wis,
      'wis_mod' => $wis_mod,
      'cha' => $cha,
      'cha_mod' => $cha_mod
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
      'initiative_mod' => $initiative_mod,
      'initiative_roll' => $initiative_roll,
      'attributes' => $attributes,
      'purse' => $purse
    );
    
    return $character;
  }

  $stmt->close();
  $mysqli->close();
}

?>