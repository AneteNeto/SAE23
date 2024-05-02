<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-translate="thermometer_title">Thermomètre des étudiants</title>
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
        <h2 data-translate="group_temperature">Température médiane du groupe :</h2>
            <p id="medianTemperature">-</p>
        </div>
    
   

   

    <!-- data -->
    <?php
    $students = [];
    $SERVEUR="mysql_serv";
    $LOGIN="adbneto";
    $PASSW="adbneto-rt2023";
    $BD="adbneto_05";

    $co=mysqli_connect($SERVEUR,$LOGIN,$PASSW,$BD)or die("Unable to connect");
    $query="SELECT * FROM Etudiant";
    $result=mysqli_query($co,$query) or die ("erreur dans la requete $query");
    while($row=mysqli_fetch_assoc($result)){
        $students []=$row;
    }

    $result=mysqli_query($co,$query) or die ("erreur dans la requete $query");
    



    
    ?>

    

    <!-- Inclusion des scripts JavaScript pour la traduction et le changement de langue -->
    <script src="scripts/translations_fr.js"></script>
    <script src="scripts/translations_en.js"></script>
    <script src="scripts/translate.js"></script>
    <script src="scripts/language.js"></script>
     <!-- Inclusion de jQuery pour faciliter les requêtes AJAX -->
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

        var filteredStudents = <?php echo ($students); ?>.filter(function(student) {
            var nomMatch = (nom === '' || student.Nom.toLowerCase().includes(nom));
            var prenomMatch = (prenom === '' || student.Prenom.toLowerCase().includes(prenom));
            var groupeMatch = (groupe === '' || student.groupe.toLowerCase().includes(groupe));
            return nomMatch && prenomMatch && groupeMatch;
        });

        var searchResultsContainer = document.getElementById('searchResults');
        searchResultsContainer.innerHTML = ''; // Supprimer les résultats précédents
        if (filteredStudents.length > 0) {
            // Afficher les informations des étudiants filtrés
            filteredStudents.forEach(function(student) {
                var studentInfo = '<div class="etudiant">' +
                '<h2 data-translate="info">Informations sur l\'étudiant</h2>' +
                '<p><strong data-translate="nom2">Nom de l\'étudiant:</strong> ' + student.Prenom + ' ' + student.Nom + '</p>' +
                '<p><strong data-translate="groupe2">Groupe:</strong> ' + student.groupe + '</p>' +
                 '<div class="container" id="weatherContainer">' +
                '<a href="">' +
                '<div><strong>Montbeliard</strong> <span id="res" style="display: none;">,France</span></div>' +
                '<div>Partiellement nuageux</div>' +
                '<div>' +
                '<img src="icone_weather.svg" width="32" height="32">' +
                '<span>21º<span>C</span></span>' +
                '</div>' +
                '<div>Vent <span>8Km/h</span></div>' +
                '</a>' +
                '</div>' +
                '<div class="historique-container" id="historique-' + student.idE + '" style="display: none;">' +
                '</div>' +
                '<button class="voir-historique" data-student-id="' + student.idE + '" data-translate="voir_historique">Voir l\'historique</button>' +
                '</div>';
                searchResultsContainer.innerHTML += studentInfo;
            });
            document.getElementById('medianContainer').style.display = 'block';
            updateMedianTemperature(filteredStudents); // Calculer et afficher la température médiane
        } else {
            searchResultsContainer.innerHTML = '<p data-translate="aucun_resultat">Aucun résultat trouvé.</p>';
            document.getElementById('medianContainer').style.display = 'none';
        }
    });



        /*** Afficher l'historique pour chaque etudiant ***/

        // Fonction pour alterner l'affichage de l'historique
        function toggleHistory(studentId) {
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
                historiqueHTML += '<p><strong>' + data.date + ':</strong> ' +
                '<span data-translate="temperature">Température:</span> ' + data.ville1.temperature + '°C, ' +
                '<span data-translate="vitesse_vent">Vitesse du vent:</span> ' + data.ville1.vitesseVent + ' km/h' +
                ' ('+data.ville1.VilleDomicileP+')' +
                '</p>';
                historiqueHTML += '<p><strong>' + data.date + ':</strong> ' +
                '<span data-translate="temperature">Température:</span> ' + data.ville2.temperature + '°C, ' +
                '<span data-translate="vitesse_vent">Vitesse du vent:</span> ' + data.ville2.vitesseVent + ' km/h' +
                ' ('+data.ville2.VilleDomicileS+')' +
                '</p>';
                historiqueHTML += '</div>';
            });
            // Afficher l'historique dans le conteneur
            historiqueContainer.innerHTML = historiqueHTML;
            // Afficher le conteneur d'historique s'il est caché
            historiqueContainer.style.display = 'block';
        }
    </script>
</body>
</html>