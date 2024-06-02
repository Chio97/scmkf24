<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg custom-orange-bg mb-3">
    <div class="container-fluid">
  <a href="mainseite.php" class="d-flex align-items-center navbar-brand-link">
            <img src="images/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top" style="border: 1px solid white; border-radius: 50%;">
            <span class="navbar-brand mb-0 h1" style="color: white; margin-left: 10px;">SCM Knowledge Factory</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link" style="color: white;" href="mainseite.php"><?= $lang['home'] ?></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="color: white;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $lang['training'] ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="opeinst.php"><?= $lang['operations_einst'] ?></a></li>
                        <li><a class="dropdown-item" href="opefort.php"><?= $lang['operations_fort'] ?></a></li>
                        <li><a class="dropdown-item" href="coeinst.php"><?= $lang['controlling_einst'] ?></a></li>
                        <li><a class="dropdown-item" href="cofortg.php"><?= $lang['controlling_fort'] ?></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white;" href="reservierungen.php"><?= $lang['meine_reservierungen'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white;" href="kontakt.php"><?= $lang['contact'] ?></a>
                </li>
                <div class="dropdown">
                <a class="nav-link dropdown-toggle" style="color: white;" href="#" role="button" id="dropdownLanguageLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $lang['language'] ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLanguageLink">
                    <li><a class="dropdown-item" href="?lang=de">Deutsch</a></li>
                    <li><a class="dropdown-item" href="?lang=en">English</a></li>
                </ul>
            </div>
            </ul>
        </div>
        <div class="d-flex">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" style="color: white;" href="#" role="button" id="dropdownProfileLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/profil.png" alt="Profil" width="30" height="30" class="d-inline-block align-text-top"> <?= $lang['profile'] ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfileLink">
                    <li><a class="dropdown-item" href="profilanzeigen.php"><?= $lang['show_profile'] ?></a></li>
                    <li><a class="dropdown-item" href="logout.php"><?= $lang['logout'] ?></a></li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-HoA2/8kKzdLxaWxt6uNea+x14v9YYG1FY6kGihVuFJQ03oZ5T6iYeE6sc/VVW9uG" crossorigin="anonymous"></script>
</body>
</html>

