<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-box {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .error {
            color: red; 
        }
    </style>
</head>
<?php
session_start();
// Spracheinstellungen
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
}
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
    $_SESSION['lang'] = $_GET['lang']; // Sprache ändern
}
// Sprachdatei
$lang = require 'languages/' . $_SESSION['lang'] . '.php';
?>
<body>
    <div class="login-box">
        <form id="loginForm" action="login2.php" method="post">
            <div class="text-center mb-4">
                <img src="images/logo.png" alt="Logo" style="width: 100px;">
            </div>
            <div class="text-end">
                <a href="?lang=de">DE</a> | <a href="?lang=en">EN</a>
            </div>
            <h3><?= $lang['welcome'] ?></h3> 
            <?php if(isset($_SESSION['error']) && isset($lang[$_SESSION['error']])): ?>
                <div class="error">
                    <?= $lang[$_SESSION['error']]; unset($_SESSION['error']); ?>
                </div>
            <?php else: ?>
                <div class="error" style="display: none;"></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="benutzername" class="form-label"><?= $lang['username'] ?></label> 
                <input type="text" class="form-control" id="benutzername" name="benutzername">
            </div>
            <div class="mb-3">
                <label for="passwort" class="form-label"><?= $lang['password'] ?></label> 
                <input type="password" class="form-control" id="passwort" name="passwort">
            </div>
            <button type="submit" class="btn btn-primary"><?= $lang['login'] ?></button> 
            <div class="mb-3 text-center">
                <a href="passwort_zurueck.php"><?= $lang['passwort_vergessen'] ?></a>
            </div>
            <div class="mt-3 text-center">
                <a href="neueskonto.php"><?= $lang['no_account'] ?></a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('loginForm');
            const lang = '<?= $_SESSION['lang'] ?>';

            form.noValidate = true;

            form.addEventListener('submit', function(event) {
                let isValid = true;
                const username = document.getElementById('benutzername');
                const password = document.getElementById('passwort');
                const usernameError = lang === 'de' ? 'Bitte geben Sie Ihren Benutzernamen ein.' : 'Please enter your username.';
                const passwordError = lang === 'de' ? 'Bitte geben Sie Ihr Passwort ein.' : 'Please enter your password.';

    
                username.setCustomValidity('');
                password.setCustomValidity('');

                if (!username.value) {
                    isValid = false;
                    username.setCustomValidity(usernameError);
                }

                if (!password.value) {
                    isValid = false;
                    password.setCustomValidity(passwordError);
                }

                if (!isValid) {

                    username.reportValidity();
                    password.reportValidity();
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
