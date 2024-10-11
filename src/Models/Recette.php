<?php

require_once __DIR__ .DIRECTORY_SEPARATOR. 'Database.php';

Class Recette {
    private $conn;

    // Constructeur
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM recettes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM recettes WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM recettes WHERE ". implode(' AND ', array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($titre, $description, $auteur, $type_plat, $image) {
         $query = "INSERT INTO recettes VALUES  ('$titre', '$description', '$auteur', '$type_plat', '$image', NOW())";
         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         return $this->conn->lastInsertId();
    }

    public function update($id,$titre, $description, $auteur, $type_plat, $image) {
        $query = "UPDATE recettes SET titre = :titre, description = :description, auteur = :auteur, type_plat = :type_plat , image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':type_plat', $type_plat);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $query = "DELETE FROM recettes WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}