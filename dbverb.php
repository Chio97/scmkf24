<?php
session_start();
include 'db.php'; // Datenbankverbindung
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Deutsch als Standard sprache
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
}

// Sprachdateien laden
$lang = require 'languages/' . $_SESSION['lang'] . '.php';

// Überprüfung, ob der Benutzername gesetzt ist
if (isset($_POST['benutzername'])) {
    $benutzername = $_POST['benutzername'];
    $_SESSION['benutzername'] = $benutzername;
} elseif (isset($_SESSION['benutzername'])) {
    $benutzername = $_SESSION['benutzername'];
} else {
    die("Benutzername nicht gesetzt. Bitte stellen Sie sicher, dass Sie angemeldet sind.");
}


// Daten abrufen
$stmt = $conn->prepare("SELECT vorname, name, benutzername, email, unternehmen, beruf, adresse, plz, stadt FROM nutzerdaten WHERE benutzername = ?");
$stmt->bind_param("s", $benutzername);
$stmt->execute();
$result = $stmt->get_result();


$userData = $result->fetch_assoc();

// Abfragen für verfügbare Sprachen und Termine
$sprachenQuery = "SELECT DISTINCT sprache FROM schulungen WHERE sprache IS NOT NULL";
$schulungsartQuery = "SELECT DISTINCT schulungsart FROM schulungen WHERE schulungsart IS NOT NULL";
$termineQuery = "SELECT DISTINCT termin FROM schulungen WHERE modul = 'Operations' AND schwierigkeitsgrad = 'Einsteiger'";

$sprachenResult = $conn->query($sprachenQuery);
$termineResult = $conn->query($termineQuery);
$schulungsartResult = $conn->query($schulungsartQuery);


if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    $alertType = $notification['status'] == 'success' ? 'alert-success' : 'alert-danger';
    echo "<div id='notification-alert' class='alert $alertType alert-dismissible fade show' role='alert'>
            {$notification['message']}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
    unset($_SESSION['notification']); // Benachrichtigung aus der Session entfernen
}

?> 
