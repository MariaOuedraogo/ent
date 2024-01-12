<?php
session_start();

if (!isset($_SESSION['nom'])) {
    header("Location: index.php");
    exit();
}

include("connexion.php");

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "profil/";

    // Utiliser le nom d'utilisateur en session pour le nom du fichier
    $newFileName = $_SESSION['nom'] . ".jpg";
    $targetFile = $targetDir . $newFileName;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));



// Vérifier la taille du fichier
if ($_FILES["photo_profil"]["size"] > 500000) {
    $_SESSION['update_message'] = "Désolé, votre fichier est trop volumineux.";
    $uploadOk = 0;
}

// Autoriser certains formats de fichiers
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $_SESSION['update_message'] = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
    $uploadOk = 0;
}

// Vérifier si le fichier a été téléchargé
if ($uploadOk == 0) {
    $_SESSION['update_message'] = "Désolé, votre fichier n'a pas été téléchargé. Tentez à nouveau avec un fichier différent";
} else {
    // Tout est bon, tenter de télécharger le fichier
    if (move_uploaded_file($_FILES["photo_profil"]["tmp_name"], $targetFile)) {
        $_SESSION['update_message'] = "Le fichier " . htmlspecialchars(basename($_FILES["photo_profil"]["name"])) . " a été téléchargé.";

        // Mettre à jour le chemin de la photo de profil dans la base de données
        $updateSql = "UPDATE user SET photo_profil = :photo_profil WHERE nom = :nom";
        $updateResult = $db->prepare($updateSql);
        $updateResult->bindParam(':photo_profil', $targetFile);
        $updateResult->bindParam(':nom', $_SESSION['nom']);
        $updateResult->execute();
    } else {
        $_SESSION['update_message'] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
    }
}

// Redirection 
header("Location: update_photo.php");
exit();

}
$db = null;

?>

