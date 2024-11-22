<?php

require_once __DIR__ .DIRECTORY_SEPARATOR. 'Database.php';

Class Favori {
    private $conn;

    // Constructeur
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM favoris";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM favoris WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM favoris WHERE ". implode(' AND ', array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser($user_id) {
        $query = "SELECT r.* FROM favoris f JOIN recettes r ON f.recette_id = r.id WHERE f.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($recette_id, $user_id) {
        $query = "INSERT INTO favoris (recette_id , user_id, create_time) VALUES (:recette_id, :user_id, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($id,$recette_id, $user_id) {
        $query = "UPDATE favoris SET recette_id = :recette_id, user_id = :user_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $query = "DELETE FROM favoris WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function deleteByUser($user_id) {
        $query = "DELETE FROM favoris WHERE user_id = $user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function deleteByRecette($recette_id) {
        $query = "DELETE FROM favoris WHERE recette_id = $recette_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}