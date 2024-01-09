<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Vérifiez si l'utilisateur est un professeur
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'prof') {
    header("Location: index.php"); // Redirige vers index.php si ce n'est pas un professeur
    exit();
}

try {
    include("connexion.php");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $profName = $_SESSION['nom'];

    // Vérifiez si les détails du message sont fournis dans l'URL
    if (isset($_GET['sender']) && isset($_GET['timestamp'])) {
        $sender = $_GET['sender'];
        $timestamp = $_GET['timestamp'];

        // Sélectionnez les détails du message en fonction de l'expéditeur et de l'horodatage
        $sql = "
            SELECT *
            FROM messages
            WHERE sender = :sender AND timestamp = :timestamp
        ";
        $result = $db->prepare($sql);
        $result->execute(['sender' => $sender, 'timestamp' => $timestamp]);

        $messageDetails = $result->fetch(PDO::FETCH_ASSOC);

        if (!$messageDetails) {
            echo "Message non trouvé.";
            exit();
        }
    } else {
        echo "Requête invalide.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du message du professeur</title>
    <link rel="stylesheet" href="msg_detail.css">
</head>

<body>
    <a href='index.php'>Accueil</a>
    <a href='logout.php'>Déconnexion</a>
    <a href='prof_msg_index.php'>Retour</a>


    <?php // Affichage des détails du message
    echo "<section class='message-details'>";
    echo "<p class='msg objet'>" . nl2br(htmlspecialchars($messageDetails['objet'])) . "</p>";

    if ($messageDetails['recipient_type'] === 'specific') {
        // Afficher tous les destinataires spécifiques du message
        $sqlRecipients = "
            SELECT recipient_name
            FROM messages
            WHERE sender = :sender AND timestamp = :timestamp AND recipient_type = 'specific'
        ";
        $resultRecipients = $db->prepare($sqlRecipients);
        $resultRecipients->execute(['sender' => $messageDetails['sender'], 'timestamp' => $messageDetails['timestamp']]);
        
        $recipients = $resultRecipients->fetchAll(PDO::FETCH_COLUMN);
        

        echo"
        <div class='header_message_detail'>

        <p> ".date('d/m/Y H:i', strtotime($messageDetails['timestamp']))."</p> ";

        if (!empty($recipients)) {
            echo "<p>à : " . implode(', ', $recipients) . "</p>";
        } else {
            echo "<p>Destinataire : Aucun destinataire spécifique trouvé.</p>
            
            ";
        }
    }

    echo"</div>";

 
    
    
    echo "<p class='msg'> " . nl2br(htmlspecialchars($messageDetails['message'])) . "</p>";

    if (!empty($messageDetails['attachment_path'])) {
        $attachmentFileName = basename($messageDetails['attachment_path']);
        echo "<p class='msg attachment_path'>Pièce jointe : <a href='{$messageDetails['attachment_path']}'  target='_blank'>$attachmentFileName</a></p>";
    }
    echo "</section>";

    
    



    // message précedent et suivant
    // Sélectionnez le message précédent
    $sqlPreviousMessage = "
        SELECT sender, timestamp
        FROM messages
        WHERE sender = :sender AND timestamp < :currentTimestamp
        ORDER BY timestamp DESC
        LIMIT 1
    ";
    $resultPreviousMessage = $db->prepare($sqlPreviousMessage);
    $resultPreviousMessage->execute(['sender' => $messageDetails['sender'], 'currentTimestamp' => $messageDetails['timestamp']]);
    $previousMessage = $resultPreviousMessage->fetch(PDO::FETCH_ASSOC);

    echo"<section class='before_after'> ";
    // Affichez le lien vers le message précédent s'il existe
    if ($previousMessage) {
        echo "<p  class='before'><a href='prof_msg_detail.php?sender={$previousMessage['sender']}&timestamp={$previousMessage['timestamp']}'>Message Précédent</a></p>";
    }

    // Sélectionnez le message suivant
    $sqlNextMessage = "
        SELECT sender, timestamp
        FROM messages
        WHERE sender = :sender AND timestamp > :currentTimestamp
        ORDER BY timestamp ASC
        LIMIT 1
    ";
    $resultNextMessage = $db->prepare($sqlNextMessage);
    $resultNextMessage->execute(['sender' => $messageDetails['sender'], 'currentTimestamp' => $messageDetails['timestamp']]);
    $nextMessage = $resultNextMessage->fetch(PDO::FETCH_ASSOC);

    // Affichez le lien vers le message suivant s'il existe
    if ($nextMessage) {
        echo "<p class='after'><a href='prof_msg_detail.php?sender={$nextMessage['sender']}&timestamp={$nextMessage['timestamp']}'>Message Suivant</a></p>";
    }
    echo"</section>";

    ?>
</body>

</html>
