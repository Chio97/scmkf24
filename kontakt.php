    <?php
    include 'db.php';
    include 'sprache.php';

        // Annahme: Der Benutzername ist in $_SESSION['benutzername'] gespeichert

        // SQL-Abfrage vorbereiten
        $sql = "SELECT email FROM nutzerdaten WHERE benutzername = '" . $_SESSION['benutzername'] . "'";

        // Abfrage ausführen
        $result = $conn->query($sql);

        // Überprüfen, ob die Abfrage erfolgreich war
        if ($result->num_rows > 0) {
            // E-Mail-Adresse aus dem Abfrageergebnis abrufen und in $email speichern
            $row = $result->fetch_assoc();
            $email = $row["email"];
        } else {
            // Fallback, falls kein Ergebnis gefunden wurde
            $email = "";
        }
            // Erfolgsmeldung anzeigen, wenn vorhanden 
    if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert" id="successMessage">
            <?php echo $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); // Erfolgsmeldung entfernen ?>
        <?php endif; ?>

    <body>
    <title>Contact</title>
    <?php include 'nav.php'; ?>
    
    <div style="margin-top: 5px; margin-bottom: 3px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><?= $lang['kontaktieren_sie'] ?></h2>
                <p><?= $lang['ausfüllen_kontakt'] ?></p>
                <form action="kontaktformular.php" method="POST" onsubmit="return validateForm()">
                <div class="mb-3">
                <label for="name" class="form-label"><?= $lang['username'] ?></label>
                <input type="text" class="form-control" id="benutzername" value="<?php echo htmlspecialchars($_SESSION['benutzername'] ?? ''); ?>" name="benutzername">
                <div id="benutzernameError" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><?= $lang['email'] ?></label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <div id="emailError" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="betreff" class="form-label"><?= $lang['betreff'] ?></label>
                <input type="text" class="form-control" id="betreff" name="betreff">
                <div id="betreffError" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="nachricht" class="form-label"><?= $lang['nachricht'] ?></label>
                <textarea class="form-control" id="nachricht" name="nachricht" rows="5"></textarea>
                <div id="nachrichtError" class="text-danger"></div>
            </div>

                    <button type="submit" class="btn btn-orange"><?= $lang['nachricht_senden'] ?></button>
                </form>
            </div>
            <div class="col-md-6">
                <h2><?= $lang['kontaktinfo'] ?></h2>
                <p><strong>Telefon:</strong> <a href="tel:08001616164">0800 / 16 16 16 4</a></p>
                <p><strong>E-Mail:</strong> <a href="mailto:serxhio.zani@ifm.com">serxhio.zani@ifm.com</a></p>
                <p><strong><?= $lang['büroadresse'] ?>:</strong><br>
                    The SUMMIT<br>
                    ifm business solutions<br>
                    Martinshardt 19<br>
                    57074 Siegen</p>
                <!-- Google Maps Integration -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2542.8654975429266!2d8.02824675466841!3d50.85104292180763!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b9c9c1d96d3b1d%3A0xe01f3035eeec5a02!2sifm%20electronic%20gmbh!5e0!3m2!1sen!2sde!4v1643717208249!5m2!1sen!2sde" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                <!-- Social Media Links -->
                <h2 style="margin-top: 1%; margin-bottom: 3%;"><?= $lang['folgen_sie'] ?></h2>
                <a href="https://www.facebook.com/ifmsupplychain" class="btn btn-outline-primary"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="https://twitter.com/ifmelectronic" class="btn btn-outline-primary"><i class="fab fa-twitter"></i> Twitter</a>
                <a href="https://www.linkedin.com/company/ifm-supply-chain/" class="btn btn-outline-primary"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
    <script>
function validateForm() {
    var benutzername = document.getElementById('benutzername').value;
    var email = document.getElementById('email').value;
    var betreff = document.getElementById('betreff').value;
    var nachricht = document.getElementById('nachricht').value;

    // Meldungen in Deutsch
    var benutzernameErrorDE = "Bitte geben Sie Ihren Benutzernamen ein.";
    var emailErrorDE = "Bitte geben Sie Ihre E-Mail-Adresse ein.";
    var betreffErrorDE = "Bitte geben Sie den Betreff ein.";
    var nachrichtErrorDE = "Bitte geben Sie Ihre Nachricht ein.";

    // Meldungen in Englisch
    var benutzernameErrorEN = "Please enter your username.";
    var emailErrorEN = "Please enter your email address.";
    var betreffErrorEN = "Please enter the subject.";
    var nachrichtErrorEN = "Please enter your message.";

    // Setzen der entsprechenden Meldungen basierend auf der aktuellen Sprache
    var benutzernameError, emailError, betreffError, nachrichtError;
    if ("<?= $_SESSION['lang'] ?>" === "de") {
        benutzernameError = benutzernameErrorDE;
        emailError = emailErrorDE;
        betreffError = betreffErrorDE;
        nachrichtError = nachrichtErrorDE;
    } else {
        benutzernameError = benutzernameErrorEN;
        emailError = emailErrorEN;
        betreffError = betreffErrorEN;
        nachrichtError = nachrichtErrorEN;
    }

    if (benutzername === "") {
        document.getElementById('benutzernameError').innerText = benutzernameError;
        return false;
    } else {
        document.getElementById('benutzernameError').innerText = "";
    }

    if (email === "") {
        document.getElementById('emailError').innerText = emailError;
        return false;
    } else {
        document.getElementById('emailError').innerText = "";
    }

    if (betreff === "") {
        document.getElementById('betreffError').innerText = betreffError;
        return false;
    } else {
        document.getElementById('betreffError').innerText = "";
    }

    if (nachricht === "") {
        document.getElementById('nachrichtError').innerText = nachrichtError;
        return false;
    } else {
        document.getElementById('nachrichtError').innerText = "";
    }

    return true;
}



    document.addEventListener('DOMContentLoaded', function() {
        // Funktion zum Ausblenden der Meldung nach 5 Sekunden
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz " crossorigin="anonymous "></script>
</body>

</html>
