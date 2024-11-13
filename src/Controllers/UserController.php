<?php

// connexion à la base de données
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'User.php');

class UserController {

    private $userModel;

    public function __construct() {

        // création d'un objet CommentModel
        $this->userModel = new User();

    }

    // Fonction permettant de se connecter à l'application
    function index() {
        require_once __DIR__. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'Views'. DIRECTORY_SEPARATOR. 'User' . DIRECTORY_SEPARATOR. 'connexion.php';
    }

    // Fonction permettant d'ajouter un nouvel utilisateur
    function ajouter() {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'User' . DIRECTORY_SEPARATOR . 'inscription.php';
    }

    // Fonction permettant d'enregistrer un nouvel utilisateur
    function enregistrer() {

        // récupération des données de formulaire
        $identifiant = $_POST['identifiant'];
        $mail = $_POST['mail'];
        $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

        // préparation de la requête d'insertion dans la base de données
        $ajoutOk = $this->userModel->add($identifiant,$pwd,$mail);
        
        if($ajoutOk) {
            // redirection vers la vue d'enregistrement effectué
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR. 'User' .DIRECTORY_SEPARATOR.'enregistrement.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de l\'utilisateur.';
        }
    }

    // Fonction permettant de vérifier la connexion d'un utilisateur
    function connexion() {
        // récupération des données de formulaire
        $identifiant = $_POST['identifiant'];
        $pwd = $_POST['pwd'];
        
        // requête de vérification de l'identifiant
        $user = $this->userModel->findBy(array('identifiant' => $identifiant));
        
        // si l'utilisateur existe et le mot de passe est correct
        if($user && password_verify($pwd, $user[0]['password'])) {
            // définition des variables de session
            $_SESSION['id'] = $user[0]['id'];
            $_SESSION['identifiant'] = $user[0]['identifiant'];
            $_SESSION['mail'] = $user[0]['mail'];
            $_SESSION['isAdmin'] = $user[0]['isAdmin'] === 1 ? true : false;
            $_SESSION['message'] = ['success' => 'Connexion réussie.'];
            
            // redirection vers la page d'accueil
            header('Location: ?c=home');
        } else {
            echo 'Identifiant ou mot de passe incorrect.';
        }
    }

    function afficherProfil() {
        // récupération des données de l'utilisateur courant
        $id = $_SESSION['id'];
        
        // requête de récupération des données de l'utilisateur
        $user = $this->userModel->find($id);
        
        // affichage du profil de l'utilisateur courant
        require_once __DIR__. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'Views'. DIRECTORY_SEPARATOR. 'User' . DIRECTORY_SEPARATOR. 'profil.php';
    }

    // Fonction permettant de déconnecter un utilisateur
    function deconnexion() {
        // déstruction des variables de session
        session_destroy();
        
        // redirection vers la page de connexion
        header('Location: ?c=home');
    }

}