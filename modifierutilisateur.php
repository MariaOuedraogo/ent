<?php

// Vérifier si l'utilisateur est connecté en tant qu'admin
session_start();
if (isset($_SESSION['type']) && $_SESSION['type'] === 'admin') {
    include("connexion.php");


    // Vérifier si l'ID de l'utilisateur est présent dans l'URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Récupérer les informations de l'utilisateur
        $sql = "SELECT * FROM user WHERE id = :id";
        $result = $db->prepare($sql);
        $result->execute(['id' => $id]);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo"
            <!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<body>
<a href='matiereprof.php'>matiere prof</a>
            <a href='admin.php'>admin</a>
            <a href='logout.php'>Déconnexion</a>

            // Afficher le formulaire de modification
            <h2>Modifier l'utilisateur</h2>
                <form action='modifierutilisateurprocess.php' method='post'>
                    <input type='hidden' name='id' value='{$user['id']}'>
                    <label for='nom'>Nom :</label>
                    <input type='text' id='nom' name='nom' value='{$user['nom']}' required>
                    <label for='password'>Nouveau mot de passe :</label>
                    <input type='password' id='password' name='password'>
                    <input type='submit' name='submit' value='Modifier'>
                </form>";
        } else {
            echo "Utilisateur non trouvé.";
        }

    } else {
        echo "ID de l'utilisateur non spécifié.";
    }

} else {
    // Redirection si l'utilisateur n'est pas un administrateur
    header("Location: index.php");
    exit();
}
echo"
</body>

</html>
";

// Fermer la connexion à la base de données
$db = null;
?>
