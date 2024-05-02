<?php
session_start();
include 'db.php';

if (isset($_POST['benutzername'], $_POST['termin'])) {
    $benutzername = $_POST['benutzername'];
    $termin = $_POST['termin'];

    $sql = "DELETE FROM reservierung WHERE benutzername = ? AND termin = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $benutzername, $termin);
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
