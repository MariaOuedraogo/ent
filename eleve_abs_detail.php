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

        // Récupérer les absences de l'élève connecté avec le nom du professeur
        $sqlAbsences = "SELECT absences.*, user.nom as nom_prof, user.matiere FROM absences
        INNER JOIN user ON absences.prof_id = user.id
        WHERE absences.eleve_id = :eleveId";


        // Ajouter une condition si une date de filtrage est spécifiée
        if (isset($_GET['dateFilter']) && !empty($_GET['dateFilter'])) {
            $sqlAbsences .= " AND absences.date = :dateFilter";
        }

        $sqlAbsences .= " ORDER BY absences.date DESC, absences.heure DESC";

        $stmtAbsences = $db->prepare($sqlAbsences);
        $stmtAbsences->bindParam(':eleveId', $userId);

        // Lié la date de filtrage si elle est spécifiée
        if (isset($_GET['dateFilter']) && !empty($_GET['dateFilter'])) {
            $stmtAbsences->bindParam(':dateFilter', $_GET['dateFilter']);
        }

        $stmtAbsences->execute();
        $absences = $stmtAbsences->fetchAll(PDO::FETCH_ASSOC);

        // Nombre total d'absences
        $absenceCount = $stmtAbsences->rowCount();
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


    <link rel="stylesheet" href="eleve_abs_detail.css">
    <link rel="stylesheet" href="nav_mobile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="script.js" defer></script>


    <!-- Ajoutez vos liens CSS ici -->
</head>

<body>


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
    <div class="ariane">
    <a href='index.php' >accueil&nbsp;/ </a> <a href='eleve_abs_index.php'>&nbsp;Absences&nbsp;/</a><a href='#' class="active">&nbsp; Absences détails</a>
    </div>
    <h1>Visualiser vos absences</h1>
    

    <form action="" method="get" id="filterForm">
        <label for="dateFilter">Filtrer par date :</label>
        <input type="date" id="dateFilter" name="dateFilter">
        <button type="submit">Filtrer</button>
        <button type="button" onclick="showAllAbsences()">Voir toutes les absences</button>
    </form>




    <?php
    echo" <main>";
    if ($absenceCount > 0) {
        foreach ($absences as $absence) {
            // Convertir la date au format jour mois année
            setlocale(LC_TIME, 'fr_FR.utf8'); // Définir la locale pour le français
            $formattedDate = date('d/m/Y', strtotime($absence['date']));

            echo "<section class='flex-item'>
            <p class='cours'>{$absence['matiere']}</p>
            <p> {$absence['nom_prof']}</p>
            <p>2h</p>

            <div class='footer_abs'>
            <p> {$absence['heure']}</p>

            <p>{$formattedDate}</p>
            </div>
         
            </section>";
        }

        echo"<div class='nbr_abs flex-item'>";
        // Afficher le compteur en JavaScript
        echo "<script>
            var absenceCount = $absenceCount;
            if (absenceCount > 0) {
                document.write('<h2> Vous avez <br> ' + absenceCount + ' absences</h2>');
                
                // Si le nombre d'absences est supérieur ou égal à 10, changer le texte
                if (absenceCount >= 10) {
                    var score = -0.01 * (absenceCount - 10);
                    document.write('<p>malus: ' + score + '</p>');
                }
            } else {
                document.write('<p>Aucune absence enregistrée.</p>');
            }
        </script>";

        // Mettre à jour la session avec le nombre total d'absences
        $_SESSION['absenceCount'] = $absenceCount;
    } else {
        echo "<p>Aucune absence enregistrée.</p>";
    }

    echo"</div>";
    ?>

    <script>
        function showAllAbsences() {
            // Rediriger vers la même URL sans le paramètre de filtre de date
            var currentUrl = window.location.href;
            var newUrl = currentUrl.split('?')[0];
            window.location.href = newUrl;
        }
    </script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</body>

</html>
