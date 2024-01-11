<?php
session_start();
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>ENT MMI CHAMPS</title>
    <link rel='stylesheet' href='style.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="icon" href="home.png" type="image/png">


    <script src="script.js" defer></script>

</head>

<body>
    <?php
    if (isset($_SESSION['nom'])) {
        // echo "Vous êtes connecté en tant que " . $_SESSION['nom'];
        // echo "<a href='logout.php'>Déconnexion</a>";


        if ($_SESSION['type'] == 'prof') {
            echo "
           

            <nav class='nav-desk-prof'>

            <a href='index.php'><img src='home.png' alt='lien vers la messagerie'></a>
            <a href='eleve_msg_index.php'  class='msg'><iconify-icon icon='ion:mail-outline'></iconify-icon></a>
            <a href='logout.php' class='out'><iconify-icon icon='ion:log-out-outline'></iconify-icon ></a>


            </nav>
            <div id='main'>
            <h1 class='hello'>Bonjour " . $_SESSION['nom'] . " ✌️</h1>
            <h2 class='title_page'> Bienvenu sur ton tableau de bord</h2>
            
            <div class='angry-grid-prof'>
            <div id='box-1' class='box-item'>&nbsp;</div>
            <a href='profil.php' id='box-2' class='box-item'>&nbsp;</a>
            <style>
           #box-2 {
                background-image: url(".$_SESSION['photo_profil'].");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
              
              
            }
        </style>
        
            <div id='box-3' class='box-item'>&nbsp;</div>
            <div id='box-4' class='box-item'>&nbsp;</div>
          </div>
          

          
<div class='angry-grid-prof-desk'>
<div id='box-0'>&nbsp;</div>
<div id='box-1'>&nbsp;</div>
<a href='profil.php' id='box-2'>&nbsp;</a>
<div id='box-3'>
<p>c'est bientôt l'été</p>
    <div id='countdown'></div>
</div>

</div>
          </main>
            ";

          
        }


        // Afficher le lien de déconnexion

        // Afficher le lien vers envoyer_message.php si l'utilisateur est un professeur

        if ($_SESSION['type'] == 'eleve') {


            echo "


                    <div class='navbar-mobile'>
                    <a href='eleve_msg_index.php'  class='messagerie'><img src='msg.png' alt=''></a>

                <i class='fa-solid fa-bars ' tabindex='0' > </i>
                <div class='modal' >
                    <div class='navbar-mobile-list'>
                    <a href='update_photo.php'><img src='" . $_SESSION['photo_profil'] . "' alt='' class='profil_img'></img></a>
                    <a href='index.php'>accueil</a>
                    <a href='profil.php'>mon profil</a>
                    <a href='scolarite.php'>scolarité</a>
                    <a href='documents.php'>mes documents</a>

                

                    <a href='logout.php'><img src='logout.png' alt=''></a>


                    

                   
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
                               <a href='documents.php'>mes documents</a>

                               <a href='profil.php' class='img_profil_desk'><img src='" . $_SESSION['photo_profil'] . "' alt='' class='profil_img'></img></a>
                               <a href='eleve_msg_index.php'  class='msg'><iconify-icon icon='ion:mail-outline'></iconify-icon></a>
                               <a href='logout.php' class='out'><iconify-icon icon='ion:log-out-outline'></iconify-icon ></a>


            </nav>

         
  <div id='main'>
  <h1 class='hello'>Bonjour " . $_SESSION['nom'] . " ✌️</h1>
  <h2 class='title_page'> Bienvenu sur ton tableau de bord</h2>
  <div class='angry-grid'>
  <div id='item-0'>&nbsp;</div>
  <div id='item-1'>&nbsp;</div>
  <div id='item-2'></div>
  <div id='item-3'>&nbsp;</div>
</div>


<style>

</style>

<div class='angry-grid-desk'>
  <div id='item-0'>&nbsp;</div>
  <div id='item-1'>&nbsp;</div>
  <div id='item-2'>
  <p>c'est bientôt l'été</p>
    <div id='countdown'></div>
  </div>
  <div id='item-3'>&nbsp;</div>
  <div id='item-4'>&nbsp;</div>
</div>
  
  </div>

  




            ";
        }
        if ($_SESSION['type'] == 'admin') {
            echo "
            

            
      <nav class='nav-admin-desk'>
      <a href='index.php'><img src='home.png' alt='lien vers la messagerie'></a>


            <a href='admin.php'>gestion de profil</a>
            <a href='matiereprof.php'>assignation de matière</a>

            <a href='update_photo.php'><img src='" . $_SESSION['photo_profil'] . "' alt='' class='profil_img '></img></a>

            <a href='logout.php'><img src='logout.png' alt=''></a>
            </nav>
        
     <div id='main'>
     <h1 class='hello'>Bonjour " . $_SESSION['nom'] . " ✌️</h1>
     <div class='angry-grid-admin'>
     <div id='adm-box-0'><a href='#'>gestion de profil</a></div>
     <div id='adm-box-1'><a href='#'>assignation de matière</a></div>
   </div>
     </div>

     
<div class='angry-grid-admin-desk'>
<div id='adm-box-0'><a href='#'>assignation de matière</a></div>
<div id='adm-box-1'><a href='#'>gestion de profil</a></div>
</div>
            ";
        }
        // echo "<a href='logout.php'>Déconnexion</a>";

        // ... (your login form code)




    } else {
        $error_message = ""; // Initialize the variable

        if (isset($_GET['error']) && $_GET['error'] == 'incorrect_password') {
            $error_message = "*le mot de passe est erroné";
        } elseif (isset($_GET['error']) && $_GET['error'] == 'user_not_found') {
            $error_message = "*l'utilisateur n'éxiste pas";
        }






        echo "
        <img class='image_header' src='mmi.jpg' alt=''>
        <main>
       <header class='header'>
       <h1>BUT MMI <br>
       Champs-sur-Marne</h1>
       <h2> Le site intranet académique est un portail qui centralise : l'ENT pédagogique (les accès aux applications), les actualités de l'université et beaucoup d'informations utiles sur les services et le fonctionnement de l'établissement.</h2></header>
        
            <div class='login-container'>
                <div class='login-card'>
                <p>Service d’authentification</p>
                <p>Connectez-vous pour accéder à votre espace</p>
                 <div class='error-message'>$error_message</div> 
                    <form class='login-form' method='POST' action='login.php'>
                    <label for='identifiant'>identifiant</label>
                        <input type='text' placeholder='identifiant' name='nom'  id='identifiant'  required>

                        <label for='password'>mot de passe</label>
                        <input type='password' placeholder='mot de passe' name='mdp'  id='password' required>
                        <div class='login-buttons'>
                            <button type='submit' class='login-button' name='submit'>connexion</button>
                        </div>
                    </form>
                </div>
            </div>
            </main>

        ";
    }
    ?>
<script>
      function updateCountdown() {
            var now = new Date();
            var targetDate = new Date("June 28, 2024 00:00:00");
            var difference = targetDate - now;

            if (difference > 0) {
                var days = Math.floor(difference / (1000 * 60 * 60 * 24));
                var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((difference % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML = days + " jours, " + hours + " heures, " + minutes + " minutes, " + seconds + " secondes";
            } else {
                document.getElementById("countdown").innerHTML = "Événement terminé!";
            }
        }

        // Mettre à jour le compteur chaque seconde
        setInterval(updateCountdown, 1000);

        // Appel initial pour éviter le délai d'une seconde lors du chargement de la page
        updateCountdown();
</script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    </head>

    <body>


</html>