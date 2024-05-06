<?php
session_start(); // Start der Sitzung

// Überprüfen, ob eine Erfolgsmeldung vorhanden ist
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success" role="alert" id="successMessage">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']); // Erfolgsmeldung entfernen
}

// Überprüfen, ob eine Fehlermeldung vorhanden ist
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert" id="errorMessage">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Fehlermeldung entfernen
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort zurücksetzen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;

            margin: 20px auto;
        }
        
        .btn-primary {
            width: 100%;
            padding: 10px;
        }
        
    </style>
</head>
<body>

    <div class="container-sm register-container">
    <a href="newindex.php" class="btn btn-secondary" style="background-color: #808080; color: #fff; border-color: #808080;">
            <span style="margin-right: 5px;">&#8592;</span> Zurück zum Login
        </a>
        <h1 style="text-align: center;">Passwort zurücksetzen</h1>
        <form action="forgot_password.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="benutzername" class="form-label">Benutzername:</label>
                <input type="text" class="form-control" id="benutzername" name="benutzername" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail-Adresse:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="sicherheitsfrage" class="form-label">Sicherheitsfrage:</label>
                <select class="form-select" id="sicherheitsfrage" name="sicherheitsfrage" required>
                    <option selected disabled value="">Frage auswählen</option>
                    <option value="Was ist der Geburtsort Ihres Vaters?">Was ist der Geburtsort Ihres Vaters?</option>
                    <option value="Wie lautet der Name Ihres besten Freundes in der Kindheit?">Wie lautet der Name Ihres besten Freundes in der Kindheit?</option>
                    <option value="Was ist Ihr Lieblingsfilm?">Was ist Ihr Lieblingsfilm?</option>
                    <option value="Was ist Ihr Lieblingsessen?">Was ist Ihr Lieblingsessen?</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sicherheitsantwort" class="form-label">Sicherheitsantwort:</label>
                <input type="text" class="form-control" id="sicherheitsantwort" name="sicherheitsantwort" required>
            </div>
            <div class="mb-3">
                <label for="passwort" class="form-label">Neues Passwort:</label>
                <input type="password" class="form-control" id="passwort" name="passwort" required>
            </div>
            <div class="mb-3">
                <label for="passwort-confirm" class="form-label">Passwort bestätigen:</label>
                <input type="password" class="form-control" id="passwort-confirm" name="passwort-confirm" required>
            </div>
            <button type="submit" class="btn btn-primary">Passwort zurücksetzen</button>
        </form>
    </div>



</body>
</html>
