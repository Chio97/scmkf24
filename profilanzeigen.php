<?php
session_start();

if (!isset($_SESSION['benutzername'])) {
    // Keine Session vorhanden, also Umleitung zur Login-Seite
    header("Location: newindex.php");
    exit;
}

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
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .card-img-top {
            height: 200px;
            /* Fixiert die Höhe der Bilder */
            object-fit: cover;
            /* Sorgt dafür, dass die Bilder gut aussehen */
        }
        
        .container.mt-4 {
            margin-bottom: 330px;
        }
        
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    <img src="images/logo.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
                    <span class="navbar-brand mb-0 h1">SCM Knowledge Factory</span>
                </div>
            </nav>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mainseite.php"><?= $lang['mainseite'] ?></a>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $lang['training'] ?>
                </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="opeinst.php"><?= $lang['operations_einst'] ?></a></li>
                                <li><a class="dropdown-item" href="opefort.php"><?= $lang['operations_fort'] ?></a></li>
                                <li><a class="dropdown-item" href="coeinst.php"><?= $lang['controlling_einst'] ?></a></li>
                                <li><a class="dropdown-item" href="cofortg.php"><?= $lang['controlling_fort'] ?></a></li>
                            </ul>
                        </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontakt.php"><?= $lang['contact'] ?></a>
                    </li>
                </ul>

            </div>
            <div class="d-flex" style="width: 11%">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownProfileLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="images/profil.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top"> <?= $lang['profile'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownProfileLink">
                        <li><a class="dropdown-item" href="profilanzeigen.php"><?= $lang['show_profile'] ?></a></li>
                        <li><a class="dropdown-item" href="logout.php"><?= $lang['logout'] ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex" style="width: 11%">
                <a href="?lang=de" class="btn btn-link">DE</a>
                <a href="?lang=en" class="btn btn-link">EN</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="profil.php" class="card text-decoration-none text-dark">
                    <img src="images/daten.png" class="card-img-top" alt="Meine Daten">
                    <div class="card-body">
                        <h5 class="card-title">Meine Daten</h5>
                        <p class="card-text">Daten aktualisieren</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="passwort.php" class="card text-decoration-none text-dark">
                    <img src="images/change-password-51.png" class="card-img-top" alt="Passwort ändern">
                    <div class="card-body">
                        <h5 class="card-title">Passwort</h5>
                        <p class="card-text">Passwort ändern</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="reservierungen.php" class="card text-decoration-none text-dark">
                    <img src="images/reservation.avif" class="card-img-top" alt="Meine Reservierungen">
                    <div class="card-body">
                        <h5 class="card-title">Meine Reservierungen</h5>
                        <p class="card-text">Reservierungen angucken</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <footer class="navbar bg-body-tertiary fixed-bottom">
        <nav class="navbar fixed-bottom bg-body-tertiary ">

            <nav class="nav flex-column ">
                <a class="nav-link " href="agb.html ">AGB</a>
                <a class="nav-link " href="impressum.html ">Impressum</a>
                <a class="nav-link " href="datenschutz.html ">Datenschutz</a>
            </nav>
            <div class="footer-social ">
                <div class="footer-copyright ">© ifm electronic gmbh 2024</div>
            </div>
            <div class="footer-subsidiary" style="padding: 1%">
                <p><strong>ifm business solutions</strong><br /> Martinshardt 19<br /> 57074&nbsp;Siegen
                </p>
                <p><strong>Hotline 0800 / 16 16 16 4</strong><br />
                    <strong>E-Mail&nbsp;</strong><a href="mailto:info@ifm.com ">info@ifm.com</a></p>
            </div>
        </nav>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</body>

</html>