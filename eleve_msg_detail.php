<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Detail</title>
    <link rel="stylesheet" href="msg_detail.css">
</head>

<body>

<?php
session_start();

// Vérifiez si l'utilisateur est un étudiant
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'eleve') {
    header("Location: index.php"); // Redirige vers index.php si ce n'est pas un étudiant
    exit();
}
echo "<a href='eleve_msg_index.php'>retour</a>";

// Récupérez l'ID du message à partir des paramètres GET
$messageId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$messageId) {
    echo "<p>Invalid message ID.</p>";
    exit();
}

try {
    include("connexion.php");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Sélectionnez le message actuel
$sqlCurrentMessage = "SELECT m.*, u.photo_profil
FROM messages m
LEFT JOIN user u ON m.sender = u.nom
WHERE m.message_id = :messageId";
$resultCurrentMessage = $db->prepare($sqlCurrentMessage);
$resultCurrentMessage->bindParam(':messageId', $messageId);
$resultCurrentMessage->execute();


    // Affichez le contenu complet du message
    if ($row = $resultCurrentMessage->fetch(PDO::FETCH_ASSOC)) {
        $formattedDate = date("d/m/Y ", strtotime($row['timestamp']));

        echo "
        <p class='msg objet'>" . nl2br(htmlspecialchars($row['objet'])) . "</p>
        <section class='message-details'>
          <div class='header_message_detail'>
          <img src='{$row['photo_profil']}' alt=''>
          <div>
          <p>de : {$row['sender']}, {$formattedDate}</p>
          <p>à : " . ($row['recipient_name'] ? $row['recipient_name'] : ($row['recipient_type'] === 'all' ? 'tous' : $row['recipient_type'])) . "</p>

          </div>
          </section>
    
        
       
          <p class='msg'>" . nl2br(htmlspecialchars($row['message'])) . "</p>
      
            ";

   // Display attachment if available
if (!empty($row['attachment_path'])) {
    $attachmentFileName = basename($row['attachment_path']); // Obtenir le nom du fichier à partir de l'URL
    echo "<p  class='msg attachment_path'>pièce jointe: <a href='{$row['attachment_path']}' target='_blank'>$attachmentFileName</a></p>";
}


        echo "</div>";

        $sqlPreviousMessage = "
        SELECT message_id, sender, objet, timestamp, attachment_path
        FROM messages
        WHERE
            timestamp < :currentTimestamp
            AND (
                recipient_type = 'all'
                OR (recipient_type = 'specific' AND recipient_name = :currentUser)
                OR sender = :currentUser
            )
        ORDER BY timestamp DESC
        LIMIT 1
    ";
    
    $resultPreviousMessage = $db->prepare($sqlPreviousMessage);
    $resultPreviousMessage->bindParam(':currentTimestamp', $row['timestamp']);
    $resultPreviousMessage->bindParam(':currentUser', $_SESSION['nom']);
    $resultPreviousMessage->execute();
    $previousMessage = $resultPreviousMessage->fetch(PDO::FETCH_ASSOC);

        echo"<section class='before_after'> ";
        // Affichez le lien vers le message précédent s'il existe
        if ($previousMessage) {
            echo "<p class='before'><a href='eleve_msg_detail.php?id={$previousMessage['message_id']}'>Message Précédent</a></p>";
        }

       // Sélectionnez le message suivant
$sqlNextMessage = "
SELECT message_id, sender, objet, timestamp, attachment_path
FROM messages
WHERE
    timestamp > :currentTimestamp
    AND (
        recipient_type = 'all'
        OR (recipient_type = 'specific' AND recipient_name = :currentUser)
        OR sender = :currentUser
    )
ORDER BY timestamp ASC
LIMIT 1
";

$resultNextMessage = $db->prepare($sqlNextMessage);
$resultNextMessage->bindParam(':currentTimestamp', $row['timestamp']);
$resultNextMessage->bindParam(':currentUser', $_SESSION['nom']);
$resultNextMessage->execute();
$nextMessage = $resultNextMessage->fetch(PDO::FETCH_ASSOC);

        // Affichez le lien vers le message suivant s'il existe
        if ($nextMessage) {
            echo "<p class='after'><a href='eleve_msg_detail.php?id={$nextMessage['message_id']}'>Message Suivant</a></p>";
        }
    } else {
        echo "<p>Message not found.</p>";
    }
    echo"</section>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

</body>

</html>
