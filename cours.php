<?php
session_start();

// Check if the user is logged in and has the correct user type
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'eleve') {
  header("Location: index.php"); // Redirect to index.php if not an "eleve" user
  exit();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Document</title>
  <link rel="stylesheet" href="cours.css">
  <link rel="stylesheet" href="nav_mobile.css">

  <script src="script.js" defer></script>
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

    <a href='profil.php' class='img_profil_desk'><img src='" . $_SESSION[' photo_profil'] . "' alt='' class='profil_img'></img></a>
                               <a href='eleve_msg_index.php'  class='msg'><iconify-icon icon='ion:mail-outline'></iconify-icon></a>
                               <a href='logout.php' class='out'><iconify-icon icon='ion:log-out-outline'></iconify-icon ></a>


            </nav>


<div class=" ariane">
      <a href='index.php'>accueil&nbsp;/ </a> <a href='#' class="active">&nbsp; Ressources pédagogiques </a>
      </div>

      <h1> voici les cours que <br> tu va suivre ce semestre</h1>

      <nav class="bby-nav">
        <a href="cours.php" class='active2'>ressources pédagogiques↘︎</a>
        <a href="outil.php">mes outils ↘ </a>
      </nav>


      <div class="container">
        <section>
          <p class="in">semestre 3</p>
          <p class="will">semestre 4</p>
        </section>

        <div class="angry-grid">
          <div id="item-0" class="item">&nbsp;
            <img src="images/cours.png" alt="">
            <div class="box_link">
              <h2>Déploiement de service</h2>
              <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
            </div>
            <p>12/06/24</p>
            <hr>
            <p>total cours</p>
            <p class="heures">28 heures</p>
          </div>

          <div id="item-1" class="item">&nbsp;
            <img src="images/cours.png" alt="">
            <div class="box_link">
              <h2>Déploiement de service</h2>
              <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
            </div>
            <p>12/06/24</p>
            <hr>
            <p>total cours</p>
            <p class="heures">28 heures</p>
          </div>

          <div id="item-2" class="item">&nbsp;
            <img src="images/cours.png" alt="">
            <div class="box_link">
              <h2>Déploiement de service</h2>
              <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
            </div>
            <p>12/06/24</p>
            <hr>
            <p>total cours</p>
            <p class="heures">28 heures</p>
          </div>

          <div id="item-3" class="item">&nbsp;
            <img src="images/cours.png" alt="">
            <div class="box_link">
              <h2>Déploiement de service</h2>
              <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
            </div>
            <p>12/06/24</p>
            <hr>
            <p>total cours</p>
            <p class="heures">28 heures</p>
          </div>

          <div id="item-4" class="item">&nbsp;
            <img src="images/cours.png" alt="">
            <div class="box_link">
              <h2>Déploiement de service</h2>
              <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
            </div>
            <p>12/06/24</p>
            <hr>
            <p>total cours</p>
            <p class="heures">28 heures</p>
          </div>

          <div id="item-5" class="item">&nbsp;
            <img src="images/cours.png" alt="">
            <div class="box_link">
              <h2>Déploiement de service</h2>
              <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
            </div>
            <p>12/06/24</p>
            <hr>
            <p>total cours</p>
            <p class="heures">28 heures</p>
          </div>
        </div>
      </div>

      <div id="popup" class="popup">
        <div class="popup-content">
          <span class="close" onclick="closePopup()">&times;</span>
          <p>tu n'as pas encore accès à cette section</p>
        </div>
      </div>


      <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const willElement = document.querySelector('.will');
          const popupElement = document.getElementById('popup');

          willElement.addEventListener('click', function() {
            popupElement.style.display = 'block';
          });
        });

        function closePopup() {
          const popupElement = document.getElementById('popup');
          popupElement.style.display = 'none';
        }
      </script>

      <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</body>

</html>