<?php
session_start();;

// Vérifier si l'utilisateur est un professeur
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'prof') {
    header("Location: index.php"); // Rediriger vers index.php si ce n'est pas un professeur
    exit();
}




// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $eleveIds = isset($_POST['eleve']) ? $_POST['eleve'] : [];
    $date = $_POST['date'];
    $heure = $_POST['heure'];

    try {
        include("connexion.php");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer l'ID du professeur depuis la session
        $profId = $_SESSION['id'];
        


        foreach ($eleveIds as $eleveId) {
            // Utiliser une requête préparée pour éviter les attaques par injection SQL
            $sql = "INSERT INTO absences (eleve_id, date, heure, prof_id) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);

            // Liage des paramètres
            $stmt->bindParam(1, $eleveId, PDO::PARAM_INT);
            $stmt->bindParam(2, $date, PDO::PARAM_STR);
            $stmt->bindParam(3, $heure, PDO::PARAM_STR);
            $stmt->bindParam(4, $profId, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo "Absence enregistrée avec succès!";
            } else {
                echo "Erreur lors de l'enregistrement de l'absence.";
            }

            // Fermer la requête préparée
            $stmt->closeCursor();
        }

        // Rediriger vers index.php avec un message de succès
        header("Location: index.php?message=absence_saved");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getAllStudentNames()
{
    include("connexion.php");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id, nom FROM user WHERE type = 'eleve'";
    $result = $db->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer Absence</title>
</head>

<body>
    <a href="prof_abs_index.php">Retour</a>
    <h2>Enregistrer Absence</h2>
    <form method="POST" action="prof_abs_traitement.php">

        <label for="date">Date :</label>
        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required>

        <label for="heure">Heure :</label>
        <select name="heure" required>
            <option value="08:15">8h15</option>
            <option value="08:30">8h30</option>
            <option value="08:45">8h45</option>
            <option value="09:00">9h00</option>
            <option value="10:30">10h30</option>
            <option value="13:30">13h30</option>
            <option value="15:30">15h30</option>
        </select>

        <label for="eleve">Élèves :</label>
        <?php $studentNames = getAllStudentNames(); ?>
        <?php foreach ($studentNames as $student) : ?>
            <input type="checkbox" name="eleve[]" value="<?php echo $student['id']; ?>">
            <?php echo $student['nom']; ?><br>
        <?php endforeach; ?>

        <button type="submit" name="submit">Enregistrer Absence</button>
    </form>
</body>

</html>
