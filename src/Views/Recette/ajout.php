<h1>Ajouter une recette</h1>
<form action="?c=Recette&a=enregistrer" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="titre" class="form-label">Titre de la recette</label>
        <input type="text" class="form-control" name="titre" id="titre" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description de la recette</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="auteur" class="form-label">Mail de l'auteur</label>
        <input type="email" class="form-control" name="auteur" id="auteur" value="<?php echo $auteur; ?>" required>
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select class="form-select" name="type" id="type">
            <option value="" selected disabled hidden>Choisir</option>
            <option value="entree">Entrée</option>
            <option value="plat">Plat</option>
            <option value="dessert">Dessert</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image de la recette</label>
        <input type="file" class="form-control" name="image" id="image" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="enregistrer">Enregistrer</button>
    </div>
</form>