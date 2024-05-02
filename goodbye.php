<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="5;url=login.php"> <!-- Automatische Weiterleitung nach 5 Sekunden -->
    <title>Profil gelöscht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            Profil erfolgreich gelöscht. Sie werden gleich weitergeleitet...
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'newindex.php'; // Sicherstellen, dass JavaScript die Seite umleitet, falls der Meta-Refresh nicht funktioniert
        }, 5000);
    </script>
</body>
</html>
