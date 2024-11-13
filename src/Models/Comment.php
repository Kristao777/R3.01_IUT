<?php

require_once __DIR__ .DIRECTORY_SEPARATOR. 'Database.php';

Class Comment {
    private $conn;

    // Constructeur
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM comments ORDER BY create_time DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM comments WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM comments WHERE ". implode(' AND ', array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($pseudo, $id_recette, $commentaire) {
        $query = "INSERT INTO comments (pseudo , recette_id, commentaire, create_time) VALUES (:pseudo, :recette_id, :commentaire, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':recette_id', $id_recette);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($id,$pseudo, $recette_id, $commentaire) {
        $query = "UPDATE comments SET pseudo = :pseudo, recette_id = :recette_id, commentaire = :commentaire WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {
        $query = "DELETE FROM comments WHERE id = $id";
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