<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

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

// Überprüfung, ob der Benutzername gesetzt ist, entweder über POST (bei einem Formularsubmit) oder über SESSION (wenn bereits gespeichert)
if (isset($_POST['benutzername'])) {
    $benutzername = $_POST['benutzername'];
    $_SESSION['benutzername'] = $benutzername;
} elseif (isset($_SESSION['benutzername'])) {
    $benutzername = $_SESSION['benutzername'];
} else {
    die("Benutzername nicht gesetzt. Bitte stellen Sie sicher, dass Sie angemeldet sind.");
}
// Datenbankverbindung
$conn = new mysqli("Localhost", "root", "", "nutzer_db");
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}


// Daten abrufen
$stmt = $conn->prepare("SELECT vorname, name, benutzername, email, unternehmen, beruf, adresse, plz, stadt FROM nutzerdaten WHERE benutzername = ?");
$stmt->bind_param("s", $benutzername);
$stmt->execute();
$result = $stmt->get_result();


$userData = $result->fetch_assoc();

// Abfragen für verfügbare Sprachen und Termine
$sprachenQuery = "SELECT DISTINCT sprache FROM schulungen WHERE sprache IS NOT NULL";
$schulungsartQuery = "SELECT DISTINCT schulungsart FROM schulungen WHERE schulungsart IS NOT NULL";
$termineQuery = "SELECT DISTINCT termin FROM schulungen WHERE modul = 'Operations' AND schwierigkeitsgrad = 'Einsteiger'";

$sprachenResult = $conn->query($sprachenQuery);
$termineResult = $conn->query($termineQuery);
$schulungsartResult = $conn->query($schulungsartQuery);


if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    $alertType = $notification['status'] == 'success' ? 'alert-success' : 'alert-danger';
    echo "<div id='notification-alert' class='alert $alertType' role='alert'>
            {$notification['message']}
          </div>";
    unset($_SESSION['notification']); // Benachrichtigung aus der Session entfernen
}

?> 

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

    <!--<p class="h5 mb-3">GIB Operations Schulung für Einsteiger*innen</p>-->

    <div class="container-fluid mb">
        <div class="row">
            <!-- Spalte für das Bild -->
            <!--<div class="col-md-8">-->
            <div class="col-lg-8">
                <img src="images/controlling_einsteiger-innen_1704x717.jpg" class="img-fluid" alt="...">
            </div>
            <!-- Spalte für die Karte -->
            <div class="col-lg-4 ">
                <div class="card border-primary mb-3">
                    <div class="card-header"><?= $lang['kursinfo'] ?></div>
                    <div class="card-body text-primary">
                        <h5 class="card-title"><?= $lang['kursdauer'] ?></h5>
                        <p class="card-text"><?= $lang['kursdauer_t'] ?></p>
                        <h5 class="card-title"><?= $lang['veranstaltungsort'] ?></h5>
                        <p class="card-text"><?= $lang['veranstaltungsort_t'] ?></p>
                        <h5 class="card-title"><?= $lang['zielgruppe'] ?></h5>
                        <p class="card-text"><?= $lang['zielgruppe_t_c'] ?></p>
                        <h5 class="card-title"><?= $lang['teilnehmergebühr'] ?></h5>
                        <p class="card-text">580 €</p>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary me-md-2 fs-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <?= $lang['buchen'] ?>
                                                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog text-dark">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $lang['buchen_co_e'] ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" method="POST" action="buche_coeinst.php">
                                            <div class="col-md-4">
                                            <select class="form-select" id="spracheSelect" required>
                                                    <option selected disabled value=""><?= $lang['sprache_auswählen'] ?></option>
                                                    <?php
                                                    if ($sprachenResult->num_rows > 0) {
                                                        while($row = $sprachenResult->fetch_assoc()) {
                                                            echo '<option value="' . $row["sprache"] . '">' . $row["sprache"] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                            <select class="form-select" id="schulungsartSelect" required>
                                                <option selected disabled value=""><?= $lang['schulungsart_auswählen'] ?></option>
                                                <?php
                                                if ($schulungsartResult->num_rows > 0) {
                                                    while($row = $schulungsartResult->fetch_assoc()) {
                                                        echo '<option value="' . $row["schulungsart"] . '">' . $row["schulungsart"] . '</option>';
                                                    }
                                                }
                                                ?>
                                              </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" id="terminSelect" name="termin" required>
                                                    <option selected disabled value=""><?= $lang['termin_auswählen'] ?></option>
                                                    <?php
                                                    if ($termineResult->num_rows > 0) {
                                                        while($row = $termineResult->fetch_assoc()) {
                                                            echo '<option value="' . $row["termin"] . '">' . $row["termin"] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <h5><?= $lang['rechnungsadresse'] ?></h5>
                                            <div class="col-md-4">
                                                <label for="validationDefault01" class="form-label"><?= $lang['vorname'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault01" value="<?php echo htmlspecialchars($userData['vorname'] ?? ''); ?>" name="traeger_vorname" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationDefault02" class="form-label"><?= $lang['nachname'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault02" value="<?php echo htmlspecialchars($userData['name'] ?? ''); ?>"name="traeger_nachname"required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationDefaultUsername" class="form-label"><?= $lang['username'] ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                                    <!-- Fügen Sie den Wert aus der Session ein, wenn verfügbar -->
                                                    <input type="text" class="form-control" id="validationDefaultUsername" value="<?php echo htmlspecialchars($_SESSION['benutzername'] ?? ''); ?>" aria-describedby="inputGroupPrepend2" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="validationDefault03" class="form-label"><?= $lang['straße'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault03" value="<?php echo htmlspecialchars($userData['adresse'] ?? ''); ?>" name="strasse" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="validationDefault04" class="form-label"><?= $lang['stadt'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault04" value="<?php echo htmlspecialchars($userData['stadt'] ?? ''); ?>" name="stadt" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="validationDefault05" class="form-label"><?= $lang['plz'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault05"  value="<?php echo htmlspecialchars($userData['plz'] ?? ''); ?>"name="plz" required>
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
                                                <button class="btn btn-primary" type="submit"><?= $lang['jetzt_buchen'] ?></button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $lang['close'] ?></button>
                                            </div>
                                            <input type="hidden" name="benutzername" value="<?php echo htmlspecialchars($benutzername); ?>">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

            </div>

        </div>
    </div>
    </div>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['textblock1_ce_ü'] ?></strong></p>
        <blockquote class="blockquote">
            <p><?= $lang['textblock1_ce_t'] ?></p>
        </blockquote>
    </div>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['ihr_nutzen'] ?></strong></p>
        <blockquote class="blockquote">
            <p><?= $lang['ihr_nutzen_t'] ?></p>
        </blockquote>
    </div>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['erwartung'] ?></strong></p>
    </div>
    <blockquote class="blockquote">
        <ul class="list-unstyled">
            <ul>
                <li><?= $lang['erwartung1_ce'] ?></li>
                <li><?= $lang['erwartung2_ce'] ?></li>
                <li><?= $lang['erwartung3_ce'] ?></li>
                <li><?= $lang['erwartung4_ce'] ?></li>
            </ul>
        </ul>
    </blockquote>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['an_wen'] ?></strong></p>
    </div>
    <blockquote class="blockquote">
        <ul class="list-unstyled">
            <ul>
                <li><?= $lang['an_wen_t1'] ?></li>
                <li><?= $lang['an_wen_t2'] ?></li>
            </ul>
        </ul>
    </blockquote>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['exclusive'] ?> </strong></p>
        <blockquote class="blockquote">
            <p><?= $lang['exclusive_t1'] ?> <a href="mailto:serxhio.zani@berater.ifm">serxhio.zani@berater.ifm</a> <?= $lang['exclusive_t2'] ?>
            </p>
        </blockquote>
    </div>
    <nav class="navbar bg-body-tertiary">

        <nav class="nav flex-column">
            <a class="nav-link" href="agb.html"><?= $lang['agb'] ?></a>
            <a class="nav-link" href="impressum.html">Impressum</a>
            <a class="nav-link" href="datenschutz.html"><?= $lang['datenschutz'] ?></a>
        </nav>
        <div class="footer-social">
            <div class="footer-copyright">© ifm electronic gmbh 2024</div>
        </div>
        <div class="footer-subsidiary"style="padding: 1%">
            <p><strong>ifm business solutions</strong><br /> Martinshardt 19<br /> 57074&nbsp;Siegen
            </p>
            <p><strong>Hotline 0800 / 16 16 16 4</strong><br />
                <strong>E-Mail&nbsp;</strong><a href="mailto:info@ifm.com">info@ifm.com</a></p>
        </div>
    </nav>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    function fetchTermine() {
        var sprache = document.getElementById('spracheSelect').value;
        var schulungsart = document.getElementById('schulungsartSelect').value;
        var modul = 'Controlling';  // Beispielwert, setzen Sie den tatsächlichen Wert hier
        var schwierigkeitsgrad = 'Einsteiger';  // Beispielwert, anpassbar je nach Seite oder Kontext

        if(sprache && schulungsart) {
            fetch(`fetch_termine.php?sprache=${sprache}&schulungsart=${schulungsart}&modul=${modul}&schwierigkeitsgrad=${schwierigkeitsgrad}`)
                .then(response => response.json())
                .then(data => {
                    var terminSelect = document.getElementById('terminSelect');
                    terminSelect.innerHTML = '';
                    data.forEach(function(termin) {
                        var option = new Option(termin.termin, termin.termin);
                        terminSelect.add(option);
                    });
                })
                .catch(error => console.error('Error loading the terms:', error));
        }
    }

    document.getElementById('spracheSelect').addEventListener('change', fetchTermine);
    document.getElementById('schulungsartSelect').addEventListener('change', fetchTermine);
});
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var alertBox = document.getElementById('notification-alert');
    if (alertBox) {
        setTimeout(function() {
            alertBox.style.display = 'none';
        }, 5000);
    }
});
</script>
</body>

</html>