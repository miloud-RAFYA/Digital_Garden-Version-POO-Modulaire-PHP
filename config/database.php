<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "digitalGarden";

    private $conn = null;
    public function getConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);

        } catch (PDOException $e) {
            echo 'error' . $e->getMessage();
        }

        return $this->conn;
    }
}

?>