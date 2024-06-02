<?php
session_start();
include 'db.php'; // Datenbankverbindung
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de';
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = require 'languages/' . $_SESSION['lang'] . '.php';

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
                $_SESSION['success_message'] = $lang['passwort_zurueckgesetzt'];
                // Weiterleitung bei Erfolg
                header("Location: passwort_zurueck.php");
                exit();
            } else {
                $_SESSION['error_message'] = $lang['passwort_nicht_zurueckgesetzt'];

            }

            $update_stmt->close();
        } else {
            // Sicherheitsfrage und Antwort sind nicht korrekt
            $message = "Die eingegebenen Informationen sind nicht korrekt. Das Passwort konnte nicht zurückgesetzt werden.";
        }
    }
}
header("Location: passwort_zurueck.php");
$_SESSION['error_message'] = $lang['passwort_nicht_zurueckgesetzt'];
exit;
?>
