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

    // Récupérer l'ID de l'absence à modifier
    $absenceId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($absenceId) {
        // Récupérer les détails de l'absence à modifier
        $sql = "SELECT * FROM absences WHERE id = :absenceId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':absenceId', $absenceId);
        $stmt->execute();
        $absenceDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($absenceDetails) {
            // Traitez les modifications du formulaire ici
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
                // Récupérer les données du formulaire
                $newDate = $_POST["newDate"];
                $newHeure = $_POST["newHeure"];

                // Mettez à jour l'absence dans la base de données
                $updateSql = "UPDATE absences SET date = :newDate, heure = :newHeure WHERE id = :absenceId";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bindParam(':newDate', $newDate);
                $updateStmt->bindParam(':newHeure', $newHeure);
                $updateStmt->bindParam(':absenceId', $absenceId);

                if ($updateStmt->execute()) {
                    echo "Absence modifiée avec succès!";
                } else {
                    echo "Erreur lors de la modification de l'absence : " . $updateStmt->errorInfo()[2];
                }
            }
        } else {
            echo "Absence introuvable.";
        }
    } else {
        echo "ID d'absence manquant.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="eleve_abs_index.css">
    <title>Modifier une Absence</title>
</head>

<body>

    <div class="ariane">
    <a href='index.php' >accueil&nbsp;/ </a> <a href='prof_abs_index.php'>&nbsp; absences / </a><a href='#' class="active">&nbsp; modifier absences</a>
    </div>
    <h1>Modifier une Absence</h1>

    <div class='modif_abs'>
    <form method="post">
        <input type="hidden" name="absenceId" value="<?php echo $absenceId; ?>">

        <label for="newDate">Nouvelle Date:</label>
        <input type="date" id="newDate" name="newDate" value="<?php echo $absenceDetails['date']; ?>" required>
        &nbsp; 
        <label for="newHeure">Nouvelle Heure:</label>
        <input type="time" id="newHeure" name="newHeure" value="<?php echo $absenceDetails['heure']; ?>" required>
        <br>
        <br>
        <button type="submit" name="submit">Modifier l'Absence</button>
    </form>
    </div>

</body>

</html>
