<?php

class UserController {

    // Fonction permettant de se connecter à l'application
    function index() {
        require_once __DIR__. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'Views'. DIRECTORY_SEPARATOR. 'User' . DIRECTORY_SEPARATOR. 'connexion.php';
    }

    // Fonction permettant d'ajouter un nouvel utilisateur
    function ajouter() {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'User' . DIRECTORY_SEPARATOR . 'inscription.php';
    }

    // Fonction permettant d'enregistrer un nouvel utilisateur
    function enregistrer($pdo) {

        // récupération des données de formulaire
        $identifiant = $_POST['identifiant'];
        $mail = $_POST['mail'];
        $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

        // préparation de la requête d'insertion dans la base de données

        // création ou modification d'une recette
        /** @var PDO $pdo **/
        $requete = $pdo->prepare("INSERT INTO users (identifiant, password, mail, create_time) VALUES (:identifiant, :password, :mail, NOW())");
        $requete->bindParam(':identifiant', $identifiant);
        $requete->bindParam(':password', $pwd);
        $requete->bindParam(':mail', $mail);
        
        // exécution de la requête
        $ajoutOk = $requete->execute();
        
        if($ajoutOk) {
            // redirection vers la vue d'enregistrement effectué
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR. 'User' .DIRECTORY_SEPARATOR.'enregistrement.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de l\'utilisateur.';
        }
    }

    // Fonction permettant de vérifier la connexion d'un utilisateur
    function connexion($pdo) {
        // récupération des données de formulaire
        $identifiant = $_POST['identifiant'];
        $pwd = $_POST['pwd'];
        
        // requête de vérification de l'identifiant
        $requete = $pdo->prepare("SELECT * FROM users WHERE identifiant = :identifiant");
        $requete->bindParam(':identifiant', $identifiant);
        $requete->execute();
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        
        // si l'utilisateur existe et le mot de passe est correct
        if($user && password_verify($pwd, $user['password'])) {
            // définition des variables de session
            $_SESSION['id'] = $user['id'];
            $_SESSION['identifiant'] = $user['identifiant'];
            $_SESSION['mail'] = $user['mail'];
            $_SESSION['isAdmin'] = $user['isAdmin'] === 1 ? true : false;
            $_SESSION['message'] = ['success' => 'Connexion réussie.'];
            
            // redirection vers la page d'accueil
            header('Location: ?c=home');
        } else {
            echo 'Identifiant ou mot de passe incorrect.';
        }
    }

    function afficherProfil($pdo) {
        // récupération des données de l'utilisateur courant
        $id = $_SESSION['id'];
        
        // requête de récupération des données de l'utilisateur
        $requete = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $requete->bindParam(':id', $id);
        $requete->execute();
        $user = $requete->fetch(PDO::FETCH_ASSOC);
        
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