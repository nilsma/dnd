<?php

require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Charsql extends Database {
    
    public function __construct() { }

    public function insertSheet($sheet, $purse, $attrs) {

      try {
	$mysqli->autocommit(FALSE);

	//begin insert attrs
	$query = 'INSERT INTO attrs (id, str, str_mod, con, con_mod, dex, dex_mod, intel, intel_mod, wis, wis_mod, cha, cha_mod) VALUES(' . $attrs['str'] . ', ' . $attrs['strMod'] . ', ' . $attrs['con'] . ', ' . $attrs['conMod'] . ', ' . $attrs['dex'] . ', ' . $attrs['dexMod'] . ', ' . $attrs['intel'] . ', ' . $attrs['intelMod'] . ', ' . $attrs['wis'] . ', ' . $attrs['wisMod'] . ', ' . $attrs['cha'] . ', ' . $attrs['chaMod'] . ')';
	$result = $mysqli->query($query);
	if(!$result) {
	  $result->free();
	  throw new Exception($mysqli->error);
	}

	//begin insert purse
	$query = 'INSERT INTO purse (id, gold, silver, copper) VALUES(' . $purse['gold'] . ', ' . $purse['silver'] . ', ' . $purse['copper'] . ')';
	$result = $mysqli->query($query);
	if(!$result) {
	  $result->free();
	  throw new Exception($mysqli->error);
	}

	//begin insert sheet
	$query = 'INSERT INTO sheet (id, owner, name, level, class, attr, purse, init_mod, init_roll, hp, dmg) VALUES(null, ' . $sheet['owner'] . ', ' . $sheet['name'] . ', ' . $sheet['level'] . ', ' . $sheet['class'] . ', ' . $sheet['attr'] . ', ' . $sheet['purse'] . ', ' . $sheet['init_mod'] . ', ' . $sheet['init_roll'] . ', ' . $sheet['hp'] . ', ' . $sheet['dmg'] . ')';
	$result = $mysqli->query($query);
	if(!$result) {
	  $result->free();
	  throw new Exception($mysqli->error);
	}

      }   

      catch(Exception $e) {
	$mysqli->rollback();
	$mysqli->autocommit(TRUE);
      }

      header('Location: ' . BASE . VIEWS . 'member.php');
    }

    /**
     * A function to insert a character sheets purse to the database
     * @param $purse array - an array holding the purse entries
     */
    public function insertPurse($purse) {
      $mysqli = $this->connect();
      
      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "INSERT INTO purse (id, gold, silver, copper) VALUES (null, ?, ?, ?)";

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('iii', $purse['gold'], $purse['silver'], $purse['copper']);
	$stmt->execute();

	$stmt->close();
      }
      $mysqli->close();
    }

  }

}
?>