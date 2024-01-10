<?php
$host = 'localhost';
$dbname = 'ent_test';
$port = '3306';
$charset = 'utf8mb4';
$username = 'root';
$password = '';

if (!empty($password)) {
    $db = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=$charset", $username, $password);
    // Reste du code pour traiter la connexion à la base de données avec le mot de passe non vide
} else {
    $db = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=$charset", $username, '');
    // Reste du code pour traiter la connexion à la base de données avec le mot de passe vide (essaie avec 'root')
}
?>


<?php
// $db = new PDO('mysql:host=localhost;dbname=ent_test;port=3306;charset=utf8mb4', 'root', '');
?>