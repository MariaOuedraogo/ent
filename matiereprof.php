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
    <h1>Page d'Administration</h1>

    <form action="matiereprof.php" method="post">
        <label for="professeur">Professeur :</label>
        <select id="professeur" name="professeur" required>
            <?php
            // Inclure la connexion à la base de données
            include("connexion.php");

            // Sélectionner tous les professeurs
            $sqlProfesseurs = "SELECT * FROM user WHERE type = 'prof'";
            $resultProfesseurs = $db->query($sqlProfesseurs);

            // Afficher chaque professeur dans la liste déroulante
            while ($rowProfesseur = $resultProfesseurs->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $rowProfesseur['nom'] . "'>" . $rowProfesseur['nom'] . "</option>";
            }

            // Fermer la connexion à la base de données
            $db = null;
            ?>
        </select>
            
        <label for="matiere">Matière :</label>
        <select id="matiere" name="matiere" required>
            <?php
            // Réouvrir la connexion à la base de données
            include("connexion.php");

            // Sélectionner toutes les matières depuis la table matieres
            $sqlMatieres = "SELECT * FROM matieres";
            $resultMatieres = $db->query($sqlMatieres);

            // Afficher chaque matière dans la liste déroulante
            while ($rowMatiere = $resultMatieres->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $rowMatiere['nom'] . "'>" . $rowMatiere['nom'] . "</option>";
            }

            // Fermer la connexion à la base de données
            $db = null;
            ?>
        </select>

        <input type="submit" name="submit" value="Ajouter/Éditer Matière">
    </form>
</body>
</html>
<?php
session_start();

if (isset($_SESSION['type']) && $_SESSION['type'] === 'admin') {
    // Vérifiez si le formulaire a été soumis
    if (isset($_POST['submit'])) {
        $professeur = $_POST['professeur'];
        $matiere = $_POST['matiere'];

        include("connexion.php");

        // Vérifiez si le professeur existe déjà dans la base de données
        $sqlProf = "SELECT * FROM user WHERE nom = :professeur AND type = 'prof'";
        $resultProf = $db->prepare($sqlProf);
        $resultProf->execute(['professeur' => $professeur]);

        if ($resultProf->rowCount() > 0) {
            // Le professeur existe, mettez à jour la matière
            $sqlUpdate = "UPDATE user SET matiere = :matiere WHERE nom = :professeur AND type = 'prof'";
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->execute(['professeur' => $professeur, 'matiere' => $matiere]);
        } else {
            // Le professeur n'existe pas, ajoutez-le avec la matière
            $sqlInsert = "INSERT INTO user (nom, type, matiere) VALUES (:professeur, 'prof', :matiere)";
            $stmtInsert = $db->prepare($sqlInsert);
            $stmtInsert->execute(['professeur' => $professeur, 'matiere' => $matiere]);
        }

        echo "Opération réussie !";
    }
} else {
    // Redirection si l'utilisateur n'est pas un administrateur
    header("Location: index.php");
    exit();
}
?>
