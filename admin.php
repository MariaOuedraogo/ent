<!-- admin.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Administration</title>
</head>
<body>
<a href='matiereprof.php'>matiere prof</a>
            <a href='admin.php'>admin</a>
            <a href='logout.php'>Déconnexion</a>
 
<body>
    <h1>Page d'Administration</h1>

    <form action="ajoutermodifierunutilisateur.php" method="post">
        <label for="nom">Nom d'utilisateur :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required>

        <label for="type">Type d'utilisateur :</label>
        <select id="type" name="type" required>
            <option value="eleve">Élève</option>
            <option value="prof">Professeur</option>
            <!-- Ajoutez d'autres options si nécessaire -->
        </select>

        <input type="submit" name="ajouter" value="Ajouter Utilisateur">
    </form>

    <!-- ... le reste du contenu ... -->
</body>
</html>


    <?php
    include("connexion.php");

    // Vérifier si l'utilisateur est connecté en tant qu'admin
    session_start();
    if (isset($_SESSION['type']) && $_SESSION['type'] === 'admin') {

        // Afficher la liste des utilisateurs (élèves et professeurs)
        $sql = "SELECT * FROM user WHERE type IN ('eleve', 'prof')";
        $result = $db->query($sql);

        echo "<table border='1'>
                <tr>
                <th>nom</th>

                    <th>fonction</th>
                    <th>action</th>
                </tr>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['nom']}</td>
                    <td>{$row['type']}</td>
                    <td>
                        <a href='modifierutilisateur.php?id={$row['id']}'>Modifier</a>
                        <a href='supprimerutilisateur.php?id={$row['id']}'>Supprimer</a>
                    </td>
                  </tr>";
        }

        echo "</table>";

    } else {
        // Redirection si l'utilisateur n'est pas un administrateur
        header("Location: index.php");
        exit();
    }

    // Fermer la connexion à la base de données
    $db = null;
    ?>
</body>
</html>
