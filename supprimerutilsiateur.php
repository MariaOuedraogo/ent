<?php
session_start();
?>

<body>
<a href='matiereprof.php'>matiere prof</a>
            <a href='admin.php'>admin</a>
            <a href='logout.php'>Déconnexion</a>
</body>

<?php
include("connexion.php");

// Vérifier si l'utilisateur est connecté en tant qu'admin

if (isset($_SESSION['type']) && $_SESSION['type'] === 'admin') {

    // Vérifier si l'ID de l'utilisateur est présent dans l'URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Supprimer l'utilisateur
        $sqlDeleteUser = "DELETE FROM user WHERE id = :id";
        $resultDeleteUser = $db->prepare($sqlDeleteUser);
        $resultDeleteUser->execute(['id' => $id]);

        echo "Utilisateur supprimé avec succès.";
    } else {
        echo "ID de l'utilisateur non spécifié.";
    }

} else {
    // Redirection si l'utilisateur n'est pas un administrateur
    header("Location: index.php");
    exit();
}

// Fermer la connexion à la base de données
$db = null;
?>
