<?php
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false) {
  header('Location: http://127.0.1.1/dnd/html/');
}

if(!class_exists('Utils')) {

  class Utils {

    private static $initialized = false;

    private static function initialize() {
      if(self::initialized) {
	return;
      }

      self::$initialized = true;
    }

    /**
     * A function that takes a password and hashes it
     * @param string password - the given password to hash
     * @return string hashed - returns the hashed password
     */
    function hashPassword($password) {
      $cost = 10;
      $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
      $salt = sprintf("$2a$%02d$", $cost) . $salt;
      $hashed = crypt($password, $salt);
      return $hashed;
    }
    
    /**
     * A function to handle replacing of parameters for the htmlspecialchars function.
     * Credits to Mike Robinson [http://php.net/htmlspecialchars]
     * @param string $string - the string to wash
     * @return string - the washed string
     */
    public static function html($string) {
      //TODO define constants elsewhere
      define('CHARSET', 'UTF-8');
      define('REPLACE_FLAGS', ENT_QUOTES | 'UTF-8');
      
      return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
    }

    /**
     * A function to check if the password is 6 characters or longer, maximum 16 characters,
     * has at least one letter, has at least one number, and at least one uppercase letter
     * @param string $password - the password to check
     * @return boolean - returns false if the password does not comply with the conditions, true otherwise
     */
    public static function validatePassword($password) {
      $validate = false;
      if((strlen($password) >= 6) && (strlen($password) <= 16) && (preg_match("#[a-z]+#", $password))  && (preg_match("#[0-9]+#", $password)) && (preg_match("#[A-Z]+#", $password))) {
	$validate = true;
      }
      return $validate;
    }
  }
}


?>