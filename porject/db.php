<?php
$host_name = 'db5015905768.hosting-data.io';
$database = 'dbs12963430';
$user_name = 'dbu328445';
$password = 'Checkliste123@';
$conn = new mysqli($host_name, $user_name, $password, $database);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}
?>
