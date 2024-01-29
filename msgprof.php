<?php
session_start();

// Check if the user is a professor
if (!isset($_SESSION['nom']) || $_SESSION['type'] !== 'prof') {
    header("Location: index.php"); // Redirect to index.php if not a professor
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $message = $_POST['message'];
    $recipientTypes = isset($_POST['recipient_type']) ? $_POST['recipient_type'] : [];

    $objet = $_POST['objet'];

    try {
        include("connexion.php");

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sender = $_SESSION['nom'];

        // Check if a file is uploaded
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';  // Répertoire de téléchargement
            $uploadFile = $uploadDir . basename($_FILES['attachment']['name']);

            // Déplacez le fichier téléchargé vers le répertoire de téléchargement
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                // Le fichier a été téléchargé avec succès, vous pouvez enregistrer le chemin dans la base de données si nécessaire
                $attachmentPath = $uploadFile;
            } else {
                // Il y a eu une erreur lors du téléchargement du fichier
                echo "Error uploading file.";
                exit();
            }
        } else {
            // Aucun fichier n'a été téléchargé
            $attachmentPath = null;
        }

        foreach ($recipientTypes as $recipientType) {
            if ($recipientType === 'all') {
                // inérer le msg pour tous les élèves
                $sql = "INSERT INTO messages (sender, message, objet, recipient_type, recipient_name, attachment_path) 
                        VALUES (:sender, :message, :objet, 'all', NULL, :attachmentPath)";
                $result = $db->prepare($sql);
                $result->execute([
                    'sender' => $sender,
                    'message' => $message,
                    'objet' => $objet,
                    'attachmentPath' => $attachmentPath
                ]);
            } elseif (strpos($recipientType, 'specific_') === 0) {
                // Extraire le nom des élèves quand le recipient est spécifié
                $recipientName = substr($recipientType, strlen('specific_'));

                // insérer le msg spécifique dans la bdd
                $sql = "INSERT INTO messages (sender, message, objet, recipient_type, recipient_name, attachment_path) 
                        VALUES (:sender, :message, :objet, 'specific', :recipientName, :attachmentPath)";
                $result = $db->prepare($sql);
                $result->execute([
                    'sender' => $sender,
                    'message' => $message,
                    'objet' => $objet,
                    'recipientName' => $recipientName,
                    'attachmentPath' => $attachmentPath
                ]);
            }
        }

    
        header("Location: prof_msg_index.php?message=sent");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getAllStudentNames()
{
    $db = new PDO('mysql:host=localhost;dbname=ent_test;port=3306;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT nom FROM user WHERE type = 'eleve'";
    $result = $db->query($sql);
    return $result->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Professor</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="msgprof.css">

    <style>
        .selected {
            color: red;
        }
    </style>

    <script>
        $(document).ready(function () {
            // Initialisez Select2
            $('.js-example-basic-multiple').select2();

            // Ajoutez un gestionnaire d'événements pour le changement de sélection
            $('#recipient_select').on('select2:select select2:unselect', function (e) {
                handleRecipientSelectionChange();
            });
        });

        // Fonction pour filtrer les destinataires en fonction de la recherche
        function filterRecipients() {
            var searchInput = document.getElementById("recipient_search");
            var options = document.querySelectorAll("#recipient_select option");
            var searchTerm = searchInput.value.toLowerCase();

            options.forEach(function (option) {
                var labelValue = option.text.toLowerCase();

                if (labelValue.startsWith(searchTerm)) {
                    // Appliquer la mise en forme en gras et vert
                    var startIndex = labelValue.indexOf(searchTerm);
                    var endIndex = startIndex + searchTerm.length;
                    option.innerHTML = labelValue.substring(0, startIndex) +
                        "<strong style='color: green;'>" + labelValue.substring(startIndex, endIndex) + "</strong>" +
                        labelValue.substring(endIndex);
                } else {
                    // Réinitialiser le style d'origine s'il n'y a pas de correspondance
                    option.innerHTML = labelValue;
                }
            });
        }

        // Fonction pour gérer les changements dans la sélection des destinataires
        function handleRecipientSelectionChange() {
            var selectedValues = $('#recipient_select').val();

            // Si "All Students" est sélectionné et d'autres options sont également sélectionnées
            if (selectedValues && selectedValues.includes('all') && selectedValues.length > 1) {
                // Désélectionnez "All Students"
                var index = selectedValues.indexOf('all');
                selectedValues.splice(index, 1);
            }

            // Mettez à jour la sélection
            $('#recipient_select').val(selectedValues).trigger('change');
        }
    </script>
</head>

<body>

    <a href="prof_msg_index.php">retour</a>
    <form method="POST" action="msgprof.php" enctype="multipart/form-data">
    <h2>nouveau message</h2>

    <label for="recipient_type">à:</label>
        <select name="recipient_type[]" id="recipient_select" class="js-example-basic-multiple" multiple required >
            <option value="all">Tous les élèves</option>
            <?php $studentNames = getAllStudentNames(); ?>
            <?php foreach ($studentNames as $studentName) : ?>
                <option value="specific_<?php echo $studentName; ?>"><?php echo $studentName; ?></option>
            <?php endforeach; ?>
        </select>

    <label for="objet">Objet:</label>
<textarea name="objet" required ><?php echo isset($objet) ? htmlspecialchars($objet) : ''; ?></textarea>

<label for="message" id="messages">Message:</label>
<textarea name="message" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>


        <label for="attachment">Pièce jointe:</label>
        <input type="file" name="attachment" accept="image/*,audio/*,video/*,application/*">

      

        <button type="submit" name="submit" id="submit">Envoyer un message</button>

    </form>







</body>

</html>
