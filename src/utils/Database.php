<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'twitter';
    private $username = 'root';
    private $password = '';
    private $conn;
    private static $instance = null;

    protected function __construct() {
        $this->dbConnection();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function dbConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public static function get() {
        return self::getInstance()->conn;
    }
}
?>
