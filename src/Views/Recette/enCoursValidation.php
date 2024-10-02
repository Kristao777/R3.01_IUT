<h1>Mes recettes en cours de validation</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recipes as $recipe) :?>
            <tr>
                <td><a href="?c=Recette&a=detail&id=<?php echo $recipe['id'];?>"><?php echo $recipe['titre'];?></a></td>
                <td><?php echo substr($recipe['description'], 0, 100);?>...</td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>