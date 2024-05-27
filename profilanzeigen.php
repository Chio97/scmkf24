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
    <title>My Profile</title>
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
            margin-bottom: 110px;
        }
        
    </style>
</head>

<body>
<?php include 'nav.php'; ?>

    <div class="container mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="profil.php" class="card text-decoration-none text-dark">
                    <img src="images/daten.png" class="card-img-top" alt="Meine Daten">
                    <div class="card-body">
                        <h5 class="card-title"><?= $lang['meine_daten'] ?></h5>
                        <p class="card-text"><?= $lang['daten_aktualisieren'] ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="passwort.php" class="card text-decoration-none text-dark">
                    <img src="images/change-password-51.png" class="card-img-top" alt="Passwort ändern">
                    <div class="card-body">
                        <h5 class="card-title"><?= $lang['password'] ?></h5>
                        <p class="card-text"><?= $lang['change_password'] ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="reservierungen.php" class="card text-decoration-none text-dark">
                    <img src="images/reservation.avif" class="card-img-top" alt="Meine Reservierungen">
                    <div class="card-body">
                        <h5 class="card-title"><?= $lang['meine_reservierungen']?></h5>
                        <p class="card-text"><?= $lang['reservierungen_verwalten'] ?></p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</body>

</html>