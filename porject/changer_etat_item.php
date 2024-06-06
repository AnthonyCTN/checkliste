<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['etat'])) {
    $id = $_GET['id'];
    $etat = $_GET['etat'] ? 1 : 0;

    $sql = "UPDATE Items SET etat = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $etat, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php");  // Rediriger vers la page principale
        } else {
            echo "Aucune modification apportée ou erreur.";
        }

        $stmt->close();
    } else {
        echo "Erreur: " . $conn->error;
    }
}

$conn->close();
?>
