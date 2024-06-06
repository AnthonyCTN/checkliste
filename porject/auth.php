<?php
include 'db.php';  // Assurez-vous que ce script gère la connexion à votre base de données

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom'])) {
        // Traitement de l'inscription
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO Utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $nom, $email, $mot_de_passe);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Inscription réussie! Vous pouvez maintenant vous connecter.'); window.location.href='login.html';</script>";
                exit;
            } else {
                echo "<script>alert('Erreur lors de l'inscription: " . $stmt->error . "');</script>";
            }
            
            $stmt->close();
        } else {
            echo "<script>alert('Erreur de préparation: " . $conn->error . "');</script>";
        }
    } elseif (isset($_POST['email']) && isset($_POST['mot_de_passe']) && !isset($_POST['nom'])) {
        // Traitement de la connexion
        $email = $conn->real_escape_string($_POST['email']);
        $mot_de_passe = $conn->real_escape_string($_POST['mot_de_passe']);
        
        $sql = "SELECT id, nom, mot_de_passe FROM Utilisateurs WHERE email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_nom'] = $row['nom'];
                    
                    echo "<script>alert('Connexion réussie! Bienvenue " . $row['nom'] . "'); window.location.href='accueil.html';</script>";
                    exit;
                } else {
                    echo "<script>alert('Mot de passe incorrect.');</script>";
                }
            } else {
                echo "<script>alert('Aucun utilisateur trouvé avec cet email.');</script>";
            }
            
            $stmt->close();
        } else {
            echo "Erreur: " . $conn->error;
        }
    }
}

$conn->close();
?>
