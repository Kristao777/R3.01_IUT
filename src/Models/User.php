<?php

require_once __DIR__ .DIRECTORY_SEPARATOR. 'Database.php';

Class User {
    private $conn;

    // Constructeur
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM users WHERE ". implode(' AND ', array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($identifiant, $pwd, $mail) {
        $query = "INSERT INTO users (identifiant, password, mail, create_time) VALUES (:identifiant, :password, :mail, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':password', $pwd);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($id,$identifiant, $pwd, $mail) {
        $query = "UPDATE users SET identifiant = :identifiant, pwd = :pwd, mail = :mail  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':password', $pwd);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $query = "DELETE FROM users WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}