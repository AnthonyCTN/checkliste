<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $conn->real_escape_string($_POST['nom']);

    $sql = "INSERT INTO Categories (nom) VALUES (?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nom);
        if ($stmt->execute()) {
            header("Location:index.php"); // Rediriger vers le formulaire d'ajout de checklist
            exit;
        } else {
            echo "Erreur: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête: " . $conn->error;
    }
}

$conn->close();
?>
