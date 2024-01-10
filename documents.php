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

    <link rel="stylesheet" href="documents.css">
    <script src="script.js" defer></script>
</head>
<body>
    

<a href="index.php">accueil</a>
<p>accueil/ Mes documents</p>

<h1>voici tes documents <br> indispensable pour l'année</h1>

<hr>

<div class="container">
<section>
<p class="in">2022/2023</p>
  <p class="will">2023/2024</p>
</section>

<div class="angry-grid">
  <div id="item-0" class="item">&nbsp;</div>
  <div id="item-1" class="item">&nbsp;</div>
  <div id="item-2" class="item">&nbsp;</div>
  <div id="item-3" class="item">&nbsp;</div>
  <div id="item-4" class="item">&nbsp;</div>
  <div id="item-5" class="item">&nbsp;</div>
</div>
</div>

<div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <p>tu n'as pas encore accès à cette section</p>
        </div>
    </div>



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