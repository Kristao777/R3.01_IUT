<?php

// connexion à la base de données
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'Favori.php');

class FavoriController {
    
    private $favoriModel;

    public function __construct() {

        // création d'un objet CommentModel
        $this->favoriModel = new Favori();

    }

    function index() {
        require_once __DIR__. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'Views'. DIRECTORY_SEPARATOR. 'User'. DIRECTORY_SEPARATOR.'favoris.php';
    }

    function ajouter($id_recette) {
        // récupération de l'id de l'utilisateur connecté
        $id_utilisateur = $_SESSION['id'];
        
        // vérification si l'utilisateur a déjà ajouté cette recette à ses favoris
        $existe = $this->favoriModel->findBy(array('user_id' => $id_utilisateur, 'recette_id'=> $id_recette));
        
        if (!$existe[0]) {
            // l'utilisateur n'a pas déjà ajouté cette recette à ses favoris, on l'ajoute
            $this->favoriModel->add($id_recette,$id_utilisateur);
            $_SESSION['message'] = ['success' => 'Recette ajoutée aux favoris'];

        } else {
            // l'utilisateur a déjà ajouté cette recette à ses favoris, on le supprime des favoris
            $this->favoriModel->delete($existe[0]['id']);
            $_SESSION['message'] = ['success' => 'Recette supprimée des favoris'];
        }

        // redirection vers la page de la recette pour afficher un message de confirmation
        header('Location: ?c=Recette&a=detail&id='. $id_recette);

    }

    // Fonction permettant de vérifier si une recette est déjà dans les favoris d'un utilisateur
    function existe($id_recette, $id_utilisateur)
    { 
        // récupération de l'id de l'utilisateur connecté
        $res = $this->favoriModel->findBy(array('user_id' => $id_utilisateur, 'recette_id'=> $id_recette));

        var_dump($res);

        return $res;
    }

    // Fonction permettant de récupérer les recettes favorites d'un utilisateur
    function listerParUtilisateur($id_utilisateur) {
        $res = $this->favoriModel->findByUser($id_utilisateur);
        header('Content-Type: application/json');
        echo json_encode($res);
    }

}