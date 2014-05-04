<?php

require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Membersql extends Database {
    
    public function __construct() { }

    /**
     * A function to get the details of a given users gamemasters based on the user id
     * @param $user_id int - the id of the user
     * @return $results array - an array holding the users gamemaster id and alias
     */
    public function getGamemasters($user_id) {
      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error());
	exit();
      }

      $query = "SELECT id, alias FROM gamemasters WHERE owner=?";
      $query = $mysqli->real_escape_string($query);
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($id, $alias);

	while($stmt->fetch()) {
	  $results[$id] = $alias;
	}

	return $results;

	$stmt->close();
      }
      $mysqli->close();
    }

    /**
     * A function to get the details of a given users characters based on the user id
     * @param $user_id int - the id of the user
     * @return $results array - an array holding the users characters id, name, class and level
     */
    public function getCharacters($user_id) {
      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error());
	exit();
      }

      $query = "SELECT id, name, class, level FROM sheets WHERE owner=?";
      $query = $mysqli->real_escape_string($query);
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($id, $name, $class, $level);

	while($stmt->fetch()) {
	  $results[$id] = array($name, $class, $level);
	}

	return $results;

	$stmt->close();
      }
      $mysqli->close();
    }

  }

}

?>