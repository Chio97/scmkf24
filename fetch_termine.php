<?php
include 'db.php'; // Datenbankverbindung

$sprache = $_GET['sprache'] ?? '';
$schulungsart = $_GET['schulungsart'] ?? '';
$modul = $_GET['modul'] ?? '';
$schwierigkeitsgrad = $_GET['schwierigkeitsgrad'] ?? '';

if (!$sprache || !$schulungsart || !$modul || !$schwierigkeitsgrad) {
    echo json_encode([]);
    exit;
}

$conn = new mysqli("Localhost", "root", "", "nutzer_db");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$query = "SELECT DISTINCT termin FROM schulungen WHERE modul = ? AND schwierigkeitsgrad = ? AND sprache = ? AND schulungsart = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $modul, $schwierigkeitsgrad, $sprache, $schulungsart);
$stmt->execute();
$result = $stmt->get_result();

$termine = [];
while ($row = $result->fetch_assoc()) {
    $termine[] = $row;
}

echo json_encode($termine);
?>
