<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser les Absences</title>

    <!-- Ajoutez vos liens CSS ici -->
</head>

<body>
    <a href="index.php">Accueil</a>
    <h2>Visualiser vos Absences</h2>

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
                        WHERE absences.eleve_id = :eleveId
                        ORDER BY absences.date DESC, absences.heure DESC";

        $stmtAbsences = $db->prepare($sqlAbsences);
        $stmtAbsences->bindParam(':eleveId', $userId);
        $stmtAbsences->execute();
        $absences = $stmtAbsences->fetchAll(PDO::FETCH_ASSOC);

        // Nombre total d'absences
        $absenceCount = $stmtAbsences->rowCount();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <?php
    if ($absenceCount > 0) {
        foreach ($absences as $absence) {
            // Convertir la date au format jour mois année
            setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
            $formattedDate = strftime('%A %e %B %Y', strtotime($absence['date']));

            echo "<div>";
            echo "<p>Date: {$formattedDate}</p>";
            echo "<p>Heure: {$absence['heure']}</p>";
            echo "<p>Nom du professeur: {$absence['nom_prof']}</p>"; // Ajout du nom du professeur
            echo "</div>";
            echo "<hr>";
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


</body>

</html>
