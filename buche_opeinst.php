<?php
session_start();
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    echo '<div class="alert alert-' . ($notification['status'] == 'success' ? 'success' : 'danger') . '">';
    echo htmlspecialchars($notification['message']);
    echo '</div>';
    unset($_SESSION['notification']);
}
include 'db.php';  // Stellen Sie sicher, dass Ihre Datenbankverbindung korrekt ist.
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
}

// Sprachdateien basierend auf der gewählten Sprache laden
$lang = require 'languages/' . $_SESSION['lang'] . '.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sicherstellen, dass alle benötigten Felder vorhanden sind.
    if (isset($_POST['benutzername'], $_POST['termin'], $_POST['traeger_vorname'], $_POST['traeger_nachname'], $_POST['strasse'], $_POST['stadt'], $_POST['plz'])) {
        $benutzername = $_POST['benutzername'];
        $termin = $_POST['termin'];
        $traeger_vorname = $_POST['traeger_vorname'];
        $traeger_nachname = $_POST['traeger_nachname'];
        $strasse = $_POST['strasse'];
        $stadt = $_POST['stadt'];
        $plz = $_POST['plz'];

        // Überprüfen, ob der Benutzer diesen Termin bereits gebucht hat
        $sqlCheck = "SELECT * FROM reservierung WHERE benutzername = ? AND termin = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("ss", $benutzername, $termin);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            // Benutzer hat diesen Termin bereits gebucht
            $_SESSION['notification'] = ['status' => 'error', 'message' => $lang['termin_bereits_gebucht']];
            header("Location: opeinst.php");
            exit();
        } else {
            // Führe die Buchung durch
            $sql = "INSERT INTO reservierung (traeger_vorname, traeger_nachname, benutzername, strasse, stadt, plz, termin) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $_SESSION['notification'] = ['status' => 'error', 'message' => 'Datenbankfehler: ' . $conn->error];
            } else {
                $stmt->bind_param("sssssss", $traeger_vorname, $traeger_nachname, $benutzername, $strasse, $stadt, $plz, $termin);
                if ($stmt->execute()) {
                    $_SESSION['notification'] = ['status' => 'success', 'message' => $lang['buchung_erfolgreich']];
                } else {
                    $_SESSION['notification'] = ['status' => 'error', 'message' => $lang['buchung_fehlgeschlagen'] . $stmt->error];
                }
                $stmt->close();
            }
            header("Location: opeinst.php");
            exit();
        }
    } else {
        $_SESSION['notification'] = ['status' => 'error', 'message' => $lang['felder_ausfuellen']];
        header("Location: opeinst.php");
        exit();
    }
} else {
    // Direkter Zugriff auf diese Datei ohne POST-Anfrage
    header("Location: opeinst.php");
    exit();
}

// Schließe die Datenbankverbindung
$conn->close();
?>
