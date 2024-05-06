<?php
session_start();
include 'db.php'; // Stelle sicher, dass die Datenbankverbindung hergestellt wird

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['benutzername'], $_POST['email'], $_POST['sicherheitsfrage'], $_POST['sicherheitsantwort'], $_POST['passwort'], $_POST['passwort-confirm'])) {
    // Variablen aus dem Formular extrahieren
    $benutzername = $_POST['benutzername'];
    $email = $_POST['email'];
    $sicherheitsfrage = $_POST['sicherheitsfrage'];
    $sicherheitsantwort = $_POST['sicherheitsantwort'];
    $neues_passwort = $_POST['passwort'];
    $neues_passwort_confirm = $_POST['passwort-confirm'];

    // Überprüfen, ob die Passwörter übereinstimmen
    if ($neues_passwort !== $neues_passwort_confirm) {
        $message = "Die eingegebenen Passwörter stimmen nicht überein.";
    } else {
        // Sicherheitsfrage und Antwort aus der Datenbank überprüfen
        $stmt = $conn->prepare("SELECT * FROM nutzerdaten WHERE benutzername = ? AND email = ? AND sicherheitsfrage = ? AND sicherheitsantwort = ?");
        $stmt->bind_param("ssss", $benutzername, $email, $sicherheitsfrage, $sicherheitsantwort);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Sicherheitsfrage und Antwort sind korrekt, Passwort aktualisieren
            $passwort_hash = password_hash($neues_passwort, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE nutzerdaten SET passwort = ? WHERE benutzername = ?");
            $update_stmt->bind_param("ss", $passwort_hash, $benutzername);

            // Nach dem erfolglosen Zurücksetzen des Passworts
            if ($update_stmt->execute()) {
                $_SESSION['success_message'] = "Das Passwort wurde erfolgreich zurückgesetzt.";
            } else {
                $_SESSION['error_message'] = "Passwort konnte nicht zurückgesetzt werden.";
                // Debugging-Anweisung: Ausgabe der Fehlermeldung
                var_dump($_SESSION['error_message']);
            }

            $update_stmt->close();
        } else {
            // Sicherheitsfrage und Antwort sind nicht korrekt
            $message = "Die eingegebenen Informationen sind nicht korrekt. Das Passwort konnte nicht zurückgesetzt werden.";
        }
    }
}

// Redirect auf passwort_zurueck.php
header("Location: passwort_zurueck.php");
exit();
?>
