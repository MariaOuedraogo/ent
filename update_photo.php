<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour la photo de profil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel='stylesheet' href='photo_profil.css'>
</head>

<body>
<?php
    session_start();

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['nom'])) {
        header("Location: index.php");
        exit();
    }

    try {
        include("connexion.php");

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Utilise une requête pour obtenir le chemin de la photo de profil de l'utilisateur
        $sql = "SELECT photo_profil FROM user WHERE nom = :nom";
        $result = $db->prepare($sql);
        $result->bindParam(':nom', $_SESSION['nom']);
        $result->execute();

        // Vérifie si l'utilisateur a une photo de profil définie
        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $photo_profil = $row['photo_profil'] ? $row['photo_profil'] : 'profil/default.jpg';

            

// ... le reste du code ...

// Afficher le message de mise à jour



            echo "
            <a href='index.php'>accueil</a>
            <h1>Personnalisation du profil</h1>

            <main>
            
            <div class='profil'>
                <div class='image_profil'>
                    <img src='{$photo_profil}' alt='Photo de profil'>
                </div>
                <div class='infos_profil'>
                 
                </div>
            </div>";
        } else {
            echo "<p>Aucune photo de profil trouvée.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
    <form action="update_profile_photo.php" method="post" enctype="multipart/form-data">
   
        
        <label for="photo_profil">Choisir une nouvelle photo de profil :</label>
        <p class=" png">*Nous acceptons les formats de fichier .png et .jpeg/.jpeg</p>
        <input type="file" name="photo_profil" id="photo_profil" accept="image/*" required>
        <input type="submit" value="Mettre à jour" id="submit">
        <?php
        // Afficher le message de mise à jour dans le formulaire
        if (isset($_SESSION['update_message'])) {
            echo "<p class='success'>{$_SESSION['update_message']}</p>";
            unset($_SESSION['update_message']); // Supprime le message de la session après l'affichage
        }
        ?>

    </form>
</main>




</body>

</html>
