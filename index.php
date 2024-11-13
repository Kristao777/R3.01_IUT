<?php

    session_start();

    // import de la classe RecetteController
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'RecetteController.php');
    
    // import de la classe ContactController
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'ContactController.php');
    
    // import de la classe UserController
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'UserController.php');
    
    // import de la classe FavoriController
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'FavoriController.php');
    
    // import de la classe CommentController
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'CommentController.php');
    
    // ajout de l'en tête
    if(!isset($_GET["x"])) require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'header.php');

    // mise en place de la route actuelle
    $controller = isset($_GET['c'])? $_GET['c'] : 'home';
    $action = isset($_GET['a'])? $_GET['a'] : 'index';

    // définition des routes disponibles
    switch ($controller) {
        // route pour la page d'accueil
        case 'home':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'HomeController.php');
            break;
        // routes pour la gestion des contacts    
        case 'Contact':
            $contactController = new ContactController();
            switch ($action) {
                case 'ajouter':
                    $contactController->ajouter();
                    break;
                case 'enregistrer':
                    $contactController->enregistrer();
                    break;
                default:
                    $_SESSION['message'] = ['danger' => 'La page n\'existe pas'];
                    header('Location: ?c=home');
            }
            break;
        // routes pour la gestion des recettes
        case 'Recette':
            $recetteController = new RecetteController();
            switch ($action) {
                case 'index':
                    $recetteController->index();
                    break;
                case 'indexJson':
                    $recetteController->indexJson();
                    break;
                case 'ajouter':
                    $recetteController->ajouter();
                    break;
                case 'enregistrer':
                    $recetteController->enregistrer();
                    break;
                case 'modifier':
                    $recetteController->modifier($_GET['id']);
                    break;
                case 'detail':
                    $recetteController->detail($_GET['id']);
                    break;
                case 'supprimer':
                    $recetteController->supprimer($_GET['id']);
                    break;
                default:
                    $_SESSION['message'] = ['danger' => 'La page n\'existe pas'];
                    header('Location: ?c=home');
            }
            break;
        // routes pour la gestion des favoris
        case 'Favori':
            $favoriController = new FavoriController();
            switch ($action) {
                case 'index':
                    $favoriController->index();
                    break;
                case 'ajouter':
                    $favoriController->ajouter($_GET['id']);
                    break;
                case 'listerParUtilisateur':
                    $favoriController->listerParUtilisateur($_SESSION['id']);
                    break;
                default:
                    $_SESSION['message'] = ['danger' => 'La page n\'existe pas'];
                    header('Location: ?c=home');
            }
            break;
        // routes pour la gestion des commentaires
        case 'Comment':
            $commentController = new CommentController();
            switch ($action) {
                case 'index':
                    $commentController->index();
                    break;
                case 'ajouter':
                    $commentController->enregistrer($_GET['id']);
                    break;
                case 'listerParRecette':
                    $commentController->listerParRecette($_GET['id']);
                    break;
                case 'supprimer':
                    $commentController->supprimer($_GET['id']);
                    break;
                default:
                    $_SESSION['message'] = ['danger' => 'La page n\'existe pas'];
                    header('Location: ?c=home');
            }
            break;
        // routes pour la gestion des utilisateurs
        case 'User':
            $userController = new UserController();
            switch ($action) {
                case 'index':
                    $userController->index();
                    break;
                case 'ajouter':
                    $userController->ajouter();
                    break;
                case 'enregistrer':
                    $userController->enregistrer();
                    break;
                case 'connexion':
                    $userController->connexion();
                    break;
                case 'afficherProfil':
                    $userController->afficherProfil();
                    break;
                case 'deconnexion':
                    $userController->deconnexion();
                    break;
                default:
                    $_SESSION['message'] = ['danger' => 'La page n\'existe pas'];
                    header('Location: ?c=home');
            }
            break;
        default:
            $_SESSION['message'] = ['danger' => 'La page n\'existe pas'];
            header('Location: ?c=home');
    }
    
    // ajout du pied de page
    if(!isset($_GET["x"])) require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'footer.php');