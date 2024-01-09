<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messagerie eleve</title>
</head>
<body>
    
    
<a href='index.php'>acceuil</a>




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
    $sql = "SELECT DISTINCT message, sender, objet, timestamp, subject FROM messages WHERE recipient_type = 'all' OR (recipient_type = 'specific' AND (recipient_name = :studentName OR recipient_name IS NULL))ORDER BY timestamp DESC";
    
    $result = $db->prepare($sql);
    $result->bindParam(':studentName', $_SESSION['nom']);
    $result->execute();

 
    // Display messages
    echo "<h2>Your Messages</h2>";

    if ($result->rowCount() > 0) {
        echo "<ul>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<li> Objet: {$row['objet']}  Subject: {$row['subject']}  {$row['sender']} sent: {$row['message']} ({$row['timestamp']})</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No messages found.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

</body>
</html>
