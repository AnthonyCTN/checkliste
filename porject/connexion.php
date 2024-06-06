<?php
include 'db.php';  // Inclure le script de connexion à la base de données

session_start();  // Démarrer une nouvelle session ou reprendre une session existante

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $mot_de_passe = $conn->real_escape_string($_POST['mot_de_passe']);
    
    // Préparation de la requête SQL pour vérifier l'utilisateur
    $sql = "SELECT id, nom, mot_de_passe FROM Utilisateurs WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Vérification du mot de passe
            if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                // Mise en place des variables de session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_nom'] = $row['nom'];

                // Redirection vers la page d'ajout de checklist
                header("Location: ajouter_checklist.html");
                exit;
            } else {
                $error_message = "Mot de passe incorrect.";
            }
        } else {
            $error_message = "Aucun utilisateur trouvé avec cet email.";
        }
        
        $stmt->close();
    } else {
        $error_message = "Erreur: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Connexion</h2>
        <form id="login-form" action="connexion.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>
            <button type="submit">Se connecter</button>
            <a href="inscription.html" class="button-link">S'inscrire</a>
        </form>
        <?php if ($error_message): ?>
            <div id="error-message"><?= $error_message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
