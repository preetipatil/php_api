<?php
// mysql database connection
class DatabaseService{

    // database credentials
    private $host = "localhost:3306";
    private $db_name = "company";
    private $username = "root";
    private $password = "";
    public  $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
