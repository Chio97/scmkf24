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
            header("Location: opefort.php");
            exit();
        } else {
            // Überprüfen, ob der Termin ausgebucht ist
            $sqlCount = "SELECT COUNT(*) AS anzahl_anmeldungen FROM reservierung WHERE termin = ?";
            $stmtCount = $conn->prepare($sqlCount);
            $stmtCount->bind_param("s", $termin);
            $stmtCount->execute();
            $resultCount = $stmtCount->get_result();
            $rowCount = $resultCount->fetch_assoc();

            if ($rowCount['anzahl_anmeldungen'] >= 8) {
                // Termin ist ausgebucht
                $_SESSION['notification'] = ['status' => 'error', 'message' => $lang['termin_ausgebucht']];
                header("Location: opefort.php");
                exit();
            } else {
                // Unternehmensname aus der Tabelle 'benutzerdaten' abrufen
                $sqlFirma = "SELECT unternehmen FROM nutzerdaten WHERE benutzername = ?";
                $stmtFirma = $conn->prepare($sqlFirma);
                $stmtFirma->bind_param("s", $benutzername);
                $stmtFirma->execute();
                $resultFirma = $stmtFirma->get_result();
                $rowFirma = $resultFirma->fetch_assoc();
                $unternehmen = $rowFirma['unternehmen'];
                
                // Schulungs-ID aus der Tabelle 'schulungen' basierend auf dem Termin abrufen
                $sqlSchulung = "SELECT schulungsid FROM schulungen WHERE termin = ?";
                $stmtSchulung = $conn->prepare($sqlSchulung);
                $stmtSchulung->bind_param("s", $termin);
                $stmtSchulung->execute();
                $resultSchulung = $stmtSchulung->get_result();
                $rowSchulung = $resultSchulung->fetch_assoc();
                $schulungsid = $rowSchulung['schulungsid'];
                
                if ($unternehmen == "ifm business solutions") {
                    $sql = "INSERT INTO reservierung (traeger_vorname, traeger_nachname, benutzername, strasse, stadt, plz, termin, unternehmen, bezahlt, s_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)";
                } else {
                    $sql = "INSERT INTO reservierung (traeger_vorname, traeger_nachname, benutzername, strasse, stadt, plz, termin, unternehmen, bezahlt, s_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?)";
                }
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    $_SESSION['notification'] = ['status' => 'error', 'message' => 'Datenbankfehler: ' . $conn->error];
                } else {
                    $stmt->bind_param("sssssssss", $traeger_vorname, $traeger_nachname, $benutzername, $strasse, $stadt, $plz, $termin, $unternehmen, $schulungsid);
                    if ($stmt->execute()) {
                        $_SESSION['notification'] = ['status' => 'success', 'message' => $lang['buchung_erfolgreich']];
                    } else {
                        $_SESSION['notification'] = ['status' => 'error', 'message' => $lang['buchung_fehlgeschlagen'] . $stmt->error];
                    }
                    $stmt->close();
                }
                header("Location: opefort.php");
                exit();
            }
        }
    } else {
        $_SESSION['notification'] = ['status' => 'error', 'message' => $lang['felder_ausfuellen']];
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
