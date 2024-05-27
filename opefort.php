<?php include 'dbverb.php';?>
<body>
<title>Operations Advanced</title>
<?php include 'nav.php'; ?>
<style>
        .card-body .card-title,
        .card-body .card-text {
            color: #333; /* Dunkelgraue Farbe */
        }

</style>

    <div class="container-fluid mb">
        <div class="row">
            <!-- Spalte für das Bild -->
            <div class="col-lg-8">
                <img src="images/operations_fortgeschrittene_1704x717.jpg" class="img-fluid" alt="...">
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
                        <p class="card-text">Erfahrene Anwender der Module GIB Suite Controlling und Operations</p>
                        <h5 class="card-title"><?= $lang['teilnehmergebühr'] ?></h5>
                        <p class="card-text">580 €</p>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-orange me-md-2 fs-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <?= $lang['buchen'] ?>
                                                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog text-dark">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $lang['buchen_op_f'] ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" method="POST" action="buche_opefort.php">
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
                                                <input type="text" class="form-control" id="validationDefault02" value="<?php echo htmlspecialchars($userData['name'] ?? ''); ?>" name="traeger_nachname"required>
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
                                                <input type="text" class="form-control" id="validationDefault03" value="<?php echo htmlspecialchars($userData['adresse'] ?? ''); ?>"name="strasse" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="validationDefault04" class="form-label"><?= $lang['stadt'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault04"  value="<?php echo htmlspecialchars($userData['stadt'] ?? ''); ?>" name="stadt" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="validationDefault05" class="form-label"><?= $lang['plz'] ?></label>
                                                <input type="text" class="form-control" id="validationDefault05" value="<?php echo htmlspecialchars($userData['plz'] ?? ''); ?>" name="plz" required>
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
                                                <button class="btn btn-orange" type="submit"><?= $lang['jetzt_buchen'] ?></button>
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
        <p class="fs-2"><strong><?= $lang['textblock1_ü'] ?></strong></p>
        <blockquote class="blockquote">
            <p><?= $lang['textblock1_t'] ?></p>
        </blockquote>
    </div>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['ihr_nutzen'] ?></strong></p>
        <blockquote class="blockquote">
            <p><?= $lang['ihrnutzen_t_o_f'] ?></p>
        </blockquote>
    </div>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['erwartung'] ?></strong></p>
    </div>
    <blockquote class="blockquote">
        <ul class="list-unstyled">
            <ul>
                <li><?= $lang['erwartung_o_f1'] ?></li>
                <li><?= $lang['erwartung_o_f2'] ?></li>
                <li><?= $lang['erwartung_o_f3'] ?></li>
            </ul>
        </ul>
    </blockquote>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['an_wen'] ?></strong></p>
    </div>
    <blockquote class="blockquote">
        <ul class="list-unstyled">
            <ul>
                <li><?= $lang['an_wen_o_f1'] ?></li>
                <li><?= $lang['an_wen_o_f2'] ?></li>
                <li><?= $lang['an_wen_o_f3'] ?></li>
                <li><?= $lang['an_wen_o_f4'] ?></li>
               </ul>
        </ul>
    </blockquote>
    <div class="container-fluid">
        <p class="fs-2"><strong><?= $lang['exclusive'] ?></strong></p>
        <blockquote class="blockquote">
            <p><li><?= $lang['exclusive_t1'] ?></li> <a href="mailto:serxhio.zani@berater.ifm">serxhio.zani@berater.ifm</a> <li><?= $lang['exclusive_t2'] ?></li>
            </p>
        </blockquote>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    function fetchTermine() {
        var sprache = document.getElementById('spracheSelect').value;
        var schulungsart = document.getElementById('schulungsartSelect').value;
        var modul = 'Operations';  // Beispielwert, setzen Sie den tatsächlichen Wert hier
        var schwierigkeitsgrad = 'Fortgeschritten';  // Beispielwert, anpassbar je nach Seite oder Kontext

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</html>