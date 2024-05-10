<?php
session_start();

// DATABASE CONNECTION
$conn = new mysqli("Localhost", "root", "", "nutzer_db");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Eingabedaten aus dem Formular holen
$name = $_POST['name'];
$vorname = $_POST['vorname'];
$benutzername = $_POST['benutzername'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
$plz = $_POST['plz'];
$stadt = $_POST['stadt'];
$unternehmen = $_POST['unternehmen'];
$beruf = $_POST['beruf'];
$passwort = $_POST['passwort'];
$passwort_confirm = $_POST['passwort-confirm'];
$sicherheitsfrage = $_POST['sicherheitsfrage'];
$sicherheitsantwort = $_POST['sicherheitsantwort'];

// Überprüfen, ob die Passwörter übereinstimmen
if ($passwort !== $passwort_confirm) {
    $_SESSION['error'] = "Die eingegebenen Passwörter stimmen nicht überein.";
    header("Location: registration.php"); // Weiterleitung zur Registrierungsseite
    exit();
}

// Passwort hashen
$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

// Generiere einen eindeutigen Token für die E-Mail-Verifizierung
$verification_token = bin2hex(random_bytes(16)); // 16 Bytes = 32 Zeichen

// SQL-Anweisung zum Einfügen der Daten
$sql = "INSERT INTO nutzerdaten (name, vorname, benutzername, email, adresse, plz, stadt, unternehmen, beruf, passwort, sicherheitsfrage, sicherheitsantwort, verification_token)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Vorbereiten des SQL-Statements zur sicheren Eingabe
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssss", $name, $vorname, $benutzername, $email, $adresse, $plz, $stadt, $unternehmen, $beruf, $passwort_hash, $sicherheitsfrage, $sicherheitsantwort, $verification_token);

// SQL-Anweisung ausführen
if ($stmt->execute()) {
    // Senden einer E-Mail mit dem Verifizierungslink
    $verification_link = "http://example.com/verify_email.php?token=" . $verification_token; // Anpassen der URL entsprechend deiner Webseite
    $subject = "Bitte bestätigen Sie Ihre E-Mail-Adresse";
    $message = "Hallo $vorname,\n\nBitte klicken Sie auf den folgenden Link, um Ihre E-Mail-Adresse zu bestätigen:\n$verification_link";
    $headers = "From: your@example.com"; // Anpassen der Absender-E-Mail-Adresse
    mail($email, $subject, $message, $headers);

    $_SESSION['notification'] = "Neues Profil wurde erstellt, Bitte bestätigen Sie Ihre E-Mail-Adresse.";
    header("Location: registration_success.php"); // Weiterleitung zur Erfolgsseite
    exit();
} else {
    echo "Fehler: " . $stmt->error;
}

// Verbindung schließen
$stmt->close();
$conn->close();
?>
