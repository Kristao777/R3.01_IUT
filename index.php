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
    
    // connexion à la base de données
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'connectDb.php');
    
    // ajout de l'en tête
    if(!isset($_GET["x"])) require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'header.php');

    // mise en place de la route actuelle
    $route = isset($_GET['c'])? $_GET['c'] : 'home';
    
    // définition des routes disponibles
    switch ($route) {
        case 'home':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'homeController.php');
            break;
        case 'contact':
            $contactController = new ContactController();
            $contactController->ajouter();
            break;
        case 'ajout':
            $recetteController = new RecetteController();
            $recetteController->ajouter();
            break;
        case 'modif':
            $recetteController = new RecetteController();
            $recetteController->modifier($pdo);
            break;
        case 'enregistrer':
            $recetteController = new RecetteController();
            $recetteController->enregistrer($pdo);
            break;
        case 'contacter':
            $contactController = new ContactController();
            $contactController->enregister($pdo);
            break;
        case 'liste':
            $recetteController = new RecetteController();
            $recetteController->lister($pdo);
            break;
        case 'detail':
            $recetteController = new RecetteController();
            $recetteController->detail($pdo,$_GET['id']);
            break;
        case 'inscription':
            $userController = new UserController();
            $userController->inscription();
            break;
        case 'inscrire':
            $userController = new UserController();
            $userController->enregistrer($pdo);
            break;
        case 'connexion':
            $userController = new UserController();
            $userController->connexion();
            break;
        case 'connecter':
            $userController = new UserController();
            $userController->verifieConnexion($pdo);
            break;
        case 'profil':
            $userController = new UserController();
            $userController->profil($pdo);
            break;
        case 'deconnexion':
            $userController = new UserController();
            $userController->deconnexion();
            break;
        case 'favori':
            $favoriController = new FavoriController();
            $favoriController->ajouter($pdo, $_GET['id']);
            break;
        case 'mesFavoris':
            $favoriController = new FavoriController();
            $favoriController->mesRecettesFavoris();
            break;
        case 'getFavoris':
            $favoriController = new FavoriController();
            $favoriController->getFavoris($pdo, $_GET['id']);
            break;
        case 'ajoutComment':
            $commentaireController = new CommentController();
            $commentaireController->ajouter($pdo, $_GET['id']);
            break;
        default:
            echo "Page non trouvée";
    }
    
    // ajout du pied de page
    if(!isset($_GET["x"])) require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'footer.php');
