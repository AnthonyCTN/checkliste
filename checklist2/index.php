<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Checklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function confirmDeletion(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette checklist ?")) {
                window.location.href = 'supprimer_checklist.php?id=' + id;
            }
        }

        function confirmItemDeletion(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette tâche ?")) {
                window.location.href = 'supprimer_item.php?id=' + id;
            }
        }
    </script>
</head>
<body>
<nav>
    <div class="container">
        <h1>Ma Checklist</h1>
        <div>
            <a href="ajouter_checklist.html">Ajouter une Checklist</a> | 
            <a href="ajouter_categorie.html">Ajouter une Catégorie</a> | 
            <a href="logout.php">Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container checklists">
    <?php
    $sql = "SELECT Checklists.*, Categories.nom AS categorie_nom 
            FROM Checklists 
            LEFT JOIN Checklist_Categories ON Checklists.id = Checklist_Categories.checklist_id
            LEFT JOIN Categories ON Checklist_Categories.categorie_id = Categories.id
            WHERE Checklists.user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($checklist = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h2>" . htmlspecialchars($checklist['titre']) . "</h2>";
            echo "<p>" . htmlspecialchars($checklist['description']) . "</p>";
            echo "<p><strong>Catégorie:</strong> " . htmlspecialchars($checklist['categorie_nom']) . "</p>";

            $sql_items = "SELECT * FROM Items WHERE checklist_id = ?";
            if ($stmt_items = $conn->prepare($sql_items)) {
                $stmt_items->bind_param("i", $checklist['id']);
                $stmt_items->execute();
                $result_items = $stmt_items->get_result();

                echo "<ul>";
                while ($item = $result_items->fetch_assoc()) {
                    $etat_classe = $item['etat'] ? 'fait' : 'a-faire';
                    echo "<li class='$etat_classe'>";
                    echo "<form action='modifier_item.php' method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='id' value='" . $item['id'] . "'>";
                    echo "<input type='text' name='texte' value='" . htmlspecialchars($item['texte']) . "'>";
                    echo "<button type='submit'><i class='fas fa-save'></i></button>";
                    echo "</form>";
                    echo " <a href='changer_etat_item.php?id=" . $item['id'] . "&etat=" . !$item['etat'] . "'><button><i class='fas " . ($item['etat'] ? 'fa-times' : 'fa-check') . "'></i></button></a>";
                    echo " <button onclick='confirmItemDeletion(" . $item['id'] . ")'><i class='fas fa-trash'></i></button>";
                    echo "</li>";
                }
                echo "</ul>";
                $stmt_items->close();
            }

            echo "<a href='ajouter_item.html?checklist_id=" . $checklist['id'] . "'>Ajouter une Tâche </a>";
            echo " <button onclick='confirmDeletion(" . $checklist['id'] . ")'>Supprimer</button>";
            echo "</div>";
        }
        $stmt->close();
    }
    ?>
</div>
</body>
</html>
