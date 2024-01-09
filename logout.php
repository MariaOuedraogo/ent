<?php
session_start();

// Détruire toutes les données de session
session_destroy();

// Rediriger vers la page d'accueil ou une autre page après la déconnexion
header('Location: index.php');
exit();
?>
