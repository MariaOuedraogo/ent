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

    // Récupérer toutes les absences de l'élève connecté
    $sqlAbsencesAll = "SELECT * FROM absences WHERE eleve_id = :eleveId ORDER BY date DESC, heure DESC";
    $stmtAbsencesAll = $db->prepare($sqlAbsencesAll);
    $stmtAbsencesAll->bindParam(':eleveId', $userId);
    $stmtAbsencesAll->execute();
    $absencesAll = $stmtAbsencesAll->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les trois dernières absences avec les noms des professeurs
    $sqlAbsences = "SELECT absences.*, user.nom as nom_prof FROM absences
                    INNER JOIN user ON absences.prof_id = user.id
                    WHERE absences.eleve_id = :eleveId
                    ORDER BY absences.date DESC, absences.heure DESC LIMIT 3";

    $stmtAbsences = $db->prepare($sqlAbsences);
    $stmtAbsences->bindParam(':eleveId', $userId);
    $stmtAbsences->execute();
    $absences = $stmtAbsences->fetchAll(PDO::FETCH_ASSOC);

    // Nombre total d'absences
    $absenceCount = count($absencesAll);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser les Absences</title>
    <link rel="stylesheet" href="eleve_abs_index.css">
</head>

<body>

    <a href="index.php">Retour</a>
    <h2>Visualiser vos Absences</h2>

    <main>
    <?php
    if (count($absences) > 0) {
        foreach ($absences as $absence) {
            // Convertir la date au format jour mois année
            setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
            $formattedDate = strftime('%A %e %B %Y', strtotime($absence['date']));

            echo "<section>
            <p>intégration</p>
            <p> {$absence['nom_prof']}</p>
            <p>2h</p>


            <p>{$formattedDate}</p>
            <p> {$absence['heure']}</p>
            </section>";
        }

        // Afficher le compteur en JavaScript
        echo "<script>
            var absenceCount = $absenceCount;
            if (absenceCount > 0) {
                document.write('<div><p>Vous avez ' + absenceCount + '</p>');
                
                // Si le nombre d'absences est supérieur ou égal à 10, changer le texte
                if (absenceCount >= 10) {
                    var score = -0.01 * (absenceCount - 10);
                    document.write('<p> ' + score + ' sur votre moyenne</p></div>');
                }
            } else {
                document.write('<p>Aucune absence enregistrée.</p>');
            }
        </script>";
    } else {
        echo "<p>Aucune absence enregistrée.</p>";
    }
    ?>
</main>
    <a href="eleve_abs_detail.php">voir le detail</a>

</body>

</html>
