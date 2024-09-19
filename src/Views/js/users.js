// Écoute le chargement du DOM
document.addEventListener('DOMContentLoaded', () => {

    // Sélection du profil identifiant (contenu modifiable)
    let profil_identifiant = document.getElementById('profil_identifiant');
    // Sélection du profil mail (contenu modifiable)
    let profil_mail = document.getElementById('profil_mail');
    // Sélection du bouton de modification
    let modifier_profil = document.getElementById('bouton_modifier_profil');
    
    // Ajoute un écouteur d'événements pour afficher le bouton de modification 
    // lorsque le contenu du profil est modifié
    profil_identifiant.addEventListener('input', (event) => {
        modifier_profil.classList.remove('d-none'); // Affiche le bouton de modification
    });

    // Ajoute un écouteur d'événements pour afficher le bouton de modification 
    // lorsque le contenu du profil est modifié
    profil_mail.addEventListener('input', (event) => {
        modifier_profil.classList.remove('d-none'); // Affiche le bouton de modification
    });
    
});