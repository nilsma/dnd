<?php

require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Membersql extends Database {
    
    public function __construct() { }

    /**
     * A function to get the details of a given user based on the user id
     * @param $id int - the id of the user
     * @return $results array - an array holding the users id, username and email
     */
    public function getCharacters($id) {
      $mysqli = $this->connect();
      
      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "SELECT id, name, class, level FROM sheets WHERE owner=?";
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $id);
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