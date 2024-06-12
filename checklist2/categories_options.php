<?php
include 'db.php';

$sql = "SELECT id, nom FROM Categories";
$result = $conn->query($sql);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
}

$conn->close();
echo $options;
?>
