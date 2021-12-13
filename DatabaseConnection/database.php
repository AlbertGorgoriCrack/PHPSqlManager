<?php

class Database
{
    private $_connection;
    private static $_instance; //The single instance
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "";

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function setDatabaseISc()
    {
        $sql = "SELECT schema_name FROM information_schema.schemata";
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, "information_schema");
        return $this->_connection->query($sql);
    }

    // Constructor
    private function __construct()
    {
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    // Get mysqli connection
    public function getConnection()
    {

        return $this->_connection;
    }

    public function setNewQuery($queryUser, $newDB)
    {
        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $newDB);
        return $this->_connection->query($queryUser);
    }
}
