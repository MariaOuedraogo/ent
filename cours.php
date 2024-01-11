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
    <title>Document</title>
    <link rel="stylesheet" href="cours.css">
    <script src="script.js" defer></script>
</head>
<body>
    

<div class="ariane">
<a href='index.php' >accueil&nbsp;/ </a> <a href='#' class="active">&nbsp; Ressources pédagogiques </a>
</div>

<h1> voici les cours que <br> tu va suivre ce semestre</h1>

<nav>
    <a href="cours.php" class='active2'>ressources pédagogiques↘︎</a>
    <a href="#">mes outils ↘ </a>
</nav>


<div class="container">
<section>
<p class="in">semestre 3</p>
<p class="will">semestre 4</p>
</section>

<div class="angry-grid">
  <div id="item-0" class="item">&nbsp;
     <img src="images/cours.png" alt="">
    <h2>Déploiement de service</h2>
    <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>12/06/24</p>
    <hr>
    <p>total cours</p>
    <p class="heures">28 heures</p>
  </div>
  <div id="item-1" class="item">&nbsp;
    <img src="images/cours.png" alt="">
    <h2>Déploiement de service</h2>
    <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>12/06/24</p>
    <hr>
    <p>total cours</p>
    <p class="heures">28 heures</p>
  </div>
  <div id="item-2" class="item">&nbsp;
    <img src="images/cours.png" alt="">
    <h2>Déploiement de service</h2>
    <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>12/06/24</p>
    <hr>
    <p>total cours</p>
    <p class="heures">28 heures</p>
  </div>
  <div id="item-3" class="item">&nbsp;
   <img src="images/cours.png" alt="">
    <h2>Déploiement de service</h2>
    <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>12/06/24</p>
    <hr>
    <p>total cours</p>
    <p class="heures">28 heures</p>
  </div>
  <div id="item-4" class="item">&nbsp;
    <img src="images/cours.png" alt="">
    <h2>Déploiement de service</h2>
    <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>12/06/24</p>
    <hr>
    <p>total cours</p>
    <p class="heures">28 heures</p>
  </div>
  <div id="item-5" class="item">&nbsp;
    <img src="images/cours.png" alt="">
    <h2>Déploiement de service</h2>
    <a href="#"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
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