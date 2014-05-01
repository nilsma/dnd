<?php

require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Charsql extends Database {
    
    public function __construct() { }

    /**
     * A function to insert a new row of attributes, purse, and sheet in the database
     * via transactions due to key constraints in the database
     * @param $sheet array - an array holding the sheet entries
     * @param $attrs array - an array holding the attributes entries
     * @param $purse array - an array holding the purse entries
     */
    public function insertSheet($sheet, $attrs, $purse) {

      $mysqli = $this->connect();

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
	$stmt->close();

	$mysqli->commit();
	
      }   

      catch(Exception $e) {
	$mysqli->rollback();
	$mysqli->autocommit(TRUE);
	echo 'Caught exception: ' . $e->getMessage();
      }

      $mysqli->close();
    }

  }

}
?>