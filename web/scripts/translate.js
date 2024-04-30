document.addEventListener('DOMContentLoaded', function() {
    // charger le fichier de traductions
    function loadTranslationFile(lang) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'scripts/translations_' + lang + '.js');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    resolve(JSON.parse(xhr.responseText));
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

    // traduire les elements
    function translateElements(translations) {
        var elements = document.querySelectorAll('[data-translate]');
        elements.forEach(function(element) {
            var key = element.getAttribute('data-translate');
            if (translations.hasOwnProperty(key)) {
                element.textContent = translations[key];
            }
        });
    }

   

    // Load translation file based on selected language
    var langSelect = document.getElementById('langSelect');
    langSelect.addEventListener('change', function() {
        var selectedLanguage = langSelect.value;
        loadTranslationFile(selectedLanguage)
            .then(function(translations) {
                translateElements(translations);
                translatePlaceholders(translations);
            })
            .catch(function() {
                console.error('Error loading translation file.');
            });
    });
    

    // charger le fichier de traduction
    var defaultLanguage = langSelect.value; // language de defaut est selectionné
    loadTranslationFile(defaultLanguage)
        .then(function(translations) {
            translateElements(translations);
            translatePlaceholders(translations);
        })
        .catch(function() {
            console.error('Error loading translation file.');
        });
       
});
