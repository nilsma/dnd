<?php

require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Charsql extends Database {
    
    public function __construct() { }

    /**
     * A function to build a HTML representation of the given character's data
     * @param $characterData array - a multidimensional assoc array holding the character's data
     * @return $characterHTML string - a string representation of the character's data as HTML
     */
    public function buildCharacter($characterData) {
      $sheet = $characterData['sheet'];
      $attrs = $characterData['attrs'];
      $purse = $characterData['purse'];

      $sheetHTML = $this->buildSheet($sheet);
      $attrsHTML = $this->buildAttrs($attrs);
      $purseHTML = $this->buildPurse($purse);

      $characterHTML = $sheetHTML . $attrsHTML . $purseHTML;
      
      return $characterHTML;

    }

    /**
     * A function to build a HTML representation of the given character's personalia-sheet data
     * @param $sheet array - an assoc array holding the personalia-sheet data
     * @return $html string - a string representation of the personalia-sheet data
     */
    public function buildSheet($sheet) {

      $html = '';
      
      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Personalia</legend>' . "\n";
      $html = $html . '<form name="character" action="" method="POST">' . "\n";
      $html = $html . '<label for="name">Name:</label><input name="name" id="name" type="text" maxlength="30" value="' . $sheet['name'] . '" required>' . "\n";
      $html = $html . '<label for="level">Level:</label><input name="level" id="level" type="number" value="' . $sheet['level'] . '" required>' . "\n";
      $html = $html . '<label for="class">Class:</label><input name="class" id="class" type="text" maxlength="30" value="' . $sheet['class'] . '" required>' . "\n";
      $html = $html . '<label for="hitpoints">HP:</label><input name="hp" id="hitpoints" type="number" value="' . $sheet['hp'] . '" required>' . "\n";
      $html = $html . '<label for="initiativeRoll">Initiative Roll:</label><input name="init_roll" id="initiativeRoll" type="number" value="' . $sheet['init_roll'] . '" required>' . "\n";
      $html = $html . '<label for="modifier">Modifier:</label><input name="init_mod" id="modifier" type="number" value="' . $sheet['init_mod'] . '" required>' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";

      return $html;
      
    }
    
    /**
     * A function to build a HTML representation of the given character's attributes data
     * @param $attrs array - an assoc array holding the attributes data
     * @return $html string - a string representation of the attributes data
     */
    public function buildAttrs($attrs) {
      $html = '';
      
      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Attributes</legend>' . "\n";
      $html = $html . '<form name="attrs" action="" method="POST">' . "\n";
      $html = $html . '<label for="strength">STR:</label><input name="str" id="strength" type="number" value="' . $attrs['str'] . '" required>' . "\n";
      $html = $html . '<label for="strength_modifier">MOD:</label><input name="str_mod" id="strength_modifier" type="number" value="' . $attrs['strMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="constitution">CON:</label><input name="con" id="constitution" type="number" value="' . $attrs['con'] . '" required>' . "\n";
      $html = $html . '<label for="constitution_modifier">MOD:</label><input name="con_mod" id="constitution_modifier" type="number" value="' . $attrs['conMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="dexterity">DEX:</label><input name="dex" id="dexterity" type="number" value="' . $attrs['dex'] . '" required>' . "\n";
      $html = $html . '<label for="dexterity_modifier">MOD:</label><input name="dex_mod" id="dexterity_modifier" type="number" value="' . $attrs['dexMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="intelligence">INT:</label><input name="intel" id="intelligence" type="number" value="' . $attrs['intel'] . '" required>' . "\n";
      $html = $html . '<label for="intelligence_modifier">MOD:</label><input name="intel_mod" id="intelligence_modifier" type="number" value="' . $attrs['intelMod'] . '" required>' . "\n" . '<br/>';
      $html = $html . '<label for="wisdom">WIS:</label><input name="wis" id="wisdom" type="number" value="' . $attrs['wis'] . '" required>' . "\n";
      $html = $html . '<label for="wisdom_modifier">MOD:</label><input name="wis_mod" id="wisdom_modifier" type="number" value="' . $attrs['wisMod'] . '" required>' . "\n" . '<br/>';
            $html = $html . '<label for="charisma">CHA:</label><input name="cha" id="charisma" type="number" value="' . $attrs['cha'] . '" required>' . "\n";
      $html = $html . '<label for="charisma_modifier">MOD:</label><input name="cha_mod" id="charisma_modifier" type="number" value="' . $attrs['chaMod'] . '" required>' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";
      
      return $html;
    }

    /**
     * A function to build a HTML representation of the given character's purse data
     * @param $purse array - an assoc array holding the purse data
     * @return $html string - a string representation of the purse data
     */
    public function buildPurse($purse) {
      $html = '';

      $html = $html . '<fieldset>' . "\n";
      $html = $html . '<legend>Purse</legend>' . "\n";
      $html = $html . '<form name="purse" action="" method="POST">' . "\n";
      $html = $html . '<label for="gold">Gold:</label><input name="gold" id="gold" type="number" value="' . $purse['gold'] . '" required>' . "\n";
      $html = $html . '<label for="silver">Silver:</label><input name="silver" id="silver" type="number" value="' . $purse['silver'] . '" required>' . "\n";
      $html = $html . '<label for="copper">Copper:</label><input name="copper" id="copper" type="number" value="' . $purse['copper'] . '" required>' . "\n";
      $html = $html . '</form>' . "\n";
      $html = $html . '</fieldset>' . "\n";

      return $html;

    }

    /**
     * A function to get a given characters sheet, attributes, and purse
     * from the given sheet id
     * @param $sheet_id int - the sheet id for the given character
     * @return $character array - a multidimensional assoc array holding 
     *                          - the characters data in subsequent arrays
     */
    public function getCharacter($sheet_id) {
      $character = array();
      $sheet = array();
      $attrs = array();
      $purse = array();
      
      $sheet = $this->getSheet($sheet_id);
      $attrs = $this->getAttrs($sheet['attr']);
      $purse = $this->getPurse($sheet['purse']);

      $character['sheet'] = $sheet;
      $character['attrs'] = $attrs;
      $character['purse'] = $purse;
      
      return $character;
    }

    /**
     * A function to get the given sheets purse contents
     * @param $sheet_id int - the sheet id to get the attributes for
     * @return $purse array - an assoc array holding the attributes
     */
    public function getSheet($sheet_id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT s.owner, s.name, s.level, s.class, s. attr, s.purse, s.hp, s.dmg, s.init_mod, s.init_roll FROM sheets as s WHERE s.id=?";

      //      $result = array();

      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $sheet_id);
	$stmt->execute();
	$stmt->bind_result($owner, $name, $level, $class, $attr, $purse, $hp, $dmg, $init_mod, $init_roll);
	$stmt->fetch();

	$stmt->close();
	
	$result = array(
			'owner' => $owner,
			'name' => $name,
			'level' => $level,
			'class' => $class,
			'attr' => $attr,
			'purse' => $purse,
			'hp' => $hp,
			'dmg' => $dmg,
			'init_mod' => $init_mod,
			'init_roll' => $init_roll
			);

      }
      
      $mysqli->close();
      return $result;
    }

    /**
     * A function to get the given sheets attributes
     * @param $sheet_id int - the sheet id to get the attributes for
     * @return $attrs array - an assoc array holding the attributes
     */
    public function getAttrs($id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT str, str_mod, con, con_mod, dex, dex_mod, intel, intel_mod, wis, wis_mod, cha, cha_mod FROM attrs WHERE id=?";

      //      $result = array();

      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($str, $strMod, $con, $conMod, $dex, $dexMod, $intel, $intelMod, $wis, $wisMod, $cha, $chaMod);
	$stmt->fetch();

	$stmt->close();
	
	$result = array(
			'str' => $str,
			'strMod' => $strMod,
			'con' => $con,
			'conMod' => $conMod,
			'dex' => $dex,
			'dexMod' => $dexMod,
			'intel' => $intel,
			'intelMod' => $intelMod,
			'wis' => $wis,
			'wisMod' => $wisMod,
			'cha' => $cha,
			'chaMod' => $chaMod
			);

      }
      
      $mysqli->close();
      return $result;
      
    }

    /**
     * A function to get the given sheets purse contents
     * @param $sheet_id int - the sheet id to get the attributes for
     * @return $purse array - an assoc array holding the attributes
     */
    public function getPurse($id) {
      $mysqli = $this->connect();

      if($mysqli->connect_error) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $query = "SELECT gold, silver, copper FROM purse WHERE id=?";

      //      $result = array();

      $query = $mysqli->real_escape_string($query);

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($gold, $silver, $copper);
	$stmt->fetch();

	$stmt->close();
	
	$result = array(
			'gold' => $gold,
			'silver' => $silver,
			'copper' => $copper
			);

      }
      
      $mysqli->close();
      return $result;
    }

    /**
     * A function to insert a new row of attributes, purse, and sheet in the database
     * via transactions due to key constraints in the database
     * @param $sheet array - an array holding the sheet entries
     * @param $attrs array - an array holding the attributes entries
     * @param $purse array - an array holding the purse entries
     * @return $sheet_id int - the sheet id of the inserted character sheet
     */
    public function insertSheet($sheet, $attrs, $purse) {

      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connection failed: %s\n", $mysqli->connect_error);
      }

      $sheet_id = null;

      try {
	$mysqli->autocommit(FALSE);

	//begin purse
	$gold = $purse['gold'];
	$silver = $purse['silver'];
	$copper = $purse['copper'];
	$query = 'INSERT INTO purse VALUES(null,?,?,?)';
       	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('iii', $gold, $silver, $copper);
	$stmt->execute();
	$purse_id = $mysqli->insert_id;
	$stmt->close();

	//begin attrs
	$str = $attrs['str'];
	$strMod = $attrs['strMod'];
	$con = $attrs['con'];
	$conMod = $attrs['conMod'];
	$dex = $attrs['dex'];
	$dexMod = $attrs['dexMod'];
	$intel = $attrs['intel'];
	$intelMod = $attrs['intelMod'];
	$wis = $attrs['wis'];
	$wisMod = $attrs['wisMod'];
	$cha = $attrs['cha'];
	$chaMod = $attrs['chaMod'];
	$query = 'INSERT INTO attrs VALUES(null,?,?,?,?,?,?,?,?,?,?,?,?)';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('iiiiiiiiiiii', $str, $strMod, $con, $conMod, $dex, $dexMod, $intel, $intelMod, $wis, $wisMod, $cha, $chaMod);
	$stmt->execute();
	$attrs_id = $mysqli->insert_id;
	$stmt->close();

	//begin sheet
	$owner = $_SESSION['user_id'];
	$name = $sheet['name'];
	$level = $sheet['level'];
	$class = $sheet['class'];
	$hp = $sheet['hp'];
	$dmg = $sheet['dmg'];
	$init_mod = $sheet['init_mod'];
	$init_roll = $sheet['init_roll'];
	$query = 'INSERT INTO sheets VALUES(null,?,?,?,?,?,?,?,?,?,?)';
	$query = $mysqli->real_escape_string($query);
	if(!$stmt = $mysqli->prepare($query)) {
	  throw new Exception($mysqli->error);
	}
	$stmt->bind_param('isisiiiiii', $owner, $name, $level, $class, $attrs_id, $purse_id, $hp, $dmg, $init_mod, $init_roll);
	$stmt->execute();
	$sheet_id = $mysqli->insert_id;
	$stmt->close();

	$mysqli->commit();
	
      }   

      catch(Exception $e) {
	$mysqli->rollback();
	$mysqli->autocommit(TRUE);
	echo 'Caught exception: ' . $e->getMessage();
      }

      $mysqli->close();
      return $sheet_id;
    }
    

  }

}
?>