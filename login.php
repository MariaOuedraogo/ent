<?php
session_start();

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    include("connexion.php");

    $sql = "SELECT id, type, photo_profil, password FROM user WHERE nom = :nom";
    $result = $db->prepare($sql);
    $result->execute(['nom' => $nom]);

    if ($result->rowCount() > 0) {
        $data = $result->fetch(); // Using fetch instead of fetchAll, as we expect a single row

        if (password_verify($mdp, $data["password"])) {
            $_SESSION['id'] = $data["id"]; 
            $_SESSION['nom'] = $nom;
            $_SESSION['type'] = $data["type"];
            $_SESSION['photo_profil'] = $data["photo_profil"];

            


            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            // Incorrect password
            header("Location: index.php?error=incorrect_password");
            exit();
        }
    } else {
        // User does not exist
        header("Location: index.php?error=user_not_found");
        exit();
    }
}

?>
