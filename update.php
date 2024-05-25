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

if (!isset($_SESSION['benutzername'])) {
    die("Benutzername nicht gesetzt. Bitte stellen Sie sicher, dass Sie angemeldet sind.");
}

$benutzername = $_SESSION['benutzername'];

$conn = new mysqli("localhost", "root", "", "nutzer_db");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'save') {
        $stmt = $conn->prepare("UPDATE nutzerdaten SET vorname = ?, name = ?, email = ?, unternehmen = ?, beruf = ?, adresse = ?, plz = ?, stadt = ? WHERE benutzername = ?");
        $stmt->bind_param("sssssssss", $_POST['vorname'], $_POST['name'], $_POST['email'], $_POST['unternehmen'], $_POST['beruf'], $_POST['adresse'], $_POST['plz'], $_POST['stadt'], $benutzername);
        
        print_r($_POST); 
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            $_SESSION['notification'] = $lang['daten_geändert'];
        } else {
            $_SESSION['notification'] = $lang['keine_änderung'] . $stmt->error;
        }
        $stmt->close();
        header("Location: profil.php");
        exit();
        
    } elseif ($_POST['action'] == 'delete') {
        $stmt = $conn->prepare("DELETE FROM nutzerdaten WHERE benutzername = ?");
        $stmt->bind_param("s", $benutzername);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['notification'] = $lang['profil_gelöscht'];
            session_destroy();  
            header("Location: goodbye.php"); 
            exit();
        } else {
            $_SESSION['notification'] = $lang['fehler_löschen'];
            header("Location: profil.php");
            exit();
        }
} else {

    header("Location: profil.php");
    exit();
}
}
$conn->close();
?>
