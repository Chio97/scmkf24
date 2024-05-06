<?php
session_start();

// DATABASE CONNECTION
$conn = new mysqli("localhost", "root", "", "nutzer_db");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Überprüfen, ob das Formular gesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüfen, ob alle benötigten Felder gesetzt sind
    if (isset($_POST['benutzername'], $_POST['email'], $_POST['betreff'], $_POST['nachricht'])) {
        // Eingabedaten aus dem Formular holen
        $benutzername = $_POST['benutzername'];
        $email = $_POST['email'];
        $betreff = $_POST['betreff'];
        $nachricht = $_POST['nachricht'];

        // Überprüfen, ob alle Felder ausgefüllt sind
        if (!empty($benutzername) && !empty($email) && !empty($betreff) && !empty($nachricht)) {
            // SQL-Anweisung zum Einfügen der Daten
            $sql = "INSERT INTO kontaktformular (benutzername, email, betreff, nachricht)
                    VALUES (?, ?, ?, ?)";

            // Vorbereiten des SQL-Statements zur sicheren Eingabe
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $benutzername, $email, $betreff, $nachricht);

            // SQL-Anweisung ausführen
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Ihre Nachricht wurde erfolgreich versendet. Sie bekommen innerhalb von 24 Stunden eine Rückmeldung.";
            } else {
                $_SESSION['error_message'] = "Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.";
            }

            // Verbindung schließen
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Bitte füllen Sie alle erforderlichen Felder aus.";
        }
    } else {
        $_SESSION['error_message'] = "Bitte füllen Sie alle erforderlichen Felder aus.";
    }
}

// Verbindung schließen, wenn das Skript beendet ist
$conn->close();

// Weiterleitung zurück zur Kontaktseite
header("Location: kontakt.php");
exit();
?>
