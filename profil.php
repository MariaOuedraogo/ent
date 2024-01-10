<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="profil.css">

</head>
<body>

<a href='index.php'>Accueil</a>

<?php
session_start();

// Check if the user is a student
if (!isset($_SESSION['nom']) || ($_SESSION['type'] !== 'eleve' && $_SESSION['type'] !== 'prof')) {
    header("Location: index.php"); // Redirect to index.php if not a student
    exit();
}

try {
    include("connexion.php");

    // Set PDO to throw exceptions on errors
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Use a prepared statement to avoid SQL injection
    $sql = "SELECT * FROM user WHERE nom = :studentName";

    $result = $db->prepare($sql);
    $result->bindParam(':studentName', $_SESSION['nom']);
    $result->execute();

    // Fetch the user data
    $row = $result->fetch(PDO::FETCH_ASSOC);

    echo "  <h1>Bienvenue dans ton profil, </h1>";


    echo "

    ";

    // Afficher le nom
    echo "<main>
    <a href='update_photo.php' class='photo'><img src='" . $_SESSION['photo_profil'] . "' alt='' class='out'></a>

    <div class='modifier'>
    <a href='update_photo.php'>Modifier</a>
    </div>

    <section>

    <p>Nom:</p>
  
    <p class='nom'> {$row['nom']}</p>

    </section>

    <section>
    <p>Formation :</p>
  
    <p class='nom'> MMI parcours développement d'interface web</p>

    </section>
    
    ";

    // Afficher la matière si elle n'est pas nulle
    if ($row['matiere'] !== 'null') {
        echo "<p>professeur en {$row['matiere']}</p>";
    }

    // Afficher le mot de passe dans un champ texte (non sécurisé)
    // echo "<label for='mdp_actuel'>Mot de passe actuel:</label> <br>";
    // echo "<input type='password' name='mdp_actuel' value='{$row['password']}' id='mdp_actuel' readonly>";

    // Ajouter un bouton pour basculer la visibilité du mot de passe
    // echo "<button onclick='toggleVisibility()'>voir</button> <br>";



    echo "<h2>Changer votre mot de passe</h2>";

    echo "<form action='changer_mdp.php' method='post'>
    <label for='nouveau_mdp'>Nouveau mot de passe:</label> <br>
    <input type='password' name='nouveau_mdp' required>
    <br>
    <label for='confirmer_mdp'>Confirmer le mot de passe:</label>
    <input type='password' name='confirmer_mdp' required>
    <br>
    <input type='submit' value='Changer le mot de passe' id='submit'>
</form>
</main>
    
    ";
    // Afficher le message d'erreur s'il y en a un
if (isset($_SESSION['erreur_mdp'])) {
    echo "<p>{$_SESSION['erreur_mdp']}</p>";
    unset($_SESSION['erreur_mdp']); // Supprimer la variable de session après l'avoir affichée
}

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<script>
// Fonction pour basculer la visibilité du mot de passe
function toggleVisibility() {
    var mdpActuel = document.getElementById('mdp_actuel');
    mdpActuel.type = (mdpActuel.type === 'password') ? 'text' : 'password';
}
</script>

</body>
</html>
