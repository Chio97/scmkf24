<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hauptseite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .card-img-top {
            height: 200px;
            /* Fixiert die Höhe der Bilder */
            object-fit: cover;
            /* Sorgt dafür, dass die Bilder gut aussehen */
        }
        
        .container.mt-4 {
            margin-bottom: 340px;
        }
    </style>
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
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Schulungen
                </a>
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
            <div class="d-flex" style="width: 11%">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownProfileLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="images/profil.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top"> Profil
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownProfileLink">
                        <li><a class="dropdown-item" href="profilanzeigen.php">Profil bearbeiten</a></li>
                        <li><a class="dropdown-item" href="logout.php">Abmelden</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <div class="container mt-4">
        <h1>Meine Reservierungen</h1>
        <?php
session_start();
include 'db.php'; // Stellen Sie sicher, dass Ihre Datenbankverbindungsdatei richtig einbinden

if (!isset($_SESSION['benutzername'])) {
    echo "<p class='alert alert-danger'>Bitte zuerst einloggen.</p>";
} else {
    $benutzername = $_SESSION['benutzername'];

    if (isset($_SESSION['notification'])) {
        echo "<div id='notification-alert' class='alert alert-success'>" . $_SESSION['notification'] . "</div>";
        unset($_SESSION['notification']); // Benachrichtigung aus der Session entfernen
    }

    $sql = "SELECT 
                r.reservierungsid,
                r.termin,
                r.strasse,
                r.stadt,
                r.plz,
                r.traeger_vorname,
                r.traeger_nachname,
                r.bezahlt,
                CONCAT(s.modul, ' ', s.schwierigkeitsgrad) AS modul_schwierigkeit,
                s.schulungsart,
                s.sprache,
                nd.vorname, 
                nd.name,
                nd.benutzername
            FROM 
                nutzerdaten nd
            JOIN 
                reservierung r ON nd.benutzername = r.benutzername
            JOIN 
                schulungen s ON r.termin = s.termin
            WHERE 
                nd.benutzername = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $benutzername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead><tr><th>ReservierungsID</th><th>Termin</th><th>Modul</th><th>Schulungsart</th><th>Sprache</th><th>Vorname</th><th>Nachname</th><th>Benutzername</th><th>Rechnung</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {

                $bezahltString = $row['bezahlt'] ? "Bezahlt" : "Nicht Bezahlt";
                $bezahltClass = $row['bezahlt'] ? "text-success" : "text-danger";
                echo "<tr>
                        <td>" . htmlspecialchars($row['reservierungsid']) . "</td>
                        <td>" . htmlspecialchars($row['termin']) . "</td>
                        <td>" . htmlspecialchars($row['modul_schwierigkeit']) . "</td>
                        <td>" . htmlspecialchars($row['schulungsart']) . "</td>
                        <td>" . htmlspecialchars($row['sprache']) . "</td>
                        <td>" . htmlspecialchars($row['vorname']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['benutzername']) . "</td>
                        <td class='$bezahltClass'>" . htmlspecialchars($bezahltString) . "</td>
                        <td> 
                        <form class='delete-form' method='POST' action='stornieren.php'>
                        <input type='hidden' name='reservierungsid' value='" . $row['reservierungsid'] . "'>
                        <button type='button' onclick='confirmDelete(this.form)' class='btn btn-danger'>Reservierung stornieren</button>
                    </form>
                    <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#rechnungstraegerModal" . $row['reservierungsid'] . "'>
                    <i class='fas fa-info-circle'></i> Rechnungsträger
                </button>
                        </td>
                      </tr>";
                      echo "<div class='modal fade' id='rechnungstraegerModal" . $row['reservierungsid'] . "' tabindex='-1' aria-labelledby='rechnungstraegerModalLabel" . $row['reservierungsid'] . "' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='rechnungstraegerModalLabel" . $row['reservierungsid'] . "'>Rechnungsträger Informationen</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <p><strong>Vorname:</strong> " . htmlspecialchars($row['traeger_vorname']) . "</p>
                                            <p><strong>Nachname:</strong> " . htmlspecialchars($row['traeger_nachname']) . "</p>
                                            <p><strong>Straße:</strong> " . htmlspecialchars($row['strasse']) . "</p>
                                            <p><strong>Stadt:</strong> " . htmlspecialchars($row['stadt']) . "</p>
                                            <p><strong>PLZ:</strong> " . htmlspecialchars($row['plz']) . "</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Schließen</button>
                                        </div>
                                    </div>
                                </div>
                              </div>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='alert alert-info'>Keine Reservierungen gefunden.</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='alert alert-danger'>Fehler: " . $conn->error . "</p>";
    }
    $conn->close();
}
?>
<div>
    <p>Nach Erhalt der Rechnung haben Sie 14 Tage Zeit, die Rechnung abzugleichen. Andernfalls wird die Reservierung gelöscht.</p>
    <p>Wenn die Rechnung bezahlt wurde, erhalten Sie 48 Stunden vor Kursbeginn Zugangsdaten für das SAP-System.</p>
</div>




    </div>

    <nav class="navbar fixed-bottom bg-body-tertiary ">

        <nav class="nav flex-column ">
            <a class="nav-link " href="agb.html ">AGB</a>
            <a class="nav-link " href="impressum.html ">Impressum</a>
            <a class="nav-link " href="datenschutz.html ">Datenschutz</a>
        </nav>
        <div class="footer-social ">
            <div class="footer-copyright ">© ifm electronic gmbh 2024</div>
        </div>
        <div class="footer-subsidiary "style="padding: 1%">
            <p><strong>ifm business solutions</strong><br /> Martinshardt 19<br /> 57074&nbsp;Siegen
            </p>
            <p><strong>Hotline 0800 / 16 16 16 4</strong><br />
                <strong>E-Mail&nbsp;</strong><a href="mailto:info@ifm.com ">info@ifm.com</a></p>
        </div>
    </nav>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
    <script>
function confirmDelete(form) {
    Swal.fire({
        title: 'Sind Sie sicher?',
        text: "Möchten Sie diese Reservierung wirklich stornieren?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ja, stornieren!',
        cancelButtonText: 'Nein, abbrechen!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Erstelle ein verstecktes Input-Element, das die Aktion spezifiziert
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'delete';
            // Füge das versteckte Element zum Formular hinzu und reiche es ein
            form.appendChild(input);
            form.submit();
        }
    });
    return false; // Verhindere das Standardverhalten des Buttons
}
</script>

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