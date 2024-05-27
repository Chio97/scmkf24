<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="5;url=login.php"> 
    <title>Registrierung Erfolgreich</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <?php
                session_start();
                if (!isset($_SESSION['lang'])) {
                    $_SESSION['lang'] = 'de';
                }
                if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
                    $_SESSION['lang'] = $_GET['lang'];
                }
            
                $lang = require 'languages/' . $_SESSION['lang'] . '.php';
            
                if (isset($_SESSION['notification'])) {
                    echo $_SESSION['notification'];
                    unset($_SESSION['notification']); // Benachrichtigung aus der Session entfernen
                }
            ?>
            <br><?= $lang['weitergeleitet'] ?>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'newindex.php'; 
        }, 5000);
    </script>
</body>
</html>
