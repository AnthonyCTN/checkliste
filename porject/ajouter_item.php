<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $texte = $conn->real_escape_string($_POST['texte']);
    $nom_checklist = $conn->real_escape_string($_POST['nom_checklist']);

    // Recherche de l'ID de la checklist
    $sql = "SELECT id FROM Checklists WHERE titre = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nom_checklist);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $checklist_id = $row['id'];

            // Insertion de l'item
            $sql_insert = "INSERT INTO Items (texte, checklist_id) VALUES (?, ?)";
            if ($stmt_insert = $conn->prepare($sql_insert)) {
                $stmt_insert->bind_param("si", $texte, $checklist_id);
                $stmt_insert->execute();

                if ($stmt_insert->affected_rows > 0) {
                    echo "Tâche ajoutée avec succès!";
                } else {
                    echo "Erreur lors de l'ajout de l'item: " . $stmt_insert->error;
                }

                $stmt_insert->close();
            } else {
                echo "Erreur lors de la préparation de l'insertion: " . $conn->error;
            }
        } else {
            echo "Checklist non trouvée avec ce nom.";
        }
        $stmt->close();
    } else {
        echo "Erreur lors de la recherche de l'ID de la checklist: " . $conn->error;
    }
}

$conn->close();
?>
