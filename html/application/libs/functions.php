<?php
/**                                                                                                                                   
 * A function to handle replacing of parameters for the htmlspecialchars function.                                                    
 * Credits to Mike Robinson [http://php.net/htmlspecialchars]                                                                         
 * @param string $string - the string to wash                                                                                         
 * @return string $washed - the washed string                                                                                         
 */
function html($string) {
  return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}

/**
 * A function to build a HTML representation of the given character
 * @param $char array - the array of the characters properties
 * @return $result string - a string of HTML code
 */
function buildCharacter($char) {
  $html = '';

  $name = '		<h2 class="char_name">' . $char['name'] . '</h2>' . "\n";
  $hp = '	    <p class="hitpoints">HP: ' . $char['dmg'] . ' / ' . $char['hp'] . '</p>' . "\n";
  $attrs = buildAttributes($char['attrs']);
  $purse = buildPurse($char['purse']);

  $html = $html . '<div class="campaign_member">' . "\n";
  $html = $html . '	  <div class="personalia">' . "\n";
  $html = $html . $name;
  $html = $html . $hp;
  $html = $html . '        <p class="initiative">Initiative: <span class="init_roll">' . $char['init_roll'] . '</span></p>' . "\n";
  $html = $html . '	  </div>' . "\n";
  $html = $html . '       <div class="char_attributes">' . "\n";
  $html = $html . '         <h3 class="attr_heading">Attributes</h3>' . "\n";
  $html = $html . $attrs;
  $html = $html . '       </div>' . "\n";
  $html = $html . '       <div class="char_purse">' . "\n";
  $html = $html . '         <h3 class="purse_heading">Purse</h3>' . "\n";
  $html = $html . $purse;
  $html = $html . '       </div>' . "\n";
  $html = $html . '  </div>' . "\n";
  
  echo $html;
//  return $html;
  
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
 * A function to display all the member characters of a campaign on the 
 * gamemaster screen
 * @param $mysqli mysqli - the database connection object
 * @param $ids array  - an array of int holding the members sheets.id
 */
function buildGMScreen($mysqli, $ids) {
  $result = '';
  foreach($ids as $id) {
    $char_array = getCharacter($mysqli, $id);
    $character = buildCharacter($char_array);
//    $result = $result . $character;
  }

//  return $result;

}

/**
 * A function to get the sheets.id value of all members of the given campaign
 * @param $mysqli mysqli - the database connection object
 * @param $campaign_id int - the id of the campaign of which to the member ids
 * @return $ids array - an array holding the ids of the campaign's members
 */
function getCampaignMembersIds($mysqli, $campaign_id) {
  if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
  }

  $stmt = $mysqli->prepare("SELECT s.id FROM sheets as s, members as m, campaigns as c, gamemasters as g WHERE s.id=m.sheet AND m.campaign=c.id AND c.id=?");

  $stmt->bind_param('i', $campaign_id);

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

  $stmt = $mysqli->prepare("SELECT s.name, s.level, s.class, s.init_mod, s.init_roll, s.hp, s.dmg, a.str, a.str_mod, a.con, a.con_mod, a.dex, a.dex_mod, a.intel, a.intel_mod, a.wis, a.wis_mod, a.cha, a.cha_mod, p.gold, p.silver, p.copper FROM sheets as s, purse as p, attrs as a, users as u WHERE a.id=s.attr AND p.id=s.purse AND s.owner=u.id AND u.id=?");
  $stmt->bind_param('i', $char_id);

  $stmt->execute();
  $stmt->bind_result($name, $level, $cls, $init_mod, $init_roll, $hp, $dmg, $str, $str_mod, $con, $con_mod, $dex, $dex_mod, $intel, $intel_mod, $wis, $wis_mod, $cha, $cha_mod, $gold, $silver, $copper);
  $character = array();
  while($stmt->fetch()) {
    $attrs = array(
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
      'init_mod' => $init_mod,
      'init_roll' => $init_roll,
      'hp' => $hp,
      'dmg' => $dmg,
      'attrs' => $attrs,
      'purse' => $purse
    );
    
    return $character;
  }

  $stmt->close();
  $mysqli->close();
}

?>
