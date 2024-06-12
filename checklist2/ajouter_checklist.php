<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $conn->real_escape_string($_POST['titre']);
    $description = $conn->real_escape_string($_POST['description']);
    $categorie_id = intval($_POST['categorie_id']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO Checklists (titre, description, user_id) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $titre, $description, $user_id);
        if ($stmt->execute()) {
            $checklist_id = $stmt->insert_id;
            $sql_categorie = "INSERT INTO Checklist_Categories (checklist_id, categorie_id) VALUES (?, ?)";
            if ($stmt_categorie = $conn->prepare($sql_categorie)) {
                $stmt_categorie->bind_param("ii", $checklist_id, $categorie_id);
                $stmt_categorie->execute();
                $stmt_categorie->close();
            }
            echo "<script>
                    alert('Checklist créée avec succès!');
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 2000);
                  </script>";
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
