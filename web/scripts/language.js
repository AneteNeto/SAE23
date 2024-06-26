// language.js
var selectedLanguage;

document.getElementById('langSelect').addEventListener('change', function() {
    selectedLanguage = this.value;
    localStorage.setItem('language', selectedLanguage);
    updateTranslations(selectedLanguage); // Mettre à jour les traductions sur la page
   
});



// Fonction pour mettre à jour les traductions sur la page
function updateTranslations(language) {
    // Charger le fichier de traduction approprié
    var translationFile = 'scripts/translations_' + language + '.js';
    var scriptElement = document.createElement('script');
    scriptElement.src = translationFile;
    scriptElement.onload = function() {
        // Traduire les éléments de la page
        var elements = document.querySelectorAll('[data-translate]');
        elements.forEach(function(element) {
            var key = element.getAttribute('data-translate');
            if (translations.hasOwnProperty(key)) {
                element.textContent = translations[key];
            }
        });
    };
    scriptElement.onerror = function() {
        console.error('Erreur lors du chargement du fichier de traduction');
    };
    document.head.appendChild(scriptElement);

   

}
//pour que apres cliquer sur le boutton rechercher les resultats seront aussi traduits
this.document.getElementById('rechercher').onclick=function() {updateTranslations(selectedLanguage)}; 
//meme chose pour boutton voir historique
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('voir-historique')) {
        updateTranslations(selectedLanguage);
    }
});