<?php
session_start();
include 'db.php';

if (!isset($_SESSION['benutzername'])) {
    // Keine Session vorhanden, also Umleitung zur Login-Seite
    header("Location: newindex.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT passwort FROM nutzerdaten WHERE benutzername = ?");
    $stmt->bind_param("s", $_SESSION['benutzername']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        // Überprüfen, ob das eingegebene alte Passwort mit dem in der Datenbank gespeicherten Passwort übereinstimmt
        if (password_verify($old_password, $db_password) && $new_password === $confirm_password) {
            // Neues Passwort hashen
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $update_stmt = $conn->prepare("UPDATE nutzerdaten SET passwort = ? WHERE benutzername = ?");
            $update_stmt->bind_param("ss", $new_password_hash, $_SESSION['benutzername']);
            if ($update_stmt->execute()) {
                $message = "Passwort erfolgreich geändert!";
            } else {
                $message = "Fehler beim Aktualisieren des Passworts: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            $message = "Das alte Passwort ist nicht korrekt oder die neuen Passwörter stimmen nicht überein.";
        }
        $stmt->close();
    } else {
        $message = "Fehler beim Abrufen des alten Passworts.";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link active" aria-current="page" href="mainseite.php">Hauptseite</a>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Schulungen</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="opeinst.php">Operations für Einsteiger*innen</a></li>
                                <li><a class="dropdown-item" href="opefort.php">Operations für Fortgeschrittene</a></li>
                                <li><a class="dropdown-item" href="coeinst.php">Controlling für Einsteiger*innen</a></li>
                                <li><a class="dropdown-item" href="cofortg.php">Controlling für Fortgeschrittene</a></li>
                            </ul>
                        </li>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="kontakt.php">Kontakt</a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="d-flex" style="width: 11%">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownProfileLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/profil.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">Profil
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownProfileLink">
                    <li><a class="dropdown-item" href="profilanzeigen.php">Profil anzeigen</a></li>
                    <li><a class="dropdown-item" href="logout.php">Abmelden</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
    <h2>Passwort ändern</h2>
    <?php if (!empty($message)): ?>
        <div id="alert-box" class="alert <?php echo strpos($message, 'erfolgreich') !== false ? 'alert-success' : 'alert-danger'; ?>" role="alert" >
            <?php echo $message; ?>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('alert-box').style.display = 'none';
            }, 5000);
        </script>
    <?php endif; ?>
    <form action="passwort.php" method="post" class="mt-4">
        <div class="mb-3 position-relative">
            <label for="old_password" class="form-label">Altes Passwort:</label>
            <input type="password" class="form-control" id="old_password" name="old_password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor: pointer; margin-top: 1rem;" onclick="togglePassword('old_password')">
                <i class="fa fa-eye" id="toggleOldPassword"></i>
            </span>
        </div>
        <div class="mb-3 position-relative">
            <label for="new_password" class="form-label">Neues Passwort:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor: pointer; margin-top: 1rem;" onclick="togglePassword('new_password')">
                <i class="fa fa-eye" id="toggleNewPassword"></i>
            </span>
        </div>
        <div class="mb-3 position-relative">
            <label for="confirm_password" class="form-label">Passwort bestätigen:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor: pointer; margin-top: 1rem;" onclick="togglePassword('confirm_password')">
                <i class="fa fa-eye" id="toggleConfirmPassword"></i>
            </span>
        </div>
        <button type="submit" class="btn btn-primary">Passwort ändern</button>
    </form>
</div>
<script>
function togglePassword(field_id) {
    var input = document.getElementById(field_id);
    var eyeIcon = document.getElementById('toggle' + field_id.charAt(0).toUpperCase() + field_id.slice(1));
    if (input.type === "password") {
        input.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>




    <div style="min-height: 26vh;">
        <br>
    </div>
    <nav class="navbar bg-body-tertiary">

        <nav class="nav flex-column">
            <a class="nav-link" href="agb.html">AGB</a>
            <a class="nav-link" href="impressum.html">Impressum</a>
            <a class="nav-link" href="datenschutz.html">Datenschutz</a>
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
    <script>
        window.onload = function() {
            // Wenn eine Nachricht vorhanden ist, blende sie nach 5 Sekunden aus
            if (document.getElementById('alert-box').innerHTML.trim() !== '') {
                setTimeout(function() {
                    document.getElementById('alert-box').style.display = 'none';
                }, 3000);
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>

</body>

</html>