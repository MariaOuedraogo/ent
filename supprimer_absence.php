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

    // Récupérer l'ID de l'absence à supprimer
    $absenceId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($absenceId) {
        // Supprimer l'absence de la base de données
        $sql = "DELETE FROM absences WHERE id = :absenceId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':absenceId', $absenceId);
        $stmt->execute();

        header("Location: prof_abs_index.php"); // Rediriger vers la page d'index après la suppression
        exit();
    } else {
        echo "ID d'absence manquant.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
