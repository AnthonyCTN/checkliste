<?php
// functions.php

function getChecklists() {
    global $conn;
    $sql = "SELECT id as checklist_id, titre as checklist_name FROM Checklists";
    $result = $conn->query($sql);
    $checklists = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $checklists[] = $row;
        }
    }

    return $checklists;
}
?>
