<?php
/**
 * A models file for the DND Helper that defines and handles functions related to 
 * operation on and by the application's members (users)
 * @author Nils Martinussen
 * @created 2014-05-25
 */
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: http://127.0.1.1/dnd/html/');
}

require_once 'database.class.php';

if(!class_exists('Membersql')) {

  class Membersql extends Database {
    
    public function __construct() { }

    /**
     * A function to check whether a given user already has a character of a given name
     * @param $user_id int - the user id of the sheet owner
     * @param $char_name string - the name of the character to check for
     * @return boolean - returns true if the given user already owns a character of that name, false otherwise
     */
    public function alreadyOwnsName($user_id, $char_name) {
      $mysqli = $this->connect();


      $query = "SELECT * FROM sheets as s, users as u WHERE s.name=? AND s.owner=u.id AND u.id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {

	$stmt->bind_param('si', $char_name, $user_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$num_rows = $stmt->num_rows;

	if($num_rows >= 1) {
	  return true;
	} else {
          return false;
	}

      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to get the details of a given users gamemasters based on the user id
     * @param $user_id int - the id of the user
     * @return $results array - an array holding an array for each the user's gamemaster with the id, alias and campaign title
     */
    public function getGamemasters($user_id) {
      $mysqli = $this->connect();

      $query = "SELECT g.id, g.alias, c.title FROM gamemasters as g, campaigns as c WHERE g.owner=? AND g.id=c.gamemaster";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$results = array();

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
      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to get the details of a given users characters based on the user id
     * @param $user_id int - the id of the user
     * @return $results array - an array holding the users characters id, name, class and level
     */
    public function getCharacters($user_id) {
      $mysqli = $this->connect();

      $query = "SELECT name, class, level FROM sheets WHERE owner=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$results = array();

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
      }

      $stmt->close();
      $mysqli->close();
    }
  }
}

?>
