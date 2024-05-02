<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-box {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .error {
            color: red; /* Rote Schriftfarbe für Fehlermeldungen */
        }
    </style>
</head>
<?php
session_start();
// Spracheinstellungen
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
}
// Sprachdateien basierend auf der gewählten Sprache laden
$lang = require 'languages/' . $_SESSION['lang'] . '.php';
?>
<body>
    <div class="login-box">
        <form action="login2.php" method="post">
            <div class="text-center mb-4">
                <img src="images/logo.png" alt="Logo" style="width: 100px;">
            </div>
            <div class="text-end">
                <a href="?lang=de">DE</a> | <a href="?lang=en">EN</a>
            </div>
            <h3><?= $lang['welcome'] ?></h3> <!-- Beispiel für die Nutzung eines übersetzten Textes -->
            <?php if(isset($_SESSION['error'])): ?>
                <div class="error">
                    <?= $lang[$_SESSION['error']]; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="benutzername" class="form-label"><?= $lang['username'] ?></label> <!-- Beispiel für die Nutzung eines übersetzten Textes -->
                <input type="text" class="form-control" id="benutzername" name="benutzername" required>
            </div>
            <div class="mb-3">
                <label for="passwort" class="form-label"><?= $lang['password'] ?></label> <!-- Beispiel für die Nutzung eines übersetzten Textes -->
                <input type="password" class="form-control" id="passwort" name="passwort" required>
            </div>
            <button type="submit" class="btn btn-primary"><?= $lang['login'] ?></button> <!-- Beispiel für die Nutzung eines übersetzten Textes -->
            <div class="mt-3 text-center">
                <a href="register.html"><?= $lang['no_account'] ?></a>
            </div>
        </form>
    </div>
</body>

</html>
