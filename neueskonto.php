<?php
session_start();
include 'db.php'; // Stellen Sie sicher, dass Sie Ihre Datenbankverbindungsdatei richtig einbinden

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
}

// Sprachdateien basierend auf der gewählten Sprache laden
$lang = require 'languages/' . $_SESSION['lang'] . '.php';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrierung</title>
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

        .custom-h6 {
            color: rgba(255, 255, 255, 0.5);
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
            <span style="margin-right: 5px;">&#8592;</span><?= $lang['zurueck_login'] ?>
        </a>
        <h2 class="text-center mt-3 mb-3"><?= $lang['erstellen_konto'] ?></h2>
        <form class="register-form" action="register.php" method="post" autocomplete="off">
            <div class="row g-2">
                <div class="mt-3">
                    <h4><?= $lang['persönliche_daten'] ?></h4>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label"><?= $lang['nachname'] ?></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6">
                    <label for="vorname" class="form-label"><?= $lang['vorname'] ?></label>
                    <input type="text" class="form-control" id="vorname" name="vorname" required>
                </div>
                <div class="col-md-6">
                    <label for="benutzername" class="form-label"><?= $lang['username'] ?></label>
                    <input type="text" class="form-control" id="benutzername" name="benutzername" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label"><?= $lang['email'] ?></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label for="unternehmen" class="form-label"><?= $lang['unternehmen'] ?></label>
                    <input type="text" class="form-control" id="unternehmen" name="unternehmen" required>
                </div>
                <div class="col-md-6">
                    <label for="beruf" class="form-label"><?= $lang['beruf'] ?></label>
                    <input type="text" class="form-control" id="beruf" name="beruf" required>
                </div>
                <div class="mt-3">
                    <h4><?= $lang['firmenanschrifft'] ?></h4>
                    <h6 class="custom-h6"><?= $lang['firmenanschrifft_t'] ?></h6>
                </div>
                <div class="col-md-6">
                    <label for="adresse" class="form-label"><?= $lang['straße'] ?></label>
                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                </div>
                <div class="col-md-3">
                    <label for="plz" class="form-label"><?= $lang['plz'] ?></label>
                    <input type="text" class="form-control" id="plz" name="plz" required>
                </div>
                <div class="col-md-3">
                    <label for="stadt" class="form-label"><?= $lang['stadt'] ?></label>
                    <input type="text" class="form-control" id="stadt" name="stadt" required>
                </div>
                <div class="col-md-6">
                    <label for="sicherheitsfrage" class="form-label"><?= $lang['sicherheitsfrage'] ?></label>
                    <select class="form-select" id="sicherheitsfrage" name="sicherheitsfrage" required>
                    <option selected disabled value=""><?= $lang['frage_auswählen'] ?></option>
                                        <option value="Was ist der Geburtsort Ihres Vaters?"><?= $lang['geburtsort_vater'] ?></option>
                                        <option value="Wie lautet der Name Ihres besten Freundes in der Kindheit?"><?= $lang['name_bester_freund'] ?></option>
                                        <option value="Was ist Ihr Lieblingsfilm?"><?= $lang['lieblingsfilm'] ?></option>
                                        <option value="Was ist Ihr Lieblingsessen?"><?= $lang['lieblingsessen'] ?></option>
                  </select>
                </div>
                <div class="col-md-6">
                    <label for="text" class="form-label"><?= $lang['antwort'] ?></label>
                    <input type="text" class="form-control" id="sicherheitsantwort" name="sicherheitsantwort" required>
                </div>
                <div class="col-md-6">
                    <label for="passwort" class="form-label"><?= $lang['password'] ?> <?=$lang['mind_acht']?></label>
                    <input type="password" class="form-control" id="passwort" name="passwort" pattern=".{8,}" title="<?=$lang['passwort_muss_acht']?>" required>
                </div>
                <div class="col-md-6">
                    <label for="passwort-confirm" class="form-label"><?= $lang['passwort_bestätigen'] ?></label>
                    <input type="password" class="form-control" id="passwort-confirm" name="passwort-confirm" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">
                        <?= $lang['akzeptieren'] ?> <a href="pdf/AGB.pdf" target="_blank"><?= $lang['bedingungen'] ?></a>
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit"><?= $lang['kontoerstellen'] ?></button>
                </div>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>