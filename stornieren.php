<?php
session_start();
include 'db.php';

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; 
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; 
}

$lang = require 'languages/' . $_SESSION['lang'] . '.php';

if (isset($_POST['reservierungsid'])) {
    $reservierungsid = $_POST['reservierungsid'];

    $sql = "DELETE FROM reservierung WHERE reservierungsid = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $reservierungsid); 
        if ($stmt->execute()) {
            $_SESSION['notification'] = $lang['reservierung_storniert'];
        } else {
            $_SESSION['notification'] = $lang['reservierung_nicht_storniert'];
        }
        $stmt->close();
    } else {
        $_SESSION['notification'] = "Datenbankfehler: " . $conn->error;
    }
    $conn->close();
    header("Location: reservierungen.php");
    exit;
}

?>
