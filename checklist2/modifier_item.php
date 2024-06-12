<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $texte = $_POST['texte'];

    $sql = "UPDATE Items SET texte = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $texte, $id);
        if ($stmt->execute()) {
            header("Location: index.php");  // Rediriger vers la page principale
            exit;
        } else {
            echo "Erreur lors de la mise à jour de la tâche.";
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête.";
    }
}
?>