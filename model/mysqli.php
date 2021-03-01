<?php
class DB {

    protected static $conn;
    private $host;
    private $user;
    private $pass;
    private $db_name;

    public function __construct() {
        $this->host = "localhost";
        $this->user = "root";
        $this->pass = "";
        $this->db_name = "healthcare_db";
        self::$conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        if (self::$conn->connect_error) {
            die("Failed to coonnect to the database");
        }
    }

}
?>