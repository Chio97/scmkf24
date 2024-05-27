<?php
session_start();
include 'db.php';

if (!isset($_SESSION['benutzername'])) {
    // Keine Session vorhanden, also Umleitung zur Login-Seite
    header("Location: newindex.php");
    exit;
}

$message = "";
$message_class = "";

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
}
$lang = require 'languages/' . $_SESSION['lang'] . '.php';

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
                $message = $lang['passwort_geaendert'];
                $message_class = "alert-success"; // success message
            } else {
                $message = $lang['passwort_nicht_geaendert'] . $update_stmt->error;
                $message_class = "alert-danger"; // error message
            }
            $update_stmt->close();
        } else {
            $message = $lang['passwort_fehler'];
            $message_class = "alert-danger"; // error message
        }
        $stmt->close();
    } else {
        $message = $lang['passwort_abruf_fehler'];
        $message_class = "alert-danger"; // error message
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort ändern</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body><?php include 'nav.php'; ?>

<div class="container mt-3">
    <h2>Passwort ändern</h2>
    <?php if (!empty($message)): ?>
        <div id="alert-box" class="alert <?php echo $message_class; ?>" role="alert">
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
            <label for="old_password" class="form-label"><?= $lang['altes_passwort'] ?></label>
            <input type="password" class="form-control" id="old_password" name="old_password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor: pointer; margin-top: 1rem;" onclick="togglePassword('old_password')">
                <i class="fa fa-eye" id="toggleOldPassword"></i>
            </span>
        </div>
        <div class="mb-3 position-relative">
            <label for="new_password" class="form-label"><?= $lang['neues_passwort'] ?></label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor: pointer; margin-top: 1rem;" onclick="togglePassword('new_password')">
                <i class="fa fa-eye" id="toggleNewPassword"></i>
            </span>
        </div>
        <div class="mb-3 position-relative">
            <label for="confirm_password" class="form-label"><?= $lang['passwort_bestätigen'] ?></label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" style="cursor: pointer; margin-top: 1rem;" onclick="togglePassword('confirm_password')">
                <i class="fa fa-eye" id="toggleConfirmPassword"></i>
            </span>
        </div>
        <button type="submit" class="btn btn-primary"><?= $lang['passwort_ändern'] ?></button>
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

<div style="min-height: 6vh;">
    <br>
</div>
<?php include 'footer.php'; ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
