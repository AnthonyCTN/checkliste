<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']);

    // Suppression de la tâche
    $sql = "DELETE FROM Items WHERE id = ? AND checklist_id IN (SELECT id FROM Checklists WHERE user_id = ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $item_id, $_SESSION['user_id']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php");  // Rediriger vers la page principale
            exit;
        } else {
            echo "Erreur lors de la suppression de la tâche.";
        }

        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "ID de la tâche non spécifié.";
}

$conn->close();
?>