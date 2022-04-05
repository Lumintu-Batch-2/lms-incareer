<?php

class DbConnect
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "incareer2";

    public function connect()
    {
        try {
            // Initialize database connection
            $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}
