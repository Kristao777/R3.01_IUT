<h1>Recettes à approuver</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
            <th scope="col">Auteur</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($recipes as $recipe) { ?>
            <tr>
                <td scope="row"><?php echo $recipe['titre']; ?></td>
                <td><?php echo $recipe['description']; ?></td>
                <td><?php echo $recipe['auteur']; ?></td>
                <td>
                    <a href="?c=Recette&a=valider&id=<?php echo $recipe['id']; ?>" class="btn btn-success" title="Valider la recette">Valider</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>