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

    // Récupérer les trois dernières absences avec les noms des professeurs et la matière
    $sqlAbsences = "SELECT absences.*, user.nom as nom_prof, user.matiere as nom_matiere 
                    FROM absences
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="eleve_abs_index.css">
</head>

<body>

    <div class="ariane">
        <a href='index.php' >accueil&nbsp;/ </a> <a href='#' class="active">&nbsp; Absences </a>
    </div>

    <h1>Absences</h1>
    <hr>
    <main>
    <?php
    if (count($absences) > 0) {
        foreach ($absences as $absence) {
            // Convertir la date au format jour mois année
            setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
            $formattedDate = date('d/m/Y', strtotime($absence['date']));

            echo "<section class='flex-item'>
            <p class='cours'>{$absence['nom_matiere']}</p>
            <p>{$absence['nom_prof']}</p>
            <p>2h</p>

            <div class='footer_abs'>
            <p>{$absence['heure']}</p>
            <p>{$formattedDate}</p>
            </div>
         
            </section>";
        }

        echo "<section class='flex-item last-item '>";
        // Afficher le compteur en JavaScript
        echo "<script>
            var absenceCount = $absenceCount;
            if (absenceCount > 0) {
                document.write('<h2>Vous avez <br> ' + absenceCount + ' absence(s)</h2>');
                
                // Si le nombre d'absences est supérieur ou égal à 10, changer le texte
                if (absenceCount >= 10) {
                    var score = -0.01 * (absenceCount - 10);
                    document.write('<p> ' + score + ' sur votre moyenne</p>');
                }
            } else {
                document.write('<p>Aucune absence enregistrée.</p>');
            }
        </script>";
    } else {
        echo "<p>Aucune absence enregistrée.</p>";
    }

    echo"</section>";
    ?>
</main>
    <a href="eleve_abs_detail.php" class="detail">voir le détail</a>

 

  
</body>


</html>
