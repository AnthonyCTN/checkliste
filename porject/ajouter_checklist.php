<?php
session_start();
include 'db.php';  // Assurez-vous que ce fichier contient les informations de connexion correctes

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $titre = $conn->real_escape_string($_POST['titre']);
    $description = $conn->real_escape_string($_POST['description']);
    $user_id = $_SESSION['user_id'];  // Utilisateur actuellement connecté

    $sql = "INSERT INTO Checklists (titre, description, user_id) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $titre, $description, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Checklist ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur: " . $conn->error;
    }
} else {
    echo "Veuillez vous connecter pour ajouter une checklist.";
}

$conn->close();
?>
