<?php 
session_start();
include 'db.php'; // Stellen Sie sicher, dass Ihre Datenbankverbindungsdatei richtig einbinden


if (!isset($_SESSION['benutzername'])) {
    echo "<p class='alert alert-danger'>Bitte zuerst einloggen.</p>";
} else {
    $benutzername = $_SESSION['benutzername'];

    if (!isset($_SESSION['lang'])) {

        $_SESSION['lang'] = 'de'; // Standardmäßig Deutsch
    }
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'de'])) {
        $_SESSION['lang'] = $_GET['lang']; // Sprache ändern, wenn über GET-Parameter angefordert
    }
    $lang = require 'languages/' . $_SESSION['lang'] . '.php';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Reservations</title>
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

            object-fit: cover;

        }
        
        .container.mt-4 {
            margin-bottom: 180px;
        }
    </style>
</head>

<body>
<?php include 'nav.php'; ?>

    <div class="container mt-4">
        <h1><?= $lang['meine_reservierungen'] ?></h1>
        <?php

    
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
            echo "<thead><tr><th>" . $lang['reservierungsid'] . "</th><th>" . $lang['termin'] . "</th><th>" . $lang['modul'] . "</th><th>" . $lang['schulungsart'] . "</th><th>" . $lang['sprache'] . "</th><th>" . $lang['vorname'] . "</th><th>" . $lang['nachname'] . "</th><th>" . $lang['username'] . "</th><th>" . $lang['rechnung'] . "</th></tr></thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {


                $bezahltString = $row['bezahlt'] ? $lang['bezahlt'] : $lang['nicht_bezahlt'];
                $bezahltClass = $row['bezahlt'] ? "text-success" : "text-danger";


                $reservierungsid = isset($row['reservierungsid']) ? htmlspecialchars($row['reservierungsid']) : '';
                $termin = isset($row['termin']) ? htmlspecialchars($row['termin']) : '';
                $modul_schwierigkeit = isset($row['modul_schwierigkeit']) ? htmlspecialchars($row['modul_schwierigkeit']) : '';
                $schulungsart = isset($row['schulungsart']) ? htmlspecialchars($row['schulungsart']) : '';
                $sprache = isset($row['sprache']) ? htmlspecialchars($row['sprache']) : '';
                $vorname = isset($row['vorname']) ? htmlspecialchars($row['vorname']) : '';
                $name = isset($row['name']) ? htmlspecialchars($row['name']) : '';
                $benutzername = isset($row['benutzername']) ? htmlspecialchars($row['benutzername']) : '';
                $traeger_vorname = isset($row['traeger_vorname']) ? htmlspecialchars($row['traeger_vorname']) : '';
                $traeger_nachname = isset($row['traeger_nachname']) ? htmlspecialchars($row['traeger_nachname']) : '';
                $strasse = isset($row['strasse']) ? htmlspecialchars($row['strasse']) : '';
                $stadt = isset($row['stadt']) ? htmlspecialchars($row['stadt']) : '';
                $plz = isset($row['plz']) ? htmlspecialchars($row['plz']) : '';
            
                echo "<tr>
                        <td>" . $reservierungsid . "</td>
                        <td>" . $termin . "</td>
                        <td>" . $modul_schwierigkeit . "</td>
                        <td>" . $schulungsart . "</td>
                        <td>" . $sprache . "</td>
                        <td>" . $vorname . "</td>
                        <td>" . $name . "</td>
                        <td>" . $benutzername . "</td>
                        <td class='$bezahltClass'>" . $bezahltString . "</td>
                        <td> 
                        <form class='delete-form' method='POST' action='stornieren.php'>
            <input type='hidden' name='reservierungsid' value='" . $reservierungsid . "'>
            <button type='button' onclick='confirmDelete(this.form)' class='btn btn-danger'>" . $lang['reservierung_stornieren'] . "</button>
            </form>
            <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#rechnungstraegerModal" . $reservierungsid . "'>
            <i class='fas fa-info-circle'></i> " . $lang['rechnungsträger'] . "
            </button>
            </td>
            </tr>";

                echo "<div class='modal fade' id='rechnungstraegerModal" . $reservierungsid . "' tabindex='-1' aria-labelledby='rechnungstraegerModalLabel" . $reservierungsid . "' aria-hidden='true'>
                      <div class='modal-dialog modal-dialog-centered'>
                          <div class='modal-content'>
                              <div class='modal-header'>
                                  <h5 class='modal-title' id='rechnungstraegerModalLabel" . $reservierungsid . "'>" . $lang['rechnungsträger_information'] . "</h5>
                                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                              </div>
                              <div class='modal-body'>
                                  <p><strong>" . $lang['vorname'] . " : </strong> " . $traeger_vorname . "</p>
                                  <p><strong>". $lang['nachname'] ." : </strong> " . $traeger_nachname . "</p>
                                  <p><strong>". $lang['straße'] ." : </strong> " . $strasse . "</p>
                                  <p><strong>". $lang['stadt'] ." : </strong> " . $stadt . "</p>
                                  <p><strong>". $lang['plz'] ." : </strong> " . $plz . "</p>
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
            echo "<p class='alert alert-info'>" . $lang['keine_reservierungen_gefunden'] . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<p class='alert alert-danger'>Fehler: " . $conn->error . "</p>";
    }
    $conn->close();
}
?>
<div>
    <p><?= $lang['erhalt_rechnung'] ?></p>
    <p><?= $lang['wenn_rechnung_bezahlt'] ?></p>
</div>




    </div>

    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
    <script>
function confirmDelete(form) {
    Swal.fire({
        title: '<?= $lang['sind_sie_sicher'] ?>',
        text: "<?= $lang['wirklich_stornieren'] ?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<?= $lang['ja_löschen'] ?>',
        cancelButtonText: '<?= $lang['nein_abbrechen'] ?>'
    }).then((result) => {
        if (result.isConfirmed) {
            
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'delete';

            form.appendChild(input);
            form.submit();
        }
    });
    return false; 
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