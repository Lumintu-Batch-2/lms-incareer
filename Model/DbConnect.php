<?php

class DbConnect
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "incareer2";
    private $conn;

    public function connect()
    {
        try {
            // Initialize database connection
            $this->conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
    public function close()
    {
        $this->conn = null;
    }
}
