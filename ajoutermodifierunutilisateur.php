<body>
<a href='matiereprof.php'>matiere prof</a>
            <a href='admin.php'>admin</a>
            <a href='logout.php'>Déconnexion</a>
</body>
<?php
include("connexion.php");

session_start();

if (isset($_SESSION['type']) && $_SESSION['type'] === 'admin') {

    if (isset($_POST['ajouter'])) {
        $nom = $_POST['nom'];
        $mdp = $_POST['mdp'];
        $type = $_POST['type'];

        // Vérifier si l'utilisateur existe déjà
        $sqlCheckUser = "SELECT * FROM user WHERE nom = :nom";
        $resultCheckUser = $db->prepare($sqlCheckUser);
        $resultCheckUser->execute(['nom' => $nom]);

        if ($resultCheckUser->rowCount() > 0) {
            echo "L'utilisateur existe déjà.";
        } else {
            // Ajouter un nouvel utilisateur avec mot de passe
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
            $sqlInsertUser = "INSERT INTO user (nom, password, type) VALUES (:nom, :password, :type)";
            $resultInsertUser = $db->prepare($sqlInsertUser);
            $resultInsertUser->execute(['nom' => $nom, 'password' => $hashedPassword, 'type' => $type]);

            echo "Utilisateur ajouté avec succès.";
        }
    }

    // ... Ajoutez ici la partie pour modifier les utilisateurs si nécessaire ...

} else {
    // Redirection si l'utilisateur n'est pas un administrateur
    header("Location: index.php");
    exit();
}

// Fermer la connexion à la base de données
$db = null;
?>
