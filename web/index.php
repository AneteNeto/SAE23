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
    <h2 data-translate="student_list">Liste des étudiants</h2>
    <!-- Affichage des informations de chaque étudiant -->
    <?php
    // Connexion à la base de données et récupération des informations des étudiants
    // interroger la base de données et récupérer les informations des étudiants
    $students = [
        ['id' => 1, 'prenom' => 'Lina', 'nom' => 'EL AMRANI', 'groupe' => 'GB2'],
        ['id' => 2, 'prenom' => 'Anete', 'nom' => 'NETO', 'groupe' => 'GB2'],
        ['id' => 3, 'prenom' => 'Mame Diarra', 'nom' => 'WADE', 'groupe' => 'GB2'],
        ['id' => 4, 'prenom' => 'Farah', 'nom' => 'ALKHALAF', 'groupe' => 'GB2']
    ];

    foreach ($students as $student) {
        $id = $student['id'];
        $prenom = $student['prenom'];
        $nom = $student['nom'];
        $groupe = $student['groupe'];
    ?>
    <div class="etudiant">
        <p><strong data-translate="student_name">Nom de l'étudiant</strong>: <?php echo $prenom . ' ' . $nom; ?></p>
        <p><strong data-translate="student_group">Groupe</strong>: <?php echo $groupe; ?></p>
        <button onclick="showHistory(<?php echo $id; ?>)">Voir l'historique</button>
        <div id="historique-<?php echo $id; ?>" style="display: none;">
            <!-- Contenu de l'historique de l'étudiant -->
            <!-- afficher l'historique des températures -->
        </div>
    </div>
    <?php
    }
    ?>
</div>

        <div id="groupe-info">
    <!-- Affichage de la température médiane du groupe sous forme de liste -->
    <h2 data-translate="group_temperature">Température médiane du groupe</h2>
    <ul id="group-list">
        <li data-group="LK1">LK1: <span id="LK1-temperature"></span>°C</li>
        <li data-group="LK2">LK2: <span id="LK2-temperature"></span>°C</li>
        <li data-group="GB1">GB1: <span id="GB1-temperature"></span>°C</li>
        <li data-group="GB2">GB2: <span id="GB2-temperature"></span>°C</li>
    </ul>
</div>
    </div>

    <!-- Inclusion des scripts JavaScript pour la traduction et le changement de langue -->
    <script src="scripts/translations_fr.js"></script>
    <script src="scripts/translations_en.js"></script>
    <script src="scripts/translate.js"></script>
    <script src="scripts/language.js"></script>
</body>
</html>