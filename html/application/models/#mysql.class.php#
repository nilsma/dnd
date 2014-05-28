<?php
/**
 * A models file for the DND Helper that defines and handles functions related to 
 * registering a new user in the system
 * @author Nils Martinussen
 * @created 2014-05-25
 */
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: http://127.0.1.1/dnd/html/');
}

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

      $query = "INSERT INTO users VALUES(NULL, ?, ?, ?)";
      $query = $mysqli->real_escape_string($query);

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

      $query = "SELECT password FROM users WHERE id=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();
      
      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
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

      $query = "SELECT password FROM users WHERE username=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

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
     * @param $username string - the email address to check for
     * @return boolean - returns true if it exists, false otherwise
     */
    public function usernameExistence($username) {
      $mysqli = $this->connect();

      $query = "SELECT id FROM users WHERE username=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

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

      $query = "SELECT id FROM users WHERE email=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

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
     * A function to set the member's new name
     * @param $user_id int - the member's user id
     * @param $new_name string - the member's new name
     */
    public function setUsername($user_id, $new_name) {
      $mysqli = $this->connect();

      $query = "UPDATE users SET username=? WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('si', $new_name, $user_id);
	$stmt->execute();
      }
	
      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to set the member's new email address
     * @param $user_id int - the member's user id
     * @param $new_email string - the member's new email
     */
    public function setEmail($user_id, $new_email) {
      $mysqli = $this->connect();

      $query = "UPDATE users SET email=? WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('si', $new_email, $user_id);
	$stmt->execute();
      }
	
      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to set the member's new password
     * @param $user_id int - the member's user id
     * @param $hashed string - the member's hashed new password
     */
    public function setPassword($user_id, $hashed) {
      $mysqli = $this->connect();

      $query = "UPDATE users SET password=? WHERE id=?";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	printf("Failed to prepare statement!");
      } else {
	$stmt->bind_param('si', $hashed, $user_id);
	$stmt->execute();
      }
	
      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to get the given users username based on the users id
     * @param $user_id int - the user id to get the username for
     * @return $username string - the username for the given user_id
     */
    public function getUsername($user_id) {
      $mysqli = $this->connect();

      $query = "SELECT username FROM users WHERE id=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($username);
	$stmt->fetch();
	
	return $username;
      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to get the given user's email based on the users id
     * @param $user_id int - the user id to get the email for
     * @return $email string - the email for the given user_id
     */
    public function getUserEmail($user_id) {
      $mysqli = $this->connect();

      $query = "SELECT email FROM users WHERE id=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($email);
	$stmt->fetch();
	
	return $email;
      }

      $stmt->close();
      $mysqli->close();
    }

    /**
     * A function to get the given users user id based on the username
     * @param $username string - the username to get the password for
     * @return int id - the id for the given username
     */
    public function getUserId($username) {
      $mysqli = $this->connect();

      $query = "SELECT id FROM users WHERE username=? LIMIT 1";
      $query = $mysqli->real_escape_string($query);

      $stmt = $mysqli->stmt_init();

      if(!$stmt->prepare($query)) {
	print("Failed to prepare statement!");
      } else {
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($id);
	$stmt->fetch();

	$stmt->close();

	return $id;
      }

      $mysqli->close();
    }

  }

}


?>