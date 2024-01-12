<?php
session_start();

// Vérifier si l'utilisateur est un professeur
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'prof') {
    header("Location: index.php"); // Rediriger vers index.php si ce n'est pas un professeur
    exit();
}


// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eleveIds = isset($_POST['eleve']) ? $_POST['eleve'] : [];
    $date = $_POST['date'];
    $heure = $_POST['heure'];

    try {
        include("connexion.php");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // Récupérer l'ID du professeur depuis la session
    

        // Récupérer l'ID du professeur depuis la session
$profId = $_SESSION['id'];

// Afficher l'ID du professeur pour le débogage
echo "Prof ID from session: " . $profId . "<br>";


        foreach ($eleveIds as $eleveId) {
            // Utiliser une requête préparée pour éviter les attaques par injection SQL
            $sql = "INSERT INTO absences (eleve_id, date, heure, prof_id) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);

            // Liage des paramètres
            $stmt->bindParam(1, $eleveId, PDO::PARAM_INT);
            $stmt->bindParam(2, $date, PDO::PARAM_STR);
            $stmt->bindParam(3, $heure, PDO::PARAM_STR);
            $stmt->bindParam(4, $profId, PDO::PARAM_INT);  // Stocker l'ID du professeur

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
        header("Location: prof_abs_index.php?message=absence_saved");
        exit();
    } catch (PDOException $e) {
        // Afficher des informations sur l'erreur pour le débogage
        echo "Error: " . $e->getMessage();
    }
}

// Fermer la connexion à la base de données
$db = null;
?>
