<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profildaten bearbeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php
session_start();
include 'db.php'; // Stellen Sie sicher, dass Sie Ihre Datenbankverbindungsdatei richtig einbinden

// Überprüfung, ob der Benutzername gesetzt ist, entweder über POST (bei einem Formularsubmit) oder über SESSION (wenn bereits gespeichert)
if (isset($_POST['benutzername'])) {
    $benutzername = $_POST['benutzername'];
    $_SESSION['benutzername'] = $benutzername; // Speichern in der Session für späteren Gebrauch
} elseif (isset($_SESSION['benutzername'])) {
    $benutzername = $_SESSION['benutzername'];
} else {
    die("Benutzername nicht gesetzt. Bitte stellen Sie sicher, dass Sie angemeldet sind.");
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; 
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; 
}

// Sprachdatei
$lang = require 'languages/' . $_SESSION['lang'] . '.php';

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


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $vorname = $row['vorname'];
    $name = $row['name'];
    $benutzername = $row['benutzername'];
    $email = $row['email']; 
    $adresse = $row['adresse'];
    $plz = $row['plz'];
    $stadt = $row['stadt'];
    $unternehmen = $row['unternehmen'];
    $beruf = $row['beruf'];
} else {
    echo "Keine Daten gefunden";
}

$conn->close();
?>
<?php if (isset($_SESSION['notification'])): ?>
<div class="alert alert-success" role="alert" id="notification">
    <?php echo $_SESSION['notification']; ?>
    <?php unset($_SESSION['notification']); ?> <!-- Benachrichtigung aus der Session entfernen -->
</div>
<script>
    setTimeout(function() {
        document.getElementById('notification').style.display = 'none';
    }, 5000); // Die Benachrichtigung verschwindet nach 5000 Millisekunden
</script>
<?php endif; ?>



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
    <div class="container-sm">
        <h1><?= $lang['profil_bearbeiten'] ?></h1>
        <form class="row g-3 delete-form" method="POST" action="update.php">
            <div class="col-md-4">
                <label for="validationDefault01" class="form-label"><?= $lang['vorname'] ?></label>
                <input type="text" class="form-control" id="vorname" name="vorname" value="<?php echo htmlspecialchars($vorname);?>">
            </div>
            <div class="col-md-4">
                <label for="validationDefault02" class="form-label"><?= $lang['nachname'] ?></label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name);?>">
            </div>
            <div class="col-md-4">
                <label for="validationDefaultUsername" class="form-label"><?= $lang['username'] ?></label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend2">@</span>
                    <input type="text" class="form-control" id="benutzername" name="benutzername" value="<?php echo htmlspecialchars($benutzername);?>" aria-describedby="inputGroupPrepend2" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationDefault03" class="form-label"><?= $lang['unternehmen'] ?></label>
                <input type="text" class="form-control" id="unternehmen" name="unternehmen" value="<?php echo htmlspecialchars($unternehmen);?>">
            </div>
            <div class="col-md-4">
                <label for="validationDefault04" class="form-label"><?= $lang['email'] ?></label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email);?>">
            </div>
            <div class="col-md-4">
                <label for="validationDefault05" class="form-label"><?= $lang['beruf'] ?></label>
                <input type="text" class="form-control" id="beruf" name="beruf" value="<?php echo htmlspecialchars($beruf);?>">
            </div>
            <h5> Rechnungsanschrifft </h5>
            <div class="col-md-4">
                <label for="validationDefault06" class="form-label"><?= $lang['straße'] ?></label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo htmlspecialchars($adresse);?>"> 
            </div>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label"><?= $lang['plz'] ?></label>
                <input type="number" class="form-control" id="plz" name="plz" value="<?php echo htmlspecialchars($plz);?>" >
            </div>
            <div class="col-md-4">
                <label for="validationDefault08" class="form-label"><?= $lang['stadt'] ?></label>
                <input type="text" class="form-control" id="stadt" name="stadt" value="<?php echo htmlspecialchars($stadt);?>">
            </div>
            <div class="row mt-3">
                <div class="col-md-2 mb-3">
                    <button class="btn btn-primary" type="submit" name="action" value="save"><?= $lang['daten_speichern'] ?></button>
                </div>
                <div class="col-md-2 mb-3">
                    <button class="btn btn-danger" type="submit" name="action" value="delete" onclick="return confirmDelete();"><?= $lang['profil_löschen'] ?></button>
                </div>
            </div>

            
        </form>
        <script>
function confirmDelete() {
    Swal.fire({
        title: '<?= $lang['sind_sie_sicher'] ?>',
        text: "<?= $lang['wirklich'] ?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<?= $lang['ja_löschen'] ?>',
        cancelButtonText: '<?= $lang['nein_abbrechen'] ?>'
    }).then((result) => {
        if (result.isConfirmed) {
            // Erstelle ein verstecktes Input-Element, das die Aktion spezifiziert
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'delete';
            // Füge das versteckte Element zum Formular hinzu und reiche es ein
            var form = document.querySelector('.delete-form');
            form.appendChild(input);
            form.submit();
        }
    });
    return false; // Verhindere das Standardverhalten des Buttons
}

        </script>

    </div>

    <div style="min-height: 22vh;">
        <br>
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
        <div class="footer-subsidiary" style="padding: 1%">
            <p><strong>ifm business solutions</strong><br /> Martinshardt 19<br /> 57074&nbsp;Siegen
            </p>
            <p><strong>Hotline 0800 / 16 16 16 4</strong><br />
                <strong>E-Mail&nbsp;</strong><a href="mailto:info@ifm.com">info@ifm.com</a></p>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</body>

</html>
