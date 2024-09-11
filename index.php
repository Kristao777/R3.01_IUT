<?php

    // connexion à la base de données
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'connectDb.php');
    
    // ajout de l'en tête
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'header.php');

    // mise en place de la route actuelle
    $route = isset($_GET['c'])? $_GET['c'] : 'home';
    
    // définition des routes disponibles
    switch ($route) {
        case 'home':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'homeController.php');
            break;
        case 'contact':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'contactController.php');
            break;
        case 'ajout':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'ajoutController.php');
            break;
        case 'enregistrer':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'enregistrerController.php');
            break;
        case 'contacter':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.'contacterController.php');
            break;
        default:
            echo "Page non trouvée";
    }
    
    // ajout du pied de page
    require_once(__DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'footer.php');
