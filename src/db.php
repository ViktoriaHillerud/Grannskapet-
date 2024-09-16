<?php
class Database {
    private $servername = "db";
    private $username = "admin";
    private $password = "grannskapet";
    private $dbname = "grannskapet";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
