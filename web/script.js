document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour récupérer les données des étudiants depuis le serveur
    function getStudentData() {
        // Utiliser Axios pour effectuer une requête GET au serveur
        axios.get('get_student_data.php')
            .then(function(response) {
                // Traiter les données de réponse
                displayStudentData(response.data);
            })
            .catch(function(error) {
                console.error('Erreur lors de la récupération des données des étudiants:', error);
            });
    }

    // Fonction pour afficher les données des étudiants sur la page
    function displayStudentData(data) {
        // Afficher les données des étudiants dans la div #etudiant-info
        // data.forEach(function(student) { /* Afficher les données de chaque étudiant */ });
    }

    // Fonction pour récupérer et afficher la température médiane du groupe
    function getGroupMedianTemperature() {
        // Utiliser Axios pour effectuer une requête GET au serveur
        axios.get('get_group_median_temperature.php')
            .then(function(response) {
                // Afficher la température médiane du groupe dans la div #groupe-info
                document.getElementById('groupe-info').innerText = 'Température médiane du groupe : ' + response.data + '°C';
            })
            .catch(function(error) {
                console.error('Erreur lors de la récupération de la température médiane du groupe:', error);
            });
    }

    // Appeler les fonctions pour récupérer et afficher les données des étudiants et la température médiane du groupe
    getStudentData();
    getGroupMedianTemperature();
});
