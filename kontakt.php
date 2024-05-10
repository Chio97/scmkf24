<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hauptseite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
    }
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
        $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
    }
    
    // Sprachdateien basierend auf der gewählten Sprache laden
    $lang = require 'languages/' . $_SESSION['lang'] . '.php';

    if (!isset($_SESSION['benutzername'])) {
        // Keine Session vorhanden, also Umleitung zur Login-Seite
        header("Location: newindex.php");
        exit;
    }

    ?>

    <!-- Erfolgsmeldung anzeigen, wenn vorhanden -->
    <?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" role="alert" id="successMessage">
        <?php echo $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); // Erfolgsmeldung entfernen ?>
    <?php endif; ?>
    
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
    <div style="margin-top: 5px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><?= $lang['kontaktieren_sie'] ?></h2>
                <p><?= $lang['ausfüllen_kontakt'] ?></p>
                <form action="kontaktformular.php" method="POST" onsubmit="return validateForm()">
                <div class="mb-3">
                <label for="name" class="form-label"><?= $lang['username'] ?></label>
                <input type="text" class="form-control" id="benutzername" value="<?php echo htmlspecialchars($_SESSION['benutzername'] ?? ''); ?>" name="benutzername">
                <div id="benutzernameError" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><?= $lang['email'] ?></label>
                <input type="email" class="form-control" id="email" name="email">
                <div id="emailError" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="betreff" class="form-label"><?= $lang['betreff'] ?></label>
                <input type="text" class="form-control" id="betreff" name="betreff">
                <div id="betreffError" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="nachricht" class="form-label"><?= $lang['nachricht'] ?></label>
                <textarea class="form-control" id="nachricht" name="nachricht" rows="5"></textarea>
                <div id="nachrichtError" class="text-danger"></div>
            </div>

                    <button type="submit" class="btn btn-primary"><?= $lang['nachricht_senden'] ?></button>
                </form>
            </div>
            <div class="col-md-6">
                <h2><?= $lang['kontaktinfo'] ?></h2>
                <p><strong>Telefon:</strong> 0800 / 16 16 16 4</p>
                <p><strong>E-Mail:</strong> <a href="mailto:serxhio.zani@ifm.com">serxhio.zani@ifm.com</a></p>
                <p><strong><?= $lang['büroadresse'] ?>:</strong><br>
                    The SUMMIT<br>
                    ifm business solutions<br>
                    Martinshardt 19<br>
                    57074 Siegen</p>
                <!-- Google Maps Integration -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2542.8654975429266!2d8.02824675466841!3d50.85104292180763!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b9c9c1d96d3b1d%3A0xe01f3035eeec5a02!2sifm%20electronic%20gmbh!5e0!3m2!1sen!2sde!4v1643717208249!5m2!1sen!2sde" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                <!-- Social Media Links -->
                <h2 style="margin-top: 1%; margin-bottom: 3%;"><?= $lang['folgen_sie'] ?></h2>
                <a href="https://www.facebook.com/ifmsupplychain" class="btn btn-outline-primary"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="https://twitter.com/ifmelectronic" class="btn btn-outline-primary"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="https://www.linkedin.com/company/ifm-supply-chain/" class="btn btn-outline-primary"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
            </div>
        </div>
    </div>
    <nav class="navbar bg-body-tertiary" style="margin-top: 2%;">
        <nav class="nav flex-column">
            <a class="nav-link" href="agb.html"><?= $lang['agb'] ?></a>
            <a class="nav-link" href="impressum.html">Impressum</a>
            <a class="nav-link" href="datenschutz.html"><?= $lang['datenschutz'] ?></a>
        </nav>
        <div class="footer-social">
            <div class="footer-copyright">© ifm business solutions 2024</div>
        </div>
        <div class="footer-subsidiary" style="padding: 1%">
            <p><strong>ifm business solutions</strong><br /> Martinshardt 19<br /> 57074&nbsp;Siegen
            </p>
            <p><strong>Hotline 0800 / 16 16 16 4</strong><br />
                <strong>E-Mail&nbsp;</strong><a href="mailto:info@ifm.com">info@ifm.com</a></p>
        </div>
    </nav>
    <script>
    function validateForm() {
        var benutzername = document.getElementById('benutzername').value;
        var email = document.getElementById('email').value;
        var betreff = document.getElementById('betreff').value;
        var nachricht = document.getElementById('nachricht').value;

        if (benutzername === "") {
            document.getElementById('benutzernameError').innerText = "Bitte geben Sie Ihren Benutzernamen ein.";
            return false;
        } else {
            document.getElementById('benutzernameError').innerText = "";
        }

        if (email === "") {
            document.getElementById('emailError').innerText = "Bitte geben Sie Ihre E-Mail-Adresse ein.";
            return false;
        } else {
            document.getElementById('emailError').innerText = "";
        }

        if (betreff === "") {
            document.getElementById('betreffError').innerText = "Bitte geben Sie den Betreff ein.";
            return false;
        } else {
            document.getElementById('betreffError').innerText = "";
        }

        if (nachricht === "") {
            document.getElementById('nachrichtError').innerText = "Bitte geben Sie Ihre Nachricht ein.";
            return false;
        } else {
            document.getElementById('nachrichtError').innerText = "";
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Funktion zum Ausblenden der Meldung nach 5 Sekunden
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</body>

</html>
