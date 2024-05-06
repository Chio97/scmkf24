<?php
session_start();
include 'db.php';

if (isset($_POST['reservierungsid'])) {
    $reservierungsid = $_POST['reservierungsid'];

    $sql = "DELETE FROM reservierung WHERE reservierungsid = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $reservierungsid); // Hier gehe ich davon aus, dass die Reservierungs-ID eine Ganzzahl ist (integer).
        if ($stmt->execute()) {
            $_SESSION['notification'] = "Reservierung erfolgreich storniert.";
        } else {
            $_SESSION['notification'] = "Fehler beim Stornieren der Reservierung.";
        }
        $stmt->close();
    } else {
        $_SESSION['notification'] = "Datenbankfehler: " . $conn->error;
    }
    $conn->close();
    header("Location: reservierungen.php");
    exit;
}

?>
