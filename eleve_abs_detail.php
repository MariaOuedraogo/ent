<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser les Absences</title>
    <link rel="stylesheet" href="eleve_abs_detail.css">

    <!-- Ajoutez vos liens CSS ici -->
</head>

<body>
    <a href="index.php">Accueil</a>
    <h2>Visualiser vos Absences</h2>

    <form action="" method="get" id="filterForm">
        <label for="dateFilter">Filtrer par date :</label>
        <input type="date" id="dateFilter" name="dateFilter">
        <button type="submit">Filtrer</button>
        <button type="button" onclick="showAllAbsences()">Voir toutes les absences</button>
    </form>

    <?php
    session_start();

    // Vérifier si l'utilisateur est un étudiant
    if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'eleve') {
        header("Location: index.php"); // Redirige vers index.php si ce n'est pas un étudiant
        exit();
    }

    try {
        include("connexion.php");

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer l'ID de l'élève à partir de la base de données
        $sqlUserId = "SELECT id FROM user WHERE nom = :nom LIMIT 1";
        $stmtUserId = $db->prepare($sqlUserId);
        $stmtUserId->bindParam(':nom', $_SESSION['nom']);
        $stmtUserId->execute();
        $userId = $stmtUserId->fetchColumn();

        // Récupérer les absences de l'élève connecté avec le nom du professeur
        $sqlAbsences = "SELECT absences.*, user.nom as nom_prof FROM absences
                        INNER JOIN user ON absences.prof_id = user.id
                        WHERE absences.eleve_id = :eleveId";

        // Ajouter une condition si une date de filtrage est spécifiée
        if (isset($_GET['dateFilter']) && !empty($_GET['dateFilter'])) {
            $sqlAbsences .= " AND absences.date = :dateFilter";
        }

        $sqlAbsences .= " ORDER BY absences.date DESC, absences.heure DESC";

        $stmtAbsences = $db->prepare($sqlAbsences);
        $stmtAbsences->bindParam(':eleveId', $userId);

        // Lié la date de filtrage si elle est spécifiée
        if (isset($_GET['dateFilter']) && !empty($_GET['dateFilter'])) {
            $stmtAbsences->bindParam(':dateFilter', $_GET['dateFilter']);
        }

        $stmtAbsences->execute();
        $absences = $stmtAbsences->fetchAll(PDO::FETCH_ASSOC);

        // Nombre total d'absences
        $absenceCount = $stmtAbsences->rowCount();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>



    <?php
    echo" <main>";
    if ($absenceCount > 0) {
        foreach ($absences as $absence) {
            // Convertir la date au format jour mois année
            setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
            $formattedDate = date('d/m/Y', strtotime($absence['date']));

            echo "<section class='flex-item'>
            <p>intégration</p>
            <p> {$absence['nom_prof']}</p>
            <p>2h</p>

            <div class='footer_abs'>
            <p> {$absence['heure']}</p>

            <p>{$formattedDate}</p>
            </div>
         
            </section>";
        }

        // Afficher le compteur en JavaScript
        echo "<script>
            var absenceCount = $absenceCount;
            if (absenceCount > 0) {
                document.write('<p>Nombre total d\'absences: ' + absenceCount + '</p>');
                
                // Si le nombre d'absences est supérieur ou égal à 10, changer le texte
                if (absenceCount >= 10) {
                    var score = -0.01 * (absenceCount - 10);
                    document.write('<p>malus: ' + score + '</p>');
                }
            } else {
                document.write('<p>Aucune absence enregistrée.</p>');
            }
        </script>";

        // Mettre à jour la session avec le nombre total d'absences
        $_SESSION['absenceCount'] = $absenceCount;
    } else {
        echo "<p>Aucune absence enregistrée.</p>";
    }
    ?>

    <script>
        function showAllAbsences() {
            // Rediriger vers la même URL sans le paramètre de filtre de date
            var currentUrl = window.location.href;
            var newUrl = currentUrl.split('?')[0];
            window.location.href = newUrl;
        }
    </script>

</body>

</html>
