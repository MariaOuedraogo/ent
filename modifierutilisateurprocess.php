<?php
session_start();

//check is user is a prof
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'admin') {
    header("Location: index.php"); // si non redirect to index page
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifier mdp</title>

</head>
<body>
    <body>
<a href='matiereprof.php'>matiere prof</a>
            <a href='admin.php'>admin</a>
            <a href='logout.php'>Déconnexion</a>
</body>
</body>
</html>

<!-- modifier_utilisateur_process.php -->
<?php
include("connexion.php");

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    // Mettre à jour le nom de l'utilisateur
    $sqlUpdateNom = "UPDATE user SET nom = :nom WHERE id = :id";
    $resultUpdateNom = $db->prepare($sqlUpdateNom);
    $resultUpdateNom->execute(['nom' => $nom, 'id' => $id]);

    // Mettre à jour le mot de passe si fourni
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sqlUpdatePassword = "UPDATE user SET password = :password WHERE id = :id";
        $resultUpdatePassword = $db->prepare($sqlUpdatePassword);
        $resultUpdatePassword->execute(['password' => $hashedPassword, 'id' => $id]);
    }

    echo "Utilisateur modifié avec succès.";
} else {
    echo "Le formulaire n'a pas été soumis correctement.";
}

// Fermer la connexion à la base de données
$db = null;
?>

