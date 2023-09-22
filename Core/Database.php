<?php


class Database {
    private $host = 'localhost'; // For the first database
    private $username = 'root';
    private $password = '@Alex1234';
    private $database = 'victory_farms';

    private $database2 = 'ussdlogs'; // For the second database

    protected $conn1; // Connection for the first database
    protected $conn2; // Connection for the second database

    // Constructor to establish both database connections
    public function __construct() {
        $this->conn1 = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn1->connect_errno) {
            echo 'Failed to connect to Database 1: (' . $this->conn1->connect_errno . ') ' . $this->conn1->connect_error;
            exit();
        }

        $this->conn2 = new mysqli($this->host, $this->username, $this->password, $this->database2);
        if ($this->conn2->connect_errno) {
            echo 'Failed to connect to Database 2: (' . $this->conn2->connect_errno . ') ' . $this->conn2->connect_error;
            exit();
        }
    }

    // You can add methods here to perform database operations on both connections
}