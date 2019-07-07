<?php

class Coupon{

    private $conn =null;
    private $table = "Coupon";


    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function createCoupon(Array $input){

        $query = "
            INSERT INTO Coupon 
                (name, brand, value, createdAt, expiry)
            VALUES
                (:name, :brand, :value, NOW(),:expiry);
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'name' => $input['name'],
                'brand'  => $input['brand'],
                'value' => $input['value'],
                'expiry' => $input['expiry'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function updateCoupon($id, Array $input)
    {
        $query = "
            UPDATE Coupon
            SET 
                name = :name,
                brand  = :brand,
                value = :value,
                createdAt = NOW(),
                expiry = :expiry
            WHERE id = :id;
        ";
                    //var_dump($input); var_dump($id);
        try {
            $statement = $this->conn->prepare($query);
            $x = $statement->execute(array(
                'id' => (int) $id,
                'name' => $input['name'],
                'brand'  => $input['brand'],
                'value' => $input['value'] ,
                'expiry' => $input['expiry']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findAll()
    {
       
        $statement = "
            SELECT 
                id, name, brand, value, createdAt, expiry
            FROM
                Coupon;
        ";

        try {
            $statement = $this->conn->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public  function  findbyName($where, $limit=10, $sort="ASC"){
        $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        $statement = "
            SELECT 
                id, name, brand, value, createdAt, expiry
            FROM
                Coupon
            WHERE name LIKE ?
            ORDER BY createdAt $sort
            LIMIT ?
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array("%$where%", $limit));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

    }

    public  function  findbyValue($where, $limit=10, $sort="ASC"){
        $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        $statement = "
            SELECT 
                id, name, brand, value, createdAt, expiry
            FROM
                Coupon
            WHERE value = ?
            ORDER BY createdAt $sort
            LIMIT ?
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($where, $limit));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

    }

    public  function  findbyBrand($where, $limit=10, $sort="ASC"){
        $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
        $statement = "
            SELECT 
                id, name, brand, value, createdAt, expiry
            FROM
                Coupon
            WHERE brand LIKE ?
            ORDER BY createdAt $sort
            LIMIT ?
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array("%$where%", $limit));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

    }

    public function findCoupon($id)
    {
        $statement = "
            SELECT 
                id, name, brand, value, createdAt, expiry
            FROM
                Coupon
            WHERE id = ?;
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


}