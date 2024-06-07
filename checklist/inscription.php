<?php
include 'db.php'; 

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom'], $_POST['email'], $_POST['mot_de_passe'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);  // Hashage du mot de passe

    $sql = "INSERT INTO Utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $nom, $email, $mot_de_passe);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            header("Location: connexion.html");
            exit;
        } else {
            echo "Erreur: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Erreur de préparation: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Tous les champs doivent être remplis.";
}
?>
