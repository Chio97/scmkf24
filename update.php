<?php
session_start();
include 'db.php';  // Datenbankverbindung einbinden

if (!isset($_SESSION['benutzername'])) {
    die("Benutzername nicht gesetzt. Bitte stellen Sie sicher, dass Sie angemeldet sind.");
}

$benutzername = $_SESSION['benutzername'];

$conn = new mysqli("localhost", "root", "", "nutzer_db");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Sicherstellen, dass die Aktion gesetzt wurde
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save') {
        $stmt = $conn->prepare("UPDATE nutzerdaten SET vorname = ?, name = ?, email = ?, unternehmen = ?, beruf = ?, adresse = ?, plz = ?, stadt = ? WHERE benutzername = ?");
        $stmt->bind_param("sssssssss", $_POST['vorname'], $_POST['name'], $_POST['email'], $_POST['unternehmen'], $_POST['beruf'], $_POST['adresse'], $_POST['plz'], $_POST['stadt'], $benutzername);
        
        print_r($_POST); // Debugging der POST-Daten
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            $_SESSION['notification'] = "Daten erfolgreich geändert.";
        } else {
            $_SESSION['notification'] = "Keine Änderung vorgenommen. Fehler: " . $stmt->error;
        }
        $stmt->close();
        header("Location: profil.php");
        exit();
        
    } elseif ($_POST['action'] == 'delete') {
        $stmt = $conn->prepare("DELETE FROM nutzerdaten WHERE benutzername = ?");
        $stmt->bind_param("s", $benutzername);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['notification'] = "Profil erfolgreich gelöscht.";
            session_destroy();  // Session löschen, da der Benutzer gelöscht wurde
            header("Location: goodbye.php"); // Weiterleitung zur Abschiedsseite
            exit();
        } else {
            $_SESSION['notification'] = "Fehler beim Löschen des Profils.";
            header("Location: profil.php");
            exit();
        }
} else {
    // Falls kein 'action' Wert übermittelt wurde, zurück zur Profilseite
    header("Location: profil.php");
    exit();
}
}
$conn->close();
?>
