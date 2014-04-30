<?php
require_once 'database.class.php';

if(!class_exists('Mysql')) {

  class Mysql extends Database {
    
    public function __construct() { }

    /**
     * A function to add a new user to the users table in the database
     * @param string username - the username to add to the database
     * @param string password - the usernames corresponding password
     * @return boolean - returns true if the given data was added to the database, false otherwise
     */
    function registerUser($username, $email, $password) {
      $mysqli = $this->connect();
      $hashed = Utils::hashPassword($password);

      if(mysqli_connect_errno()) {
	printf("Connection failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "INSERT INTO users VALUES(NULL, ?, ?, ?)";
      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('sss',$username, $email, $hashed);
	$stmt->execute();
      }
      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to get the password of a given user
     * @param $id int - the id of the user to get the password for
     * @return $pwd string - the users password
     */
    public function getPassword($id) {
      $mysqli = $this->connect();
      
      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "SELECT password FROM users WHERE id=? LIMIT 1";

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($pwd);
	$stmt->fetch();
	
	return $pwd;
      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to check whether a given username and password mathces
     * that users entry in the database.
     * @return boolean - returns true if there is a match, false otherwise
     */
    public function checkLogin($username, $password) {
      $mysqli = $this->connect();

      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "SELECT password FROM users WHERE username=? LIMIT 1";

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$stmt->bind_result($db_pwd);
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	if($num_rows >= 1) {
	  while($stmt->fetch()) {
	    if(crypt($password, $db_pwd) == $db_pwd) {
	      return true;
	    } else {
	      return false;
	    }
	  }
	} else {
	  return False;
	}
	$stmt->close();
      }
      $mysqli->close();
    }

    /**
     * A function to check whether a given username already exists in the database
     * @param $email string - the email address to check for
     * @return boolean - returns true if it exists, false otherwise
     */
    public function usernameExistence($username) {
      $mysqli = $this->connect();

      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "SELECT id FROM users WHERE username=? LIMIT 1";

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$stmt->bind_result($db_id);
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	if($num_rows >= 1) {
	  return true;
	} else {
	  return false;
	}
	$stmt->close();
      }
      $mysqli->close();
    }

    /**
     * A function to check whether a given email already exists in the database
     * @param $email string - the email address to check for
     * @return boolean - returns true if it exists, false otherwise
     */
    public function emailExistence($email) {
      $mysqli = $this->connect();

      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "SELECT id FROM users WHERE email=? LIMIT 1";

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('s',$email);
	$stmt->execute();
	$stmt->bind_result($db_id);
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	if($num_rows >= 1) {
	  return true;
	} else {
	  return false;
	}
	$stmt->close();
      }
      $mysqli->close();
    }

    /**
     * A function to get the given users user id based on the username
     * @param $username string - the username to get the password for
     * @return int id - the id for the given username
     */
    public function getUserId($username) {
      $mysqli = $this->connect();
      
      if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
      }

      $query = "SELECT id FROM users WHERE username=? LIMIT 1";

      if($stmt = $mysqli->prepare($query)) {
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->fetch();
	
	return $id;
      }

      $stmt->close();
      $mysqli->close();
    }

  }

}


?>