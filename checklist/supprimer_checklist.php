<?php
include 'db.php';

if (isset($_GET['id'])) {
    $checklist_id = intval($_GET['id']);

    // Supprimer les items associés
    $sql_items = "DELETE FROM Items WHERE checklist_id = ?";
    if ($stmt_items = $conn->prepare($sql_items)) {
        $stmt_items->bind_param("i", $checklist_id);
        $stmt_items->execute();
        $stmt_items->close();
    }

    // Supprimer la checklist
    $sql_checklist = "DELETE FROM Checklists WHERE id = ?";
    if ($stmt = $conn->prepare($sql_checklist)) {
        $stmt->bind_param("i", $checklist_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit;
}

$conn->close();
?>
