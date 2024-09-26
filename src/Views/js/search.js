// Écoute le chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    let recipes = [];
    
    // Fonction pour charger toutes les recettes du serveur via fetch()
    async function loadRecipes() {
        try {
            // Récupère les données des recettes à partir d'un fichier JSON envoyé par le controleur
            const response = await fetch('?c=Recette&a=indexJson&x');
            // Traite le retour de la requête en JSON
            recipes = await response.json();
         } catch (error) {
             console.error('Erreur lors du chargement des recettes :', error);
         }
    };
    // Fonction pour filtrer les recettes en fonction de la recherche
    function filterRecipes() {
        const query = document.getElementById('search').value.toLowerCase();
        
        // Utiliser array.filter pour filtrer les recettes qui correspondent à la recherche
        // Version simple pour filtrer par le titre
        // const filtered = recipes.filter(recipe => recipe.titre.toLowerCase().includes(query));
        // Version plus complexe pour filtrer par le titre ou la description
        const filtered = recipes.filter(recipe => {
            return recipe.titre.toLowerCase().includes(query) || recipe.description.toLowerCase().includes(query);
        });
        
        // Afficher les recettes filtrées
        displayRecipes(filtered);
    }

    // Fonction pour afficher les recettes dans la page
    function displayRecipes(recipesToDisplay) {
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = ''; // Vider les résultats précédents
  
        if (recipesToDisplay.length === 0) {
          resultsDiv.innerHTML = '<p>Aucune recette trouvée.</p>';
          return;
        }
  
        // Parcourir les recettes et les afficher
        recipesToDisplay.forEach(recipe => {
          const recipeDiv = document.createElement('div');
          recipeDiv.classList.add('product');
          recipeDiv.innerHTML = `
            <strong><a href='?c=Recette&a=detail&id=${recipe.id}'>${recipe.titre}</a></strong><br>
            Description : ${recipe.description}
          `;
          resultsDiv.appendChild(recipeDiv);
        });
    }

    // Charger les recettes au chargement du DOM
    loadRecipes();

    // Ecouter le focus sur le champ de recherche
    document.getElementById('search').addEventListener('focus', () => {
        // alert('Appuyez sur la touche Entrée pour effectuer la recherche');
        document.querySelector('.container').innerHTML = '';
        document.querySelector('.container').innerHTML = `
            <h1>Résultats de la recherche</h1>
            <div class="row" id="results"></div>`;
    });

    // Ecouter le blur sur le champ de recherche
    document.getElementById('search').addEventListener('blur', () => {
        location.reload();
    });

    // Ecouter le changement de la recherche
    document.getElementById('search').addEventListener('input', filterRecipes);

});