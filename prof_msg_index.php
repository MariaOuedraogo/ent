<?php
session_start();

//check is user is a prof
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'prof') {
    header("Location: index.php"); // si non redirect to index page
    exit();
}

try {
    include("connexion.php");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $profName = $_SESSION['nom'];

    $sql = "
    SELECT DISTINCT m.sender, m.objet, m.timestamp, u.photo_profil
    FROM messages m
    LEFT JOIN user u ON m.sender = u.nom
    WHERE m.sender = :profName
    ORDER BY m.timestamp DESC
";
$result = $db->prepare($sql);
$result->execute(['profName' => $profName]);

$messages = $result->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
    <title>messagerie professeur</title>
    <link rel="stylesheet" href="msg_index.css">
</head>

<body>
    <div class="ariane">
    <a href='index.php' >accueil&nbsp;/ </a> <a href='#' class="active">&nbsp; messagerie</a>
    </div>
 

   <div class="create_msg">
   <a href="msgprof.php">créer un message</a>
   </div>

    <?php // Affichage des messages récupérés
    echo "<h1>Vos messages</h1>";

    if (!empty($messages)) {
        echo "<div class='mails'>";
        foreach ($messages as $message) {
            echo "
            <a href='prof_msg_detail.php?sender={$message['sender']}&timestamp={$message['timestamp']}' class='mail'>
            
                <div class='image_mail'>
                    <img src='{$message['photo_profil']}' alt=''>
                </div>
                <div class='texte_mail'>
                    <h2>{$message['sender']} (moi)</h2>
                    <p> {$message['objet']}</p>
                </div>
                <div class='date'>
                    <p> ".date('d/m/Y H:i', strtotime($message['timestamp']))."</p>

                </div>
            </a>
            ";
        }
        echo "</div>";
    } else {
        echo "<p>Aucun message trouvé.</p>";
    }
    ?>
</body>

</html>
