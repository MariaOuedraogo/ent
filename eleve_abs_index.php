<?php
session_start();



// Vérifier si l'utilisateur est un étudiant
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'eleve') {
    header("Location: index.php"); // Redirige vers index.php si ce n'est pas un étudiant
    exit();
}

try {
    include("connexion.php");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'élève à partir de la base de données
    $sqlUserId = "SELECT id FROM user WHERE nom = :nom LIMIT 1";
    $stmtUserId = $db->prepare($sqlUserId);
    $stmtUserId->bindParam(':nom', $_SESSION['nom']);
    $stmtUserId->execute();
    $userId = $stmtUserId->fetchColumn();

    // Récupérer toutes les absences de l'élève connecté
    $sqlAbsencesAll = "SELECT * FROM absences WHERE eleve_id = :eleveId ORDER BY date DESC, heure DESC";
    $stmtAbsencesAll = $db->prepare($sqlAbsencesAll);
    $stmtAbsencesAll->bindParam(':eleveId', $userId);
    $stmtAbsencesAll->execute();
    $absencesAll = $stmtAbsencesAll->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les trois dernières absences avec les noms des professeurs et la matière
    $sqlAbsences = "SELECT absences.*, user.nom as nom_prof, user.matiere as nom_matiere 
                    FROM absences
                    INNER JOIN user ON absences.prof_id = user.id
                    WHERE absences.eleve_id = :eleveId
                    ORDER BY absences.date DESC, absences.heure DESC LIMIT 3";

    $stmtAbsences = $db->prepare($sqlAbsences);
    $stmtAbsences->bindParam(':eleveId', $userId);
    $stmtAbsences->execute();
    $absences = $stmtAbsences->fetchAll(PDO::FETCH_ASSOC);

    // Nombre total d'absences
    $absenceCount = count($absencesAll);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualiser les Absences</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="eleve_abs_index.css">
    <link rel="stylesheet" href="nav_mobile.css">

    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>



<div class='navbar-mobile'>
                    <a href='eleve_msg_index.php'  class='messagerie'><img src='msg.png' alt=''></a>

                <i class='fa-solid fa-bars ' tabindex='0' > </i>
                <div class='modal' >
                    <div class='navbar-mobile-list'>
                    <a href='profil.php'><img src='" . $_SESSION['photo_profil'] . "' alt='' class='profil_img'></img></a>
                    <a href='index.php'>accueil</a>
                   <div class='scolarite'>
                   <p> scolarité </p>
                  <a href='#'> ade</a>
    <a href='eleve_abs_index.php'>absences</a>
    <a href='#'>notes </a>
    <a href='cours.php'> ressources pédagogiques</a>
    <a href='outil.php'> mes outils</a>
    <a href='documents.php' class='docu'>mes documents</a>

                   </div>
                    <a href='mention.pdf' target='_blank' >mentions légales</a>
                    <a href='#'>politique de confidentialité</a>


                

                    <a href='logout.php' class='out'><iconify-icon icon='ion:log-out-outline'></iconify-icon ></a>


                    

                   
                    </div>
                </div>
               
            </div>
            <div class='overlay'></div>



<nav class='desk_nav'>
                               <a href='index.php'><img src='home.png' alt='' class='profil_img'></a>
                               
<div class='menu-container'>
    <div class='menu-btn'>scolarité</div>
    <ul class='menu-items'>
    <li><a href='#'> ade</a></li>
    <li><a href='eleve_abs_index.php'>absences</a></li>
    <li><a href='#'>notes </a></li>
    <li><a href='cours.php'> ressources pédagogiques</a></li>
    <li><a href='outil.php'> mes outils</a></li>
    </ul>
</div>
                               <a href='documents.php ' class='docs'>mes documents</a>

                               <a href='profil.php' class='img_profil_desk'><img src='" . $_SESSION['photo_profil'] . "' alt='' class='profil_img'></img></a>
                               <a href='eleve_msg_index.php'  class='msg'><iconify-icon icon='ion:mail-outline'></iconify-icon></a>
                               <a href='logout.php' class='out'><iconify-icon icon='ion:log-out-outline'></iconify-icon ></a>


            </nav>
<body>
               
         



    <div class="ariane">
        <a href='index.php' >accueil&nbsp;/ </a> <a href='#' class="active">&nbsp; Absences </a>
    </div>

    <h1>Absences</h1>
    <hr>
    <main>
    <?php
    if (count($absences) > 0) {
        foreach ($absences as $absence) {
            // Convertir la date au format jour mois année
            setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
            $formattedDate = date('d/m/Y', strtotime($absence['date']));

            echo "<section class='flex-item'>
            <p class='cours'>{$absence['nom_matiere']}</p>
            <p>{$absence['nom_prof']}</p>
            <p>2h</p>

            <div class='footer_abs'>
            <p>{$absence['heure']}</p>
            <p>{$formattedDate}</p>
            </div>
         
            </section>";
        }

        echo "<section class='flex-item last-item '>";
        // Afficher le compteur en JavaScript
        echo "<script>
            var absenceCount = $absenceCount;
            if (absenceCount > 0) {
                document.write('<h2>Vous avez <br> ' + absenceCount + ' absence(s)</h2>');
                
                // Si le nombre d'absences est supérieur ou égal à 10, changer le texte
                if (absenceCount >= 10) {
                    var score = -0.01 * (absenceCount - 10);
                    document.write('<p> ' + score + ' sur votre moyenne</p>');
                }
            } else {
                document.write('<p>Aucune absence enregistrée.</p>');
            }
        </script>";
    } else {
        echo "<p>Aucune absence enregistrée.</p>";
    }

    echo"</section>";
    ?>
</main>
    <a href="eleve_abs_detail.php" class="detail">voir le détail</a>

 

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</body>


</html>
