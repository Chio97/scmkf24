<?php
// Datenbank-Konfigurationsparameter
$servername = "localhost"; // Der Hostname der Datenbank
$username = "root";        // Der Benutzername für die Datenbank
$password = "";            // Das Passwort für den Datenbankbenutzer
$dbname = "nutzer_db";     // Der Name der Datenbank

// Erstellen der Verbindung
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Diese Zeile ist optional, sie setzt das Zeichensatzformat auf utf8, um Zeichensatzprobleme zu vermeiden
$conn->set_charset("utf8");

?>
