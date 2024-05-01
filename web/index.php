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
        <form id="searchForm">   <!-- formulaire de la barre de recherche -->
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

    <script>
           document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            // Récupérer les valeurs des champs de recherche
            var nom = document.getElementById('cherche_nom').value.trim().toLowerCase();
            var prenom = document.getElementById('cherche_prenom').value.trim().toLowerCase();
            var groupe = document.getElementById('cherche_groupe').value.trim().toLowerCase();
            // Filtrer les étudiants en fonction des critères de recherche
            var filteredStudents = <?php echo json_encode($students); ?>.filter(function(student) {
                var nomMatch = (nom === '' || student.Nom.toLowerCase().includes(nom));
                var prenomMatch = (prenom === '' || student.Prenom.toLowerCase().includes(prenom));
                var groupeMatch = (groupe === '' || student.groupe.toLowerCase().includes(groupe));
                return nomMatch && prenomMatch && groupeMatch;
            });
            // Afficher les résultats de la recherche
            var searchResultsContainer = document.getElementById('searchResults');
            searchResultsContainer.innerHTML = ''; // Supprimer les résultats précédents
            if (filteredStudents.length > 0) {
                filteredStudents.forEach(function(student) {
                    var studentInfo = '<div class="etudiant">' +
                        '<h2 data-translate="info">Informations sur l\'étudiant</h2>' +
                        '<p><strong data-translate="nom2">Nom de l\'étudiant:</strong> ' + student.Prenom + ' ' + student.Nom + '</p>' +
                        '<p><strong data-translate="groupe2">Groupe:</strong> ' + student.groupe + '</p>' +
                        '<button id="historique" class="voir-historique" data-student-id="' + student.idE + '" data-translate="voir_historique">Voir l\'historique</button>' +
                        '<div class="historique-container" id="historique-' + student.idE + '" style="display: none;">' +
                        '<!-- Contenu de l\'historique de l\'étudiant -->' +
                        '</div>' +
                        '</div>';
                    searchResultsContainer.innerHTML += studentInfo;
                });
                // Afficher la médiane uniquement s'il y a des résultats de recherche
                document.getElementById('medianContainer').style.display = 'block';
                updateMedianTemperature(filteredStudents); // Calculer la médiane pour le groupe filtré
            } else {
                searchResultsContainer.innerHTML = '<p data-translate="aucun_resultat">Aucun résultat trouvé.</p>';
                document.getElementById('medianContainer').style.display = 'none'; // Cacher la médiane s'il n'y a pas de résultat
            }
        });

        // Fonction pour mettre à jour l'affichage de la médiane
        function updateMedianTemperature(filteredStudents) {
            const groupTemperatures = filteredStudents.map(student => student.temperature); // Supposons que vous avez un champ "temperature" pour chaque étudiant
            const median = calculateMedian(groupTemperatures);
            // Mettre à jour l'élément HTML affichant la médiane
            document.getElementById('medianTemperature').innerText = median + '°C';
        }

        // Fonction pour calculer la médiane d'un tableau de nombres
        function calculateMedian(arr) {
            const sorted = arr.sort((a, b) => a - b);
            const middle = Math.floor(sorted.length / 2);
            if (sorted.length % 2 === 0) {
                return (sorted[middle - 1] + sorted[middle]) / 2;
            } else {
                return sorted[middle];
            }
        }
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
    // on doit remplacer cette simulation par une requête base de données

    var historiqueData = [
        { date: "2024-04-22", ville1: { temperature: 20, vitesseVent: 10 }, ville2: { temperature: 18, vitesseVent: 8 } },
        { date: "2024-04-23", ville1: { temperature: 21, vitesseVent: 11 }, ville2: { temperature: 19, vitesseVent: 9 } },
        { date: "2024-04-24", ville1: { temperature: 22, vitesseVent: 12 }, ville2: { temperature: 20, vitesseVent: 10 } },
        { date: "2024-04-25", ville1: { temperature: 23, vitesseVent: 13 }, ville2: { temperature: 21, vitesseVent: 11 } },
        { date: "2024-04-26", ville1: { temperature: 24, vitesseVent: 14 }, ville2: { temperature: 22, vitesseVent: 12 } },
        { date: "2024-04-27", ville1: { temperature: 25, vitesseVent: 15 }, ville2: { temperature: 23, vitesseVent: 13 } },
        { date: "2024-04-28", ville1: { temperature: 26, vitesseVent: 16 }, ville2: { temperature: 24, vitesseVent: 14 } }
    ];

    var historiqueHTML = '<h3 data-translate="historique">Historique des données:</h3>';
    historiqueData.forEach(function(data, index) {
        historiqueHTML += '<div class="historiqueEntry" id="entry-' + index + '">';
        historiqueHTML += '<p><strong>' + data.date + ':</strong> ' +
            '<span data-translate="temperature">Température:</span> ' + data.ville1.temperature + '°C, ' +
            '<span data-translate="vitesse_vent">Vitesse du vent:</span> ' + data.ville1.vitesseVent + ' km/h' +
            ' (Ville primaire)' +
            '</p>';
        historiqueHTML += '<p><strong>' + data.date + ':</strong> ' +
            '<span data-translate="temperature">Température:</span> ' + data.ville2.temperature + '°C, ' +
            '<span data-translate="vitesse_vent">Vitesse du vent:</span> ' + data.ville2.vitesseVent + ' km/h' +
            ' (Ville secondaire)' +
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