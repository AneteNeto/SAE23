<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="icon/icon.png"/>
    <title data-translate="thermometer_title">ThermoRT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <select id="langSelect">
        <option value="fr">Français</option>
        <option value="en">English</option>
    </select>
    <h1 data-translate="thermometer_title">Thermomètre des étudiants : </h1>
    <h1 data-translate="specialite">BUT1 R&T</h1>
    <div class="container">
        <form id="searchForm" action="" method="post">   <!-- formulaire de la barre de recherche -->
            <label for="cherche_nom" data-translate="nom">Nom:</label>
            <input type="text" id="cherche_nom" name="nom" placeholder="...">
            
            <label for="cherche_prenom" data-translate="prenom">Prénom:</label>
            <input type="text" id="cherche_prenom" name="prenom" placeholder="...">

            <label for="cherche_groupe" data-translate="groupe">Groupe:</label>
            <input type="text" id="cherche_groupe" name="groupe" placeholder="...">
            
            <button id="rechercher" type="submit" value="Rechercher" data-translate="rechercher"> Rechercher </button>
        </form>

        <div class="container" id="searchResults">
            <!-- resultats -->
        </div>

        <div class="container" id="medianContainer" style="display: none;">
        <h2 data-translate="group_temperature">Température médiane du groupe</h2>
            <p id="medianTemperature">-</p>
        </div>
    

    <!-- data -->
   <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
        require "../Source/Core/Query.php";
        $students=queryetudiant();  
    ?>
    

    <!-- Inclusion des scripts JavaScript pour la traduction et le changement de langue -->
    <script src="scripts/translations_fr.js"></script>
    <script src="scripts/translations_en.js"></script>
    <script src="scripts/translate.js"></script>
    <script src="scripts/language.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      
      
       /*** Cette partie du script gère la soumission du formulaire de recherche.
        Récupérer les valeurs des champs de recherche, filtrer les étudiants en fonction des critères de recherche,
        Afficher les résultats dans le conteneur ***/

    // Ajouter un event listener pour soumettre le formulaire de recherche
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher la soumission du formulaire
        var nom = document.getElementById('cherche_nom').value.trim().toLowerCase();
        var prenom = document.getElementById('cherche_prenom').value.trim().toLowerCase();
        var groupe = document.getElementById('cherche_groupe').value.trim().toLowerCase();

        


        var filteredStudents = <?php echo json_encode($students); ?>.filter(function(student) {
            var nomMatch = (nom === '' || student.Nom.toLowerCase().includes(nom));
            var prenomMatch = (prenom === '' || student.Prenom.toLowerCase().includes(prenom));
            var groupeMatch = (groupe === '' || student.groupe.toLowerCase().includes(groupe));
            return nomMatch && prenomMatch && groupeMatch;
            

        });
    
        if(groupe!==''){
            console.log("GROUUUPE"+groupe);
            jQuery.ajax({
            type: "POST",
            url: '../Source/api/api.php',
            dataType: 'json',
            data: {
                function_name:'get-average',
                arguments: {
                    groupe
                }
            },

            success: function (obj, textstatus) {
                if (!('error' in obj)) {
                    var average = document.getElementById('medianTemperature');
                    average.innerHTML = ''; // Supprimer les résultats précédents

                    var medianContainer = document.getElementById('medianContainer');
                    medianContainer.style.display = 'block';

                    obj.result.forEach(function (data) {
                    average.innerHTML=Math.round(data.M_Temp)+'-'+Math.round(data.M_Vent);
                    });
                }
                else {
                    console.log(obj.error);
                }
            }
  });
      }


        // À l'intérieur de la fonction de gestion de la soumission du formulaire



        var searchResultsContainer = document.getElementById('searchResults');
        searchResultsContainer.innerHTML = ''; // Supprimer les résultats précédents

        if (filteredStudents.length > 0) {
            // les informations des étudiants filtrés
            filteredStudents.forEach(function(student) {
    var studentInfo = '<div class="etudiant">' +
        '<h2 data-translate="info">Informations sur l\'étudiant</h2>' +
        '<p><strong data-translate="nom2">Nom de l\'étudiant:</strong> ' + student.Prenom + ' ' + student.Nom + '</p>' +
        '<p><strong data-translate="groupe2">Groupe:</strong> ' + student.groupe + '</p>';

    // Ajouter les informations météorologiques de l'étudiant
    var weatherInfo = '';
if (student.Villes && student.Icones) {
    var villesSet = new Set(); // Créer un ensemble pour stocker les villes uniques
    var villes = student.Villes.split(',');
    var icones = student.Icones.split(',');
    var temperatures = student.Temperatures.split(',');
    var vitesseVents = student.VitesseVents.split(',');

    for (var i = 0; i < villes.length; i++) {
        villesSet.add(villes[i]); // Ajouter la ville à l'ensemble
    }

    weatherInfo += '<div class="weather-container">' + 
        '<div class="weather-info-wrapper">'; 

    // Parcourir l'ensemble des villes uniques
    villesSet.forEach(function(ville) {
        var indexVille = villes.indexOf(ville);
        var iconeVille = icones[indexVille];
        var temperatureVille = temperatures[indexVille];
        var vitesseVentVille = vitesseVents[indexVille];

        weatherInfo += '<div class="weather-info">' +
            '<div class="nomdeville">' + '<p>' + ville + '</p>' +
            '<div>' +
            '<img class="icone" height="40" width="40" src="icon_meteo/' + iconeVille + '.png">' +
            ' <span>' + temperatureVille + '°C  </span>' +
            '</div>' +
            '<span class="ventVitese">' + vitesseVentVille + 'Km/h</span>' +
            '</div>';
    });

    weatherInfo += '</div>' + 
        '</div>'; 
}


    var historyButton = '<div class="historique-container" id="historique-' + student.idE + '" style="display: none;"></div>' +
        '<button class="voir-historique" data-student-id="' + student.idE + '" data-translate="voir_historique">Voir l\'historique</button>';

    var studentHTML = studentInfo + weatherInfo + historyButton + '</div>';

    // Ajouter les informations de l'étudiant au conteneur de résultats de recherche
    searchResultsContainer.innerHTML += studentHTML;
});


            document.getElementById('medianContainer').style.display = 'block';
        } else {
            searchResultsContainer.innerHTML = '<p data-translate="aucun_resultat">Aucun résultat trouvé.</p>';
            document.getElementById('medianContainer').style.display = 'none';
        }

    });



        /*** Afficher l'historique pour chaque etudiant ***/

        // Fonction pour alterner l'affichage de l'historique
        /*function toggleHistory(studentId) {
            var historiqueContainer = document.getElementById('historique-' + studentId);
            if (historiqueContainer.style.display === 'block') {
                historiqueContainer.style.display = 'none';
            } else {
                showHistory(studentId);
            }
        }
        // Ajouter un écouteur d'événements pour les boutons "Voir l'historique"
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('voir-historique')) {
                var studentId = event.target.getAttribute('data-student-id');
                toggleHistory(studentId); // Appeler la fonction toggleHistory au lieu de showHistory
            }
        });

        function showHistory(studentId) {
            var historiqueContainer = document.getElementById('historique-' + studentId);
            // Simulation de l'historique des données pour l'étudiant correspondant à studentId
            // on doit remplacer cette simulation par une requête base de données4
            var  historiqueData =<?php echo json_encode($historique); ?>;
            var historiqueHTML = '<h3 data-translate="historique">Historique des données:</h3>';
            historiqueData.forEach(function(data, index) {
                historiqueHTML += '<div class="historiqueEntry" id="entry-' + index + '">';
                let date_time = new Date(data.Date);
                historiqueHTML +='<div class="container-histo">'+
                '<div class="historique">'+
                '<div class="termoEtu">'+
                        '<div class="date" style="width: 58px;">'+
                            '<p>'+date_time.toLocaleDateString('fr-FR', { weekday: 'long' })+'</p>'+
                            '<p class="jour">'+date_time.toLocaleDateString()+'</p>'+
                        '</div>'+
                        '<img class="icone" height="40" width="40" src="icon_meteo/'+data.Icone+'.png">'+
                        '<div class="temperature">'+
                               ' <span>'+data.Temperature + '°C  </span>'+
                                '<span class="ventVitese">'+ data.VentVitesse +'Km/h</span>'+
                        '</div>'+
                        '<div class="nomdeville">'+
                            '<p>'+data.Ville +'</p>'+
                        '</div>'+
                        '<div class="heure">'+date_time.toLocaleTimeString()+'</div>'+
                  '</div></div></div></div>';
            });

            // Afficher l'historique dans le conteneur
            historiqueContainer.innerHTML = historiqueHTML;
            // Afficher le conteneur d'historique s'il est caché
            historiqueContainer.style.display = 'block';
        }*/

document.addEventListener('click', function (event) {
    if (event.target.classList.contains('voir-historique')) {
        var studentId = event.target.getAttribute('data-student-id');
        var historiqueContainer = document.getElementById('historique-' +studentId);
        if (historiqueContainer.style.display === 'block') {
            historiqueContainer.style.display = 'none';
        } else {
            jQuery.ajax({
            type: "POST",
            url: '../Source/api/api.php',
            dataType: 'json',
            data: {
                function_name: 'get-historique',
                arguments: {
                    studentId,
                }
            },
        
            success: function (obj, textstatus) {
                if (!('error' in obj)) {
                var historiqueHTML = '<h3 data-translate="historique"></h3>';
        
                obj.result.forEach(function (data,index) {
                    historiqueHTML += '<div class="historiqueEntry" id="entry-' + index + '">';
                    let date_time = new Date(data.Date);
                    historiqueHTML += '<div class="container-histo">' +
                        '<div class="historique">' +
                        '<div class="termoEtu">' +
                        '<div class="date" style="width: 58px;">' +
                        '<p>' + date_time.toLocaleDateString('fr-FR', { weekday: 'long' }) + '</p>' +
                        '<p class="jour">' + date_time.toLocaleDateString() + '</p>' +
                        '</div>' +
                        '<img class="icone" height="40" width="40" src="icon_meteo/' + data.Icone + '.png">' +
                        '<div class="temperature">' +
                        ' <span>' + data.Temperature + '°C</span>' +
                        '<span class="ventVitese">' + data.VentVitesse + 'Km/h</span>' +
                        '</div>' +
                        '<div class="description">' +
                        '<p>' + data.Ville+ '</p>' +
                        '</div>' +
                        '<div class="heure">' + date_time.toLocaleTimeString() + '</div>' +
                        '</div></div></div></div>';
                })
                    // Afficher l'historique dans le conteneur
                    historiqueContainer.innerHTML = historiqueHTML;
                    // Afficher le conteneur d'historique s'il est caché
                    historiqueContainer.style.display = 'block';
                }
                else {
                console.log(obj.error);
                }
            }
            });
        }   
    }
  });
    </script>
</body>
</html>