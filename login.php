<?php
session_start(); // Starten der PHP-Session

$benutzername = $_POST['benutzername'];
$passwort = $_POST['passwort'];


//DATABASE CONNECTION
$con = new mysqli("localhost", "root", "", "nutzer_db");
if($con->connect_error) {
    die("Failed to connect : " . $con->connect_error);
} else {
    $stmt = $con->prepare("SELECT * FROM nutzerdaten WHERE benutzername = ?");
    $stmt->bind_param("s", $benutzername);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        if ($data['passwort'] === $passwort) {
            $_SESSION['vorname'] = $data['vorname'];
            $_SESSION['benutzername'] = $data['benutzername']; // Speichern des Vornamens in der Session
            header("Location: mainseite.php"); // Umleitung zur Hauptseite
            exit;
        } else {
            echo "<h2>Invalid Benutzername or password</h2>";
        }
    } else {
        echo "<h2>Invalid Benutzername or password</h2>";
    }
}
?>
