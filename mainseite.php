<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<?php
    session_start();
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'de'; 
    }
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
        $_SESSION['lang'] = $_GET['lang']; 
    }
    
    
    $lang = require 'languages/' . $_SESSION['lang'] . '.php';

    if (!isset($_SESSION['benutzername'])) {

        header("Location: newindex.php");
        exit;
    }

    ?>

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
                        <a class="nav-link" href="reservierungen.php"><?= $lang['meine_reservierungen'] ?></a>
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
<div style="margin-top: 1%; text-align: center;">
    <h3>Hi <?php echo htmlspecialchars($_SESSION['vorname'] ?? ''); ?> , Willkommen bei der SCM-Knowledge Factory </h3>
</div>
    <div class="row" style="width: 100%; padding: 1%;">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <img src="images/operations.svg" class="card-img-top" alt="..." style="width:auto; height:400px;">
                <div class="card-body">
                    <h5 class="card-title"><?= $lang['operations_schul'] ?></h5>
                    <p class="card-text"><?= $lang['op_m_text'] ?></p>
                    <a href="opeinst.php" class="btn btn-primary"><?= $lang['beginner'] ?></a>
                    <a href="opefort.php" class="btn btn-primary"><?= $lang['advanced'] ?></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <img src="images/controlling.svg" class="card-img-top" alt="..." style="width:auto; height:400px;">
                <div class="card-body">
                    <h5 class="card-title"><?= $lang['controlling_schul'] ?></h5>
                    <p class="card-text"><?= $lang['co_m_text'] ?></p>
                    <a href="coeinst.php" class="btn btn-primary"><?= $lang['beginner'] ?></a>
                    <a href="cofortg.php" class="btn btn-primary"><?= $lang['advanced'] ?></a>
                </div>
            </div>
        </div>
    </div>

    <footer class="navbar bg-body-tertiary">
    <nav class="nav flex-column">
        <a class="nav-link" href="agb.html"><?= $lang['agb'] ?></a>
        <a class="nav-link" href="impressum.html">Impressum</a>
        <a class="nav-link" href="datenschutz.html"><?= $lang['datenschutz'] ?></a>
    </nav>
    <div class="footer-social">
        <div class="footer-copyright">© ifm electronic gmbh 2024</div>
    </div>
    <div class="footer-subsidiary" style="padding: 1%">
        <p><strong>ifm business solutions</strong><br /> Martinshardt 19<br /> 57074&nbsp;Siegen
        </p>
        <p><strong>Hotline 0800 / 16 16 16 4</strong><br />
            <strong>E-Mail&nbsp;</strong><a href="mailto:info@ifm.com">info@ifm.com</a></p>
    </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</body>


</html>
