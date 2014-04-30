<?php

if(!class_exists('Database')) {

  class Database {

    private $host = 'localhost';
    private $username = 'root';
    private $password = '8kMkyg()';
    private $database = 'dnd';

    public function __construct() { }

    public function connect() {
      return new mysqli($this->host, $this->username, $this->password, $this->database);
    }

  }
}

?>