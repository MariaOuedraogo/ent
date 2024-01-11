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
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="outil.css">
    <script src="script.js" defer></script>
</head>
<body>
    


<div class="ariane">
<a href='index.php' >accueil&nbsp;/ </a> <a href='#' class="active">&nbsp; Ressources pédagogiques </a>
</div>

<h1> voici les outils dont <br>tu as accès cette année</h1>

<nav>
    <a href="cours.php" class='active2'>ressources pédagogiques↘︎</a>
    <a href="outil.php">mes outils ↘ </a>
</nav>



<div class="angry-grid">
  <div id="item-0" class="item">&nbsp;
    <h2>Powerpoint</h2>
    <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>collaborer avec docs en créant en ligne des documents </p> 
  </div>
  <div id="item-1" class="item">&nbsp;
  <h2>Word</h2>
    <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>collaborer avec docs en créant en ligne des documents </p>
  </div>
  <div id="item-2" class="item">&nbsp;
  <h2>Excel</h2>
    <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>collaborer avec docs en créant en ligne des documents </p>
  </div>
  <div id="item-3" class="item">&nbsp;
  <h2>Suite Adobe</h2>
    <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>collaborer avec docs en créant en ligne des documents </p>
  </div>
  <div id="item-4" class="item">&nbsp;
  <h2>Canvas</h2>
    <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>collaborer avec docs en créant en ligne des documents </p>
  </div>
  <div id="item-5" class="item">&nbsp;
  <h2>Zoom</h2>
    <a href="cours_detail.php"><iconify-icon icon="ph:arrow-right" class="icon-arrow"></iconify-icon></a>
    <p>collaborer avec docs en créant en ligne des documents </p>
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