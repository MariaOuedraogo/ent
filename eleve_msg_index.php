<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inbox</title>

    <link rel="stylesheet" href="msg_index.css">
</head>

<body>
<a href="index.php">accueil</a>
<h1>boîte de reception</h1>

<?php
session_start();

// Check if the user is a student
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'eleve') {
    header("Location: index.php"); // Redirect to index.php if not a student
    exit();
}

// Fetch and display distinct messages for the current student from the database
try {
    include("connexion.php");  

    // $db = new PDO('mysql:host=localhost;dbname=ent_test;port=3306;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Use a prepared statement to avoid SQL injection
    $sql = "SELECT DISTINCT m.message_id, m.sender, m.objet, m.message, m.timestamp, m.subject, u.photo_profil
    FROM messages m
    LEFT JOIN user u ON m.sender = u.nom
    WHERE m.recipient_type = 'all' OR (m.recipient_type = 'specific' AND (m.recipient_name = :studentName OR m.recipient_name IS NULL))
    ORDER BY m.timestamp DESC";

    // $sql = "SELECT DISTINCT message_id, sender, objet, timestamp, subject FROM messages WHERE recipient_type = 'specific' AND (recipient_name = :studentName OR recipient_name IS NULL) ORDER BY timestamp DESC";

    
    $result = $db->prepare($sql);
    $result->bindParam(':studentName', $_SESSION['nom']);
    $result->execute();

    // Display messages

    if ($result->rowCount() > 0) {
        echo "<div class='mails'>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "
            <a href='eleve_msg_detail.php?id={$row['message_id']}' class='mail'>
                <div class='image_mail'>
                    <img src='{$row['photo_profil']}' alt=''>
                </div>
                <div class='texte_mail'>
                    <h2>{$row['sender']} </h2>
                    <p> ({$row['objet']})</p>
                    <p class='msg detail_msg'> {$row['message']}</p>
                </div>
                <div class='date'>
                    <p> ".date('d/m/Y ', strtotime($row['timestamp']))."</p>

                </div>
            </a>";
        }
        echo "</div>";
    } else {
        echo "<p>aucun message</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
</body>

</html>