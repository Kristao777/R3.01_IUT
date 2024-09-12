<body>

    <h1>Recettes</h1>

    <div class="row">
        <!-- Boucle permettant de lister les recettes -->
        <?php foreach ($recipes as $recipe) : ?>
            <div class="col-4 p-2">
                <!-- Utilisation des Cards Bootstrap -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $recipe['titre']; ?></h2>
                        <p class="card-text"><?php echo $recipe['description']; ?></p>
                        Auteur : <a href="mailto:<?php echo $recipe['auteur']; ?>"><?php echo $recipe['auteur']; ?></a>
            
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="?c=home" class="btn btn-primary">Retour à l'accueil</a>

</body>