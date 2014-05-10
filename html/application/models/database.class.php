<?php

if(!class_exists('Database')) {

  class Database {

    private $host = 'localhost';
    private $username = 'sec_user';
    private $password = 'y3MgB7dAMhdwGQWc';
    private $database = 'dnd';

    public function __construct() { }

    public function connect() {
      return new mysqli($this->host, $this->username, $this->password, $this->database);
    }

  }
}

?>