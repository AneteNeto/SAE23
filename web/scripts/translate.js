// translate.js pour changer de langue
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer la langue sélectionnée par l'utilisateur
    var selectedLanguage = localStorage.getItem('language') ;
    var translationFile = 'scripts/translations_' + selectedLanguage + '.js';

    // Fonction pour charger le fichier de traduction
    function loadTranslationFile(translationFile) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', translationFile);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var translations = JSON.parse(xhr.responseText);
                    resolve(translations);
                } else {
                    reject();
                }
            };
            xhr.onerror = function() {
                reject();
            };
            xhr.send();
        });
    }

    // Fonction pour traduire les éléments de la page
    function translatePage(translations) {
        var elements = document.querySelectorAll('[data-translate]');
        elements.forEach(function(element) {
            var key = element.getAttribute('data-translate');
            if (translations.hasOwnProperty(key)) {
                element.textContent = translations[key];
            }
        });
    }

    // Charger le fichier de traduction et traduire la page
    loadTranslationFile(translationFile)
        .then(function(translations) {
            translatePage(translations);
        })
        .catch(function() {
            console.error('Erreur lors du chargement du fichier de traduction');
        });
});
