<?php

// connexion à la base de données
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'Comment.php');

class CommentController {

    private $commentModel;

    public function __construct() {

        // création d'un objet CommentModel
        $this->commentModel = new Comment();

    }
    
    // fonction permettant de lister tous les commentaires
    function index() {
        
        $commentaires = $this->commentModel->findAll();

        // affichage des commentaires
        require_once __DIR__. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'Views'. DIRECTORY_SEPARATOR. 'Comment' . DIRECTORY_SEPARATOR. 'liste.php';
    }

    function enregistrer($id_recette) {

        // utilisateur anonyme si aucun utilisateur connecté
        if(isset($_SESSION['id'])) {
            $pseudo = $_SESSION['identifiant'];
        } else {
            $pseudo = 'Anonyme';
        }

        // récupération du commentaire du formulaire et insertion dans la base de données
        $commentaire = $_POST['commentaire'];
        // préparation de la requête d'insertion dans la base de données
        $this->commentModel->add($pseudo,$id_recette,$commentaire);
        // redirection vers la page de détail de la recette après l'ajout du commentaire
        header('Location: ?c=Recette&a=detail&id='.$id_recette);
    }

    // fonction permettant de lister les commmentaires d'une recette
    function listerParRecette($id) {
        $res = $this->commentModel->findBy(array('recette_id'=>$id));
        return $res;
    }

    // fonction permettant de supprimer un commentaire
    function supprimer($id) {
        $this->commentModel->delete($id);
        $_SESSION['message'] = ['success' => 'Commentaire supprimé avec succès'];
        // redirection vers la page de détail de la recette après la suppression du commentaire
        header('Location: ?c=Comment&a=index');
    }

}