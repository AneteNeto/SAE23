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
    <h1 data-translate="thermometer_title">Thermomètre des étudiants : BUT1 R&T</h1>
    <div class="container">
    <form id="searchForm">
        <label for="cherche_nom" data-translate="nom">Nom:</label>
        <input type="text" id="cherche_nom" name="nom" placeholder="...">
        
        <label for="cherche_prenom" data-translate="prenom">Prénom:</label>
        <input type="text" id="cherche_prenom" name="prenom" placeholder="...">

        <label for="cherche_groupe" data-translate="groupe">Groupe:</label>
        <input type="text" id="cherche_groupe" name="groupe" placeholder="...">
        
        <button  id="rechercher" type="submit" value="Rechercher" data-translate="rechercher"> Rechercher </button>
    </form>

    <div class="container" id="searchResults">
        <!-- resultats -->
    </div>
    </div>
    <!-- data -->
    <?php
    $students = [
        ['id' => 1, 'prenom' => 'Lina', 'nom' => 'EL AMRANI', 'groupe' => 'GB2'],
        ['id' => 2, 'prenom' => 'Anete', 'nom' => 'NETO', 'groupe' => 'GB2'],
        ['id' => 3, 'prenom' => 'Mame Diarra', 'nom' => 'WADE', 'groupe' => 'GB2'],
        ['id' => 4, 'prenom' => 'Farah', 'nom' => 'ALKHALAF', 'groupe' => 'GB2']
    ];
    ?>

    <!-- Inclusion des scripts JavaScript pour la traduction et le changement de langue -->
    <script src="scripts/translations_fr.js"></script>
    <script src="scripts/translations_en.js"></script>
    <script src="scripts/translate.js"></script>
    <script src="scripts/language.js"></script>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    
    // récupérer les valeurs des champs de recherche
    var nom = document.getElementById('cherche_nom').value.trim().toLowerCase();
    var prenom = document.getElementById('cherche_prenom').value.trim().toLowerCase();
    var groupe = document.getElementById('cherche_groupe').value.trim().toLowerCase();
    
    // filtrer les étudiants en fonction des critères de recherche
    var filteredStudents = <?php echo json_encode($students); ?>.filter(function(student) {
        var nomMatch = (nom === '' || student.nom.toLowerCase().includes(nom));
        var prenomMatch = (prenom === '' || student.prenom.toLowerCase().includes(prenom));
        var groupeMatch = (groupe === '' || student.groupe.toLowerCase().includes(groupe));
        
        return nomMatch && prenomMatch && groupeMatch;
    });

    // afficher les résultats de la recherche
    var searchResultsContainer = document.getElementById('searchResults');
    searchResultsContainer.innerHTML = ''; // clear previous results
    
    if (filteredStudents.length > 0) {
    filteredStudents.forEach(function(student) {
        var studentInfo = '<div class="etudiant">' +
            '<h2 data-translate="info">Informations sur l\'étudiant</h2>' +
            '<p><strong data-translate="nom2">Nom de l\'étudiant</strong>: ' + student.prenom + ' ' + student.nom + '</p>' +
            '<p><strong data-translate="groupe2">Groupe</strong>: ' + student.groupe + '</p>' +
            '<button onclick="showHistory(' + student.id + ')" data-translate="voir_historique">Voir l\'historique</button>' +
            '<div id="historique-' + student.id + '" style="display: none;">' +
            '<!-- Contenu de l\'historique de l\'étudiant -->' +
            '<!-- afficher l\'historique des températures -->' +
            '</div>' +
            '</div>';
        searchResultsContainer.innerHTML += studentInfo;
    });
} else {
    searchResultsContainer.innerHTML = '<p data-translate="aucun_resultat">Aucun résultat trouvé.</p>';
}
});

    </script>
</body>
</html>
