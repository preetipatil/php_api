<?php
class User{
    
    private $conn =null;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function findUser($email)
    {
        $statement = "
            SELECT 
                first_name, last_name, email, password, `type`
            FROM
                Users
            WHERE email = ?;
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($email));
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}