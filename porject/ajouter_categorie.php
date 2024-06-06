<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $conn->real_escape_string($_POST['titre']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO Checklists (titre, description) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $titre, $description);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Checklist ajoutée avec succès!";
        } else {
            echo "Erreur lors de l'ajout: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur: " . $conn->error;
    }
}

$conn->close();
?>
