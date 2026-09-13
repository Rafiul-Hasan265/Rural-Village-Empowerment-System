<?php
class Database {
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "agri_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        if ($this->conn instanceof PDO) {
            return $this->conn;
        }

        $this->host = getenv('MYSQLHOST') ?: $this->host;
        $this->port = getenv('MYSQLPORT') ?: $this->port;
        $this->db_name = getenv('MYSQLDATABASE') ?: $this->db_name;
        $this->username = getenv('MYSQLUSER') ?: $this->username;
        $this->password = getenv('MYSQLPASSWORD') ?: $this->password;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            throw new RuntimeException(
            "Database connection failed. Verify your database configuration. Original error: " . $exception->getMessage()
            );
        }

        return $this->conn;
    }
}
?>