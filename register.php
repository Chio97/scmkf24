<?php
    session_start();

    //DATABASE CONNECTION
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
    $passwort = $_POST['passwort']; // Passwort sollte sicherheitshalber verschlüsselt werden

    // SQL-Anweisung zum Einfügen der Daten
    $sql = "INSERT INTO nutzerdaten (name, vorname, benutzername, email, adresse, plz, stadt, unternehmen, beruf, passwort)
    VALUES ('$name', '$vorname', '$benutzername', '$email', '$adresse', '$plz', '$stadt', '$unternehmen', '$beruf', '$passwort')";

    // SQL-Anweisung ausführen
    if ($conn->query($sql) === TRUE) {
        $_SESSION['notification'] = "Neues Profil wurde erstellt, Sie können sich in ein paar Sekunden anmelden...";
        header("Location: registration_success.php"); // Weiterleitung zur Erfolgsseite
        exit();
    } else {
        echo "Fehler: " . $sql . "<br>" . $conn->error;
    }

    // Verbindung schließen
    $conn->close();
?>
