<?php

    
// connexion à la base de données
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'Recette.php');

class RecetteController {

    private $recetteModel;

    public function __construct() {
        $recetteModel = new Recette();
        $this->recetteModel = $recetteModel;
    }

    // Fonction permettant de lister les recettes
    function index() {

        // préparation de la requête d'insertion dans la base de données

        // verifier l'existence d'un filtre des recettes par type de plat
        if (isset($_GET['filtre']) && $_GET['filtre']!= 'all') {
            $recipes = $this->recetteModel->findBy(array('type_plat' => $_GET['filtre']));
        } else {
            $recipes = $this->recetteModel->findAll();
        }

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR. 'Recette' . DIRECTORY_SEPARATOR .'liste.php');
    }

    // Fonction permettant de lister les recettes
    function indexJson() {
        
        // exécution de la requête et récupération des données
        $recipes = $this->recetteModel->findAll();
        // Renvoyer les données au format JSON
        header('Content-Type: application/json');
        echo json_encode($recipes);
    }

    // Fonction permettant d'ajouter une nouvelle recette
    function ajouter() {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Recette' . DIRECTORY_SEPARATOR . 'ajout.php';
    }

    function modifier() {

        $recipe = $this->recetteModel->find($_GET['id']);

        require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Recette' . DIRECTORY_SEPARATOR . 'modif.php';
    }

    // Fonction permettant d'enregistrer une nouvelle recette
    function enregistrer() {

        // récupération des données de formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $auteur = $_POST['auteur'];
        $typePlat = $_POST['type'];

        // l'ancienne image est conservée si aucune n'a été choisie
        // sinon, une nouvelle image est créée (erreur 4 = image non choisie)
        if($_FILES['image']['error'] == 4) {
            $recipe = $this->recetteModel->find($_GET['id']);
            $image = $recipe['image'];
        } else {
            $image = $_FILES['image']['name'];
            $target_dir = "upload/";
            $target_file = $target_dir. basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }
        
        // préparation de la requête d'insertion dans la base de données

        // création ou modification d'une recette
        /** @var PDO $pdo **/
        if (isset($_GET['id'])) {
            // modification d'une recette
            $ajoutOk = $this->recetteModel->update($_GET['id'],$titre,$description,$auteur,$typePlat,$image);
        } else {
            // création d'une nouvelle recette
            $ajoutOk = $this->recetteModel->add($titre,$description,$auteur,$typePlat,$image);
        }
        
        if($ajoutOk) {
            // redirection vers la vue d'enregistrement effectué
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR. 'Recette' .DIRECTORY_SEPARATOR.'enregistrement.php');
        } else {
            $_SESSION['message'] = ['danger' => 'Erreur d\'enregistrement de la recette'];
        }
    }

    function detail($id) {

        // Ajout du contrôleur des favoris
        $favoriController = new FavoriController();
        $existe = $favoriController->existe((int)$id, isset($_SESSION['id']) ? $_SESSION['id']:null);
        
        // préparation de la requête de sélection dans la base de données

        $recipe = $this->recetteModel->find($id);

        // Ajout des commentaires
        $commentaireController = new CommentController();
        $commentaires = $commentaireController->listerParRecette($id);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR. 'Recette' . DIRECTORY_SEPARATOR .'detail.php');
    }

    // Fonction permettant de supprimer une recette
    function supprimer($id) {

        // Suppression des favoris liés à la recette
        $favoriModel = new Favori();
        $favoriModel->deleteByRecette($id);

        // Suppression des commentaires liés à la recette
        $commentModel = new Comment();
        $commentModel->deleteByRecette($id);

        // préparation de la requête de suppression dans la base de données
        $suppressionOk = $this->recetteModel->delete($id);
        
        if($suppressionOk) {
            $_SESSION['message'] = ['success' => 'Recette supprimée avec succès'];

            // redirection vers la vue de suppression effectuée
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR. 'Recette' . DIRECTORY_SEPARATOR.'liste.php');
        } else {
            $_SESSION['message'] = ['danger' => 'Erreur dans la suppression de la recette'];
        }
    }

}