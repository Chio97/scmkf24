<?php
session_start();
include 'db.php';  // Stellen Sie sicher, dass Ihre Datenbankverbindung korrekt ist.

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
            $_SESSION['notification'] = ['status' => 'error', 'message' => 'Sie haben diesen Termin bereits gebucht.'];
            header("Location: opefort.php");
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
                    $_SESSION['notification'] = ['status' => 'success', 'message' => 'Die Schulung wurde erfolgreich gebucht! Sie können Ihre Reservierung bei Meine Reservierungen in Ihrem Profil anschauen!'];
                } else {
                    $_SESSION['notification'] = ['status' => 'error', 'message' => 'Fehler beim Buchen der Schulung: ' . $stmt->error];
                }
                $stmt->close();
            }
            header("Location: opefort.php");
            exit();
        }
    } else {
        $_SESSION['notification'] = ['status' => 'error', 'message' => 'Bitte füllen Sie alle erforderlichen Felder aus.'];
        header("Location: opefort.php");
        exit();
    }
} else {
    // Direkter Zugriff auf diese Datei ohne POST-Anfrage
    header("Location: opefort.php");
    exit();
}

// Schließe die Datenbankverbindung
$conn->close();
?>
