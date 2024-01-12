<?php
session_start();

// Vérifier si l'utilisateur est un professeur
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'prof') {
    header("Location: index.php"); // Rediriger vers index.php si ce n'est pas un professeur
    exit();
}



try {
    include("connexion.php");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlUserId = "SELECT id FROM user WHERE nom = :nom LIMIT 1";
    $stmtUserId = $db->prepare($sqlUserId);
    $stmtUserId->bindParam(':nom', $_SESSION['nom']);
    $stmtUserId->execute();
    $userId = $stmtUserId->fetchColumn();
    


    if (!$userId) {
        // Ajouter une redirection vers la page d'erreur ou afficher un message
        echo "Erreur: Impossible de récupérer l'ID du professeur.";
        exit();
    }




    // Vérifier si une date est sélectionnée dans le formulaire, sinon utiliser la date actuelle
    $selectedDate = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');

    // Récupérer toutes les absences enregistrées avec les noms des élèves
    $sql = "SELECT absences.*, user.nom as nom_eleve FROM absences
    INNER JOIN user ON absences.eleve_id = user.id
    WHERE absences.prof_id = :profId
    ORDER BY absences.date DESC, absences.heure DESC";



    $result = $db->prepare($sql);
    $result->bindParam(':profId', $userId);
    $result->execute();
    $allAbsences = $result->fetchAll(PDO::FETCH_ASSOC);

    // Filtrer les absences par date si une date est sélectionnée
    $absences = isset($_POST['selected_date']) ? array_filter($allAbsences, function ($absence) use ($selectedDate) {
        return $absence['date'] == $selectedDate;
    }) : $allAbsences;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser les Absences prof</title>
    <link rel="stylesheet" href="eleve_abs_index.css">

</head>

<body>


<style>
    /* Style du popup */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        z-index: 1000;
    }

    /* Style du fond sombre en arrière-plan */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    /* Style du bouton dans le popup */
    .popup button {
        background-color: #4caf50;
        color: #fff;
        padding: 10px;
        border: none;
        cursor: pointer;
    }
</style>

    <a href="index.php">Retour</a>
    <h2>Visualiser les Absences</h2>

    <a href="prof_abs_form.php">Entrer des absences</a>

    <a href="prof_abs_form.php" class='btn_abs'>Entrer des absences</a>
    <br>
    <div class='filtre_abs'>
    <form method="post">
        <label for="selected_date">Sélectionner une date:</label>
        <input type="date" id="selected_date" name="selected_date" value="<?php echo $selectedDate; ?>" required>
        <button type="submit">Filtrer</button>
    </form>
    </div>

    <form method="post">
        <button type="submit" name="showAll">Voir toutes les absences</button>
    </form>
    </div>

    <main class="prof">
    <?php
    $currentDate = null;
    foreach ($absences as $absence) :
        // Convertir la date au format jour mois année
        setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
        $formattedDate = date('d/m/Y', strtotime($absence['date']));

        // Vérifier si la date a changé
        if ($formattedDate !== $currentDate) {
            // Afficher le titre avec la nouvelle date
            echo "<h3>{$formattedDate}</h3>";
            $currentDate = $formattedDate;
        }
    ?>
   
            <section class='flex-item'>
            <p>Élève: <?php echo $absence['nom_eleve']; ?></p>
            <p>Heure: <?php echo date('H:i', strtotime($absence['heure'])); ?></p>

            <!-- Ajouter des liens pour la suppression et la modification -->
           <div class="actions">
           <a class='mod'  href='modifier_absence.php?id=<?php echo $absence['id']; ?>'>Modifier</a>
           <a href='#'  class='suppr' onclick='confirmDelete(<?php echo $absence['id']; ?>)'>Supprimer</a>

           </div>

<!-- Popup de confirmation -->
<div id="deletePopup" class="popup">
    <p>Êtes-vous sûr de vouloir supprimer cette absence?</p>
    <button id="confirmButton" onclick="performDelete()">Oui</button>
    <button id="cancelButton" onclick="closePopup()">Annuler</button>
</div>

<!-- Fond sombre en arrière-plan -->
<div id="overlay" class="overlay" onclick="closePopup()"></div>


<!-- confirmation -->
<script>
    function confirmDelete(absenceId) {
        var popup = document.getElementById('deletePopup');
        var overlay = document.getElementById('overlay');
        var confirmButton = document.getElementById('confirmButton');
        var cancelButton = document.getElementById('cancelButton');

        // Afficher le popup et l'overlay
        popup.style.display = 'block';
        overlay.style.display = 'block';

        // Attribuer l'ID de l'absence au bouton de confirmation
        confirmButton.setAttribute('data-absence-id', absenceId);
    }

    function closePopup() {
        var popup = document.getElementById('deletePopup');
        var overlay = document.getElementById('overlay');

        // Cacher le popup et l'overlay
        popup.style.display = 'none';
        overlay.style.display = 'none';
    }

    function performDelete() {
        var confirmButton = document.getElementById('confirmButton');
        var absenceId = confirmButton.getAttribute('data-absence-id');

        // Rediriger vers le script de suppression avec l'ID de l'absence
        window.location.href = 'supprimer_absence.php?id=' + absenceId;
    }
</script>


</section>


    <?php endforeach; ?>
    </main>
</body>

</html>
