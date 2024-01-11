<?php
session_start();

// Vérification de la session
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'eleve') {
    header("Location: index.php");
    exit();
}

try {
    include("connexion.php");

    // ... (votre code pour changer le mot de passe)

    // Nouveau mot de passe saisi par l'utilisateur
    $nouveau_mdp = $_POST['nouveau_mdp'];

    // Confirmation du nouveau mot de passe
    $confirmer_mdp = $_POST['confirmer_mdp'];

    // Vérifier que le mot de passe et la confirmation sont identiques
    if ($nouveau_mdp !== $confirmer_mdp) {
        $_SESSION['erreur_mdp'] = "*Les mots de passe ne correspondent pas.";
        header("Location: profil.php"); // Redirection vers la page précédente
        exit();
    }

    // Hasher le nouveau mot de passe avant de le stocker
    $hashed_password = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

    // Mise à jour du mot de passe dans la base de données
    $update_sql = "UPDATE user SET password = :nouveau_mdp WHERE nom = :studentName";
    $update_result = $db->prepare($update_sql);
    $update_result->bindParam(':nouveau_mdp', $hashed_password);
    $update_result->bindParam(':studentName', $_SESSION['nom']);
    $update_result->execute();

    // Déconnexion de l'utilisateur
    session_unset();
    session_destroy();

    // Redirection vers logout.php
    header("Location: logout.php");
    exit();

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
