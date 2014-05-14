<?php

require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Membersql extends Database {
    
    public function __construct() { }

    /**
     * A function to check whether a given user already has a character of a given name
     * @param $user_id int - the user id of the sheet owner
     * @param $char_name string - the name of the character to check for
     * @return boolean - returns true if the given user already owns a character of that name, false otherwise
     *
    public function alreadyOwnsName($user_id, $char_name) {
      $mysqli = $this->connect();

      if($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error());
        exit();
      }

      $query = "SELECT * FROM sheets as s, users as u WHERE s.name=? AND s.owner=u.id AND u.id=?";
      $query = $mysqli->real_escape_string($query);
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
         $stmt->bind_param('si', $char_name, $user_id);
         $stmt->execute();
         $stmt->store_result();
	 $stmt->fetch();
	 $num_rows = $stmt->num_rows;

	 $stmt->close();

         if($num_rows >= 1) {
           return true;
         } else {
          return false;
         }

      }

      $mysqli->close();
      
    }
	*/

    /**
     * A function to get the details of a given users gamemasters based on the user id
     * @param $user_id int - the id of the user
     * @return $results array - an array holding an array for each the user's gamemaster with the id, alias and campaign title
     */
    public function getGamemasters($user_id) {
      $mysqli = $this->connect();
      
      if($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error());
	exit();
      }

      $query = "SELECT g.id, g.alias, c.title FROM gamemasters as g, campaigns as c WHERE g.owner=? AND g.id=c.gamemaster";
      $query = $mysqli->real_escape_string($query);
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($id, $alias, $title);

	while($stmt->fetch()) {
	  $results[] = array(
			     'id' => $id,
			     'alias' => $alias,
			     'title' => $title
			     );
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

      $query = "SELECT name, class, level FROM sheets WHERE owner=?";
      $query = $mysqli->real_escape_string($query);
      $results = array();

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($name, $class, $level);

	while($stmt->fetch()) {
	  $results[] = array(
			     'name' => $name,
			     'class' => $class,
			     'level' => $level
			     );
	}

	return $results;

	$stmt->close();
      }
      $mysqli->close();
    }

  }

}

?>
