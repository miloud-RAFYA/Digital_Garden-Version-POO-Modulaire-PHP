<?php
class Database{
    private $host='localhost';
    private $userName='root';
    private $dbName='digitalGarden';
    private $password='';

    public $conn;

    public function getConnection(){
        try{
            $this->conn=new PDO("mysql:host=$this->host;dbname=$this->dbName;",$this->userName,$this->password);

        }catch(PDOException $e){
            
        }

        return $this->conn;
    }
}
?>