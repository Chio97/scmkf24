<?php
session_start(); 

include 'db.php'; 

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern
}

// Sprachdatei
$lang = require 'languages/' . $_SESSION['lang'] . '.php';

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
    <title> <?= $lang['passwort_zurück'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/scm_knowledge_factory/images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .register-container {
            background-color: #333; /* Hintergrundfarbe der Box */
            color: white; /* Textfarbe in der Box */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
        }

        .btn-primary {
            background-color: #ff6c04; /* Hintergrundfarbe des Buttons */
            border-color: #ff6c04; /* Randfarbe des Buttons */
            width: 100%;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #e65a00; /* Hintergrundfarbe des Buttons beim Hover */
            border-color: #e65a00; /* Randfarbe des Buttons beim Hover */
        }

        .btn-secondary {
            background-color: #808080; /* Hintergrundfarbe des grauen Buttons */
            color: white; /* Textfarbe des grauen Buttons */
            border-color: #808080; /* Randfarbe des grauen Buttons */
        }

        .btn-secondary:hover {
            background-color: #666666; /* Hintergrundfarbe des grauen Buttons beim Hover */
            border-color: #666666; /* Randfarbe des grauen Buttons beim Hover */
        }

        .btn-link {
            color: white; /* Farbe der Links */
        }

        .btn-link:hover {
            color: #ccc; /* Farbe der Links beim Hover */
        }
        .text-end a {
            color: white; /* Farbe der Links im text-end div */
        }

        .text-end a:hover {
            color: #ccc; /* Farbe der Links im text-end div beim Hover */
        }
    </style>
</head>
<body>
    <div class="container-sm register-container">
    <div class="text-end">
                <a href="?lang=de">DE</a> | <a href="?lang=en">EN</a>
            </div>

    <a href="newindex.php" class="btn btn-secondary" style="background-color: #808080; color: #fff; border-color: #808080;">
            <span style="margin-right: 5px;">&#8592;</span> <?= $lang['zurueck_login'] ?>
        </a>
        <h1 style="text-align: center;"> <?= $lang['passwort_zurück'] ?></h1>
        <form action="forgot_password.php" method="post" class="mt-4" autocomplete="off">
            <div class="mb-3">
                <label for="benutzername" class="form-label"> <?= $lang['username'] ?>:</label>
                <input type="text" class="form-control" id="benutzername" name="benutzername" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"> <?= $lang['email'] ?>:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="sicherheitsfrage" class="form-label"> <?= $lang['sicherheitsfrage'] ?>:</label>
                <select class="form-select" id="sicherheitsfrage" name="sicherheitsfrage" required>
                    <option selected disabled value=""> <?= $lang['frage_auswählen'] ?></option>
                    <option value="Was ist der Geburtsort Ihres Vaters?"> <?= $lang['geburtsort_vater'] ?></option>
                    <option value="Wie lautet der Name Ihres besten Freundes in der Kindheit?"> <?= $lang['name_bester_freund'] ?></option>
                    <option value="Was ist Ihr Lieblingsfilm?"> <?= $lang['lieblingsfilm'] ?></option>
                    <option value="Was ist Ihr Lieblingsessen?"> <?= $lang['lieblingsessen'] ?></option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sicherheitsantwort" class="form-label"> <?= $lang['antwort'] ?>:</label>
                <input type="text" class="form-control" id="sicherheitsantwort" name="sicherheitsantwort" required>
            </div>
            <div class="mb-3">
                <label for="passwort" class="form-label"> <?= $lang['neues_passwort'] ?></label>
                <input type="password" class="form-control" id="passwort" name="passwort" required>
            </div>
            <div class="mb-3">
                <label for="passwort-confirm" class="form-label"> <?= $lang['passwort_bestätigen'] ?></label>
                <input type="password" class="form-control" id="passwort-confirm" name="passwort-confirm" required>
            </div>
            <button type="submit" class="btn btn-primary"> <?= $lang['passwort_zurück'] ?></button>
        </form>
    </div>



</body>
</html>
