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
    <link rel="stylesheet" href="cours_detail.css">
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

<div class="ariane">
<a href='index.php' >accueil&nbsp;/ </a> <a href='cours.php'>&nbsp; Ressources pédagogiques /</a><a href='#' class="active">&nbsp; Deploiement de services </a>
</div>

<h1>Deploiement<br> de services</h1>

<p class="prof">Matthieu Berthet</p>

<p class="descriptif">
Au programmre, streaming et chiffrement/cryptographie principes et mise en oeuvre.
Compétence ciblée :
Développer pour le web et les médias numériques.
Apprentissages </p>

<hr>

<div class="container">
<section>
<p class="in">semestre 3</p>
<p class="will">semestre 4</p>
</section>

<div class="angry-grid">
  <div id="item-0" class="item">&nbsp;
    <h2>&nbsp;TD1 Mail Exercice Fichier</h2>
        <div class="item-footer">
            <p>1.4MB</p>
            <p>PDF</p>
            <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
        </div>
    </div>
  <div id="item-1" class="item">&nbsp;
    <h2>&nbsp;TD1 Mail Exercice Fichier</h2>
        <div class="item-footer">
            <p>1.4MB</p>
            <p>PDF</p>
            <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
        </div>
  </div>
  <div id="item-2" class="item">&nbsp;
    <h2>&nbsp;TD1 Mail Exercice Fichier</h2>
        <div class="item-footer">
            <p>1.4MB</p>
            <p>PDF</p>
            <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
        </div>
  </div>
  <div id="item-3" class="item">&nbsp;
    <h2>&nbsp;TD1 Mail Exercice Fichier</h2>
        <div class="item-footer">
            <p>1.4MB</p>
            <p>PDF</p>
            <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
        </div>
  </div>
  <div id="item-4" class="item">&nbsp;
    <h2>&nbsp;TD1 Mail Exercice Fichier</h2>
        <div class="item-footer">
            <p>1.4MB</p>
            <p>PDF</p>
            <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
        </div>
  </div>
  <div id="item-5" class="item">&nbsp;
    <h2>&nbsp;TD1 Mail Exercice Fichier</h2>
        <div class="item-footer">
            <p>1.4MB</p>
            <p>PDF</p>
            <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
        </div>
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
      document.addEventListener('DOMContentLoaded', function () {
    const willElement = document.querySelector('.will');
    const popupElement = document.getElementById('popup');

    willElement.addEventListener('click', function () {
        popupElement.style.display = 'block';
    });
});

function closePopup() {
    const popupElement = document.getElementById('popup');
    popupElement.style.display = 'none';
}

    </script>
</body>
</html>